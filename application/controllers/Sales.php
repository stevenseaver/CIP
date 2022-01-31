<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Sales Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/sales', $data);
        $this->load->view('templates/footer');
    }

    public function deliveryorder()
    {
        $data['title'] = 'Delivery Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/deliveryorder', $data);
        $this->load->view('templates/footer');
    }

    public function invoice()
    {
        $data['title'] = 'Sales Invoice';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/invoice', $data);
        $this->load->view('templates/footer');
    }

    public function salesinfo()
    {
        $data['title'] = 'Sales Info';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/salesinfo', $data);
        $this->load->view('templates/footer');
    }
}
