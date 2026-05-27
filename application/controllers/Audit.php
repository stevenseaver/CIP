<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    // public function trail()
    // {
    //     $data['title'] = 'Audit Trails';
    //     $data['user'] = $this->db->get_where('user', ['nik' =>
    //         $this->session->userdata('nik')])->row_array();

    //     // Just load the empty shell view — no DB query here
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('audit/audit_trail', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function trailData()
    // {
    //     $draw   = (int) $this->input->get('draw');
    //     $start  = (int) $this->input->get('start');
    //     $length = (int) $this->input->get('length');
    //     $search = $this->input->get('search')['value'] ?? '';

    //     // Match exact DB columns
    //     $columns = [
    //         0  => 'id',
    //         1  => 'user_id',
    //         2  => 'username',
    //         3  => 'action',
    //         4  => 'table_name',
    //         5  => 'row',
    //         6  => 'reference',
    //         7  => 'state_before',
    //         8  => 'state_after',
    //         9  => 'ip_address',
    //         10 => 'created_at',
    //     ];

    //     // Total unfiltered
    //     $totalRecords = $this->db->count_all('audit_trail');

    //     // Search
    //     $this->db->from('audit_trail');
    //     if (!empty($search)) {
    //         $this->db->group_start();
    //         $searchable = ['username', 'action', 'table_name', 'row', 'reference', 'ip_address'];
    //         foreach ($searchable as $col) {
    //             $this->db->or_like($col, $search);
    //         }
    //         $this->db->group_end();
    //     }
    //     $totalFiltered = $this->db->count_all_results('', false);

    //     // Order
    //     $orderColIndex = (int) ($this->input->get('order')[0]['column'] ?? 10);
    //     $orderDir      = in_array($this->input->get('order')[0]['dir'] ?? '', ['asc', 'desc'])
    //                         ? $this->input->get('order')[0]['dir']
    //                         : 'desc';
    //     $orderCol = $columns[$orderColIndex] ?? 'created_at';
    //     $this->db->order_by($orderCol, $orderDir);

    //     $rows = $this->db->limit($length, $start)->get('audit_trail')->result_array();

    //     $formatted = [];
    //     foreach ($rows as $i => $au) {
    //         $before = json_decode($au['state_before'], true);
    //         $after  = json_decode($au['state_after'],  true);

    //         $diff = (is_array($before) && is_array($after))
    //                     ? array_diff_assoc($before, $after)
    //                     : [];

    //         $formatted[] = [
    //             'no'           => $start + $i + 1,
    //             'user_id'      => $au['user_id'],
    //             'username'     => htmlspecialchars($au['username']),
    //             'action'       => $this->_actionBadge($au['action']),
    //             'table_name'   => htmlspecialchars($au['table_name']),
    //             'row'          => htmlspecialchars($au['row'] ?? '-'),
    //             'reference'    => htmlspecialchars($au['reference'] ?? '-'),
    //             'state_before' => !empty($au['state_before'])
    //                                 ? '<pre class="m-0 small">' . htmlspecialchars($au['state_before']) . '</pre>'
    //                                 : '-',
    //             'state_after'  => !empty($au['state_after'])
    //                                 ? '<pre class="m-0 small">' . htmlspecialchars($au['state_after']) . '</pre>'
    //                                 : '-',
    //             'diff'         => !empty($diff)
    //                                 ? '<pre class="m-0 small text-danger">' . htmlspecialchars(print_r($diff, true)) . '</pre>'
    //                                 : '<span class="badge badge-success">Clear</span>',
    //             'ip_address'   => htmlspecialchars($au['ip_address'] ?? '-'),
    //             'created_at'   => $au['created_at'],
    //         ];
    //     }

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode([
    //             'draw'            => $draw,
    //             'recordsTotal'    => $totalRecords,
    //             'recordsFiltered' => $totalFiltered,
    //             'data'            => $formatted,
    //         ]));
    // }

    // // Color-code action badges
    // private function _actionBadge($action)
    // {
    //     $map = [
    //         'INSERT' => 'badge-primary',
    //         'UPDATE' => 'badge-warning',
    //         'DELETE' => 'badge-danger',
    //         'LOGIN'  => 'badge-info',
    //         'LOGOUT' => 'badge-secondary',
    //     ];
    //     $class = $map[strtoupper($action)] ?? 'badge-dark';
    //     return '<span class="badge ' . $class . '">' . htmlspecialchars($action) . '</span>';
    // }

    public function trail()
    {
        $data['title'] = 'Audit Trails';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['audit'] = $this->db->get('audit_trail')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('audit/audit_trail', $data);
        $this->load->view('templates/footer');
    }
    // public function trail()
    // {
    //     $data['title']  = 'Audit Trails';
    //     $data['user']   = $this->db->get_where('user', ['nik' => $this->session->userdata('nik')])->row_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('audit/audit_trail', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function trail_ajax()
    // {
    //     $draw   = intval($this->input->post('draw'));
    //     $start  = intval($this->input->post('start'));
    //     $length = intval($this->input->post('length'));
    //     $search = $this->input->post('search')['value'];

    //     $columns = ['user_id', 'username', 'action', 'table_name', 'row', 'reference', 'ip_address', 'created_at'];

    //     // Total records (unfiltered)
    //     $totalRecords = $this->db->count_all('audit_trail');

    //     // Filtered query
    //     $this->db->from('audit_trail');
    //     if (!empty($search)) {
    //         $this->db->group_start();
    //         foreach ($columns as $col) {
    //             $this->db->or_like($col, $search);
    //         }
    //         $this->db->group_end();
    //     }
    //     $totalFiltered = $this->db->count_all_results('audit_trail', false);

    //     // Fetch page
    //     $this->db->limit($length, $start);
    //     $this->db->order_by('created_at', 'DESC');
    //     $rows = $this->db->get('audit_trail')->result_array();

    //     // Build diff inline
    //     $result = [];
    //     foreach ($rows as $au) {
    //         $before = is_array($au['state_before']) ? $au['state_before'] : json_decode($au['state_before'], true);
    //         $after  = is_array($au['state_after'])  ? $au['state_after']  : json_decode($au['state_after'],  true);
    //         $diff   = (is_array($before) && is_array($after)) ? array_diff_assoc($before, $after) : [];

    //         $result[] = [
    //             $au['user_id'],
    //             $au['username'],
    //             $au['action'],
    //             $au['table_name'],
    //             $au['row'],
    //             $au['reference'],
    //             '<span class="state-cell">' . htmlspecialchars($au['state_before']) . '</span>',
    //             '<span class="state-cell">' . htmlspecialchars($au['state_after'])  . '</span>',
    //             !empty($diff) ? '<pre class="diff-cell">' . htmlspecialchars(print_r($diff, true)) . '</pre>' : '<span class="badge-clear">Clear</span>',
    //             $au['ip_address'],
    //             $au['created_at'],
    //         ];
    //     }

    //     echo json_encode([
    //         'draw'            => $draw,
    //         'recordsTotal'    => $totalRecords,
    //         'recordsFiltered' => $totalFiltered,
    //         'data'            => $result,
    //     ]);
    // }
}