<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HR extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'User Leave';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('hr/leave', $data);
        $this->load->view('templates/footer');
    }
    public function approve($nik, $start, $finish)
    {
        //send message
        $this->session->set_flashdata('approval', '<div class="alert alert-success" role="alert">Request approved!</div>');

        $this->db->set('status', 1);
        $array = array('user_nik' => $nik,  'start_date' => $start, 'finish_date' => $finish);
        $this->db->where($array);
        $this->db->update('leave_list');

        redirect('hr');
    }

    public function decline($nik, $start, $finish)
    {
        //send message
        $this->session->set_flashdata('approval', '<div class="alert alert-danger" role="alert">Request declined!</div>');

        $this->db->set('status', 2);
        $array = array('user_nik' => $nik,  'start_date' => $start, 'finish_date' => $finish);
        $this->db->where($array);
        $this->db->update('leave_list');

        redirect('hr');
    }
}
