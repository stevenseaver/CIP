<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchasing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Purchase Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseorder', $data);
        $this->load->view('templates/footer');
    }

    public function receiveorder()
    {
        $data['title'] = 'Receive Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/receiveorder', $data);
        $this->load->view('templates/footer');
    }

    public function invoice()
    {
        $data['title'] = 'Order Invoice';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/invoice', $data);
        $this->load->view('templates/footer');
    }

    public function purchaseinfo()
    {
        $data['title'] = 'Purchase Info';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseinfo', $data);
        $this->load->view('templates/footer');
    }

    // public function editmenu()
    // {
    //     $data['title'] = 'Menu Management';
    //     $data['user'] = $this->db->get_where('user', ['nik' =>
    //     $this->session->userdata('nik')])->row_array();
    //     $data['menu'] = $this->db->get('user_menu')->result_array();

    //     $this->form_validation->set_rules('edit_menu_id', 'menu id', 'required|trim');
    //     $this->form_validation->set_rules('edit_menu_name', 'menu name', 'required|trim');

    //     if ($this->form_validation->run() == false) {
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/sidebar', $data);
    //         $this->load->view('templates/topbar', $data);
    //         $this->load->view('menu/index', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         //read from input input
    //         $edit_id = $this->input->post('edit_menu_id');
    //         $edit_name = $this->input->post('edit_menu_name');
    //         $editedMenu = $this->db->get_where('user_menu', array('id' => $edit_id))->row_array();
    //         // edit DB
    //         $this->db->where('id', $edit_id);
    //         $this->db->update('user_menu', array('menu' => $edit_name));
    //         $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Menu ' . $editedMenu["menu"] . ' edited into ' . $edit_name . '!</div>');
    //         redirect('menu');
    //     }
    // }

    // public function deletemenu()
    // {
    //     // get data on deleted menu
    //     $itemtoDelete = $this->input->post('delete_menu_id');
    //     $deletedMenu = $this->db->get_where('user_menu', array('id' => $itemtoDelete))->row_array();
    //     // delete menu
    //     $this->db->delete('user_menu', array('id' => $itemtoDelete));
    //     // delete its submenu
    //     $this->db->delete('user_sub_menu', array('menu_id' => $itemtoDelete));
    //     // send message
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Menu ' . $deletedMenu["menu"] . ' and its submenu deleted!</div>');
    //     redirect('menu');
    // }
}
