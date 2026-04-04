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
}