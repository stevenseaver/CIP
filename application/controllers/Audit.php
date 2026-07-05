<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Adjust if your auth check lives elsewhere
        if (!$this->session->userdata('nik')) {
            redirect('auth/login');
        }
    }

    public function trail()
    {
        $data['title'] = 'Audit Trails';
        $data['user']  = $this->db->get_where('user', [
            'nik' => $this->session->userdata('nik'),
        ])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('audit/audit_trail', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Server-side DataTables endpoint.
     * GET /audit/trailData
     *
     * Only fetches the columns needed for the list view (excludes the
     * long state_before / state_after text) and only the current page
     * of rows (LIMIT/OFFSET), sorted and filtered in SQL.
     */
    public function trailData()
    {
        $draw   = (int) $this->input->get('draw');
        $start  = (int) $this->input->get('start');
        $length = (int) $this->input->get('length');
        $length = $length > 0 ? $length : 25;

        $searchValue = trim((string) $this->input->get('search[value]'));

        $orderCol = (int) $this->input->get('order[0][column]');
        $orderDir = strtolower((string) $this->input->get('order[0][dir]'));
        $orderDir = ($orderDir === 'asc') ? 'asc' : 'desc';

        // Maps DataTables column index -> real, indexed DB column.
        // Only columns that are actually orderable in the view's JS
        // config need to be listed here.
        $columnMap = [
            1  => 'user_id',
            2  => 'username',
            4  => 'table_name',
            10 => 'ip_address',
            11 => 'created_at',
        ];
        $orderColumn = $columnMap[$orderCol] ?? 'created_at';

        // Total rows, unfiltered — cheap, hits the PK.
        $recordsTotal = $this->db->count_all('audit_trail');

        // Reusable filter closure so count + data queries stay in sync.
        $applyFilter = function () use ($searchValue) {
            if ($searchValue !== '') {
                $this->db->group_start();
                $this->db->like('username', $searchValue);
                $this->db->or_like('action', $searchValue);
                $this->db->or_like('table_name', $searchValue);
                $this->db->or_like('reference', $searchValue);
                $this->db->or_like('ip_address', $searchValue);
                $this->db->group_end();
            }
        };

        $applyFilter();
        // NOTE: passing `false` here previously left CI's query builder
        // un-reset after the count, so the very next from('audit_trail')
        // below produced "FROM audit_trail, audit_trail" (Error 1066:
        // Not unique table/alias). Reset explicitly instead.
        $recordsFiltered = $this->db->count_all_results('audit_trail', false);
        $this->db->reset_query();

        // Only select what the list view renders. state_before /
        // state_after are intentionally excluded — fetched on demand
        // via trailDetail() so the paginated payload stays small.
        $this->db->select('id, user_id, username, action, table_name, row, reference, ip_address, created_at');
        $this->db->from('audit_trail');
        $applyFilter();
        $this->db->order_by($orderColumn, $orderDir);
        $this->db->limit($length, $start);
        $rows = $this->db->get()->result_array();

        $data = [];
        $no = $start + 1;
        foreach ($rows as $au) {
            $data[] = [
                'no'         => $no++,
                'id'         => $au['id'],
                'user_id'    => $au['user_id'],
                'username'   => htmlspecialchars($au['username']),
                'action'     => htmlspecialchars($au['action']),
                'table_name' => htmlspecialchars($au['table_name']),
                'row'        => htmlspecialchars($au['row']),
                'reference'  => htmlspecialchars($au['reference']),
                'ip_address' => $au['ip_address'],
                'created_at' => $au['created_at'],
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]));
    }

    /**
     * Returns the full state_before / state_after text for a single
     * row, fetched only when the user opens the details modal.
     * GET /audit/trailDetail/{id}
     */
    public function trailDetail($id = null)
    {
        $id = (int) $id;

        if (!$id) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Invalid id']));
        }

        $row = $this->db->select('id, user_id, username, action, table_name, row, reference, state_before, state_after, ip_address, created_at')
            ->get_where('audit_trail', ['id' => $id])
            ->row_array();

        if (!$row) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Not found']));
        }

        // Escape for safe injection into the modal via .text()/.html()
        // on the client; client code below uses textContent so this is
        // belt-and-braces.
        foreach (['username', 'action', 'table_name', 'row', 'reference', 'state_before', 'state_after'] as $field) {
            $row[$field] = htmlspecialchars((string) $row[$field]);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $row]));
    }
}