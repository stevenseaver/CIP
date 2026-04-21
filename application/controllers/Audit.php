<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

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