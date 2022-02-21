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
    //***                **//
    //***  Customer list **//
    //***                **//
    public function customer()
    {
        $data['title'] = 'Customer List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Sales_model', 'terms_id');
        $data['customer'] = $this->terms_id->getTerms();
        $data['terms'] = $this->db->get('payment_terms')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/customer', $data);
        $this->load->view('templates/footer');
    }
    //add customer data
    public function add_customer()
    {
        $data['title'] = 'Customer List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Sales_model', 'terms_id');
        $data['customer'] = $this->terms_id->getTerms();
        $data['terms'] = $this->db->get('payment_terms')->result_array();

        //validation
        $this->form_validation->set_rules('code', 'code', 'trim');
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email');
        $this->form_validation->set_rules('phone_number', 'phone number', 'required|trim');
        $this->form_validation->set_rules('account', 'account', 'trim');
        // $this->form_validation->set_rules('terms', 'terms', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some input fields sure are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/customer', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone_number = $this->input->post('phone_number');
            $account = $this->input->post('account');
            $terms = $this->input->post('terms');

            $data = [
                'name' => $name,
                'address' => $address,
                'email' => $email,
                'phone' => $phone_number,
                'bank_account' => $account,
                'terms' => $terms,
            ];
            $this->db->insert('customer', $data);
            $lastcount = $this->db->insert_id();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New customer: ' . $name . ' added!</div>');
            redirect('sales/customer');
        }
    }

    //edit customer data
    public function edit_customer()
    {
        $data['title'] = 'Customer List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Sales_model', 'terms_id');
        $data['customer'] = $this->terms_id->getTerms();
        $data['terms'] = $this->db->get('payment_terms')->result_array();

        //validation
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email');
        $this->form_validation->set_rules('phone_number', 'phone number', 'required|trim');
        $this->form_validation->set_rules('account', 'account', 'trim');
        // $this->form_validation->set_rules('terms', 'terms', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some input fields sure are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/customer', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone_number = $this->input->post('phone_number');
            $account = $this->input->post('account');
            $terms = $this->input->post('terms');

            $data = [
                'name' => $name,
                'address' => $address,
                'email' => $email,
                'phone' => $phone_number,
                'bank_account' => $account,
                'terms' => $terms,
            ];
            $this->db->where('id', $id);
            $this->db->update('customer', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Customer: ' . $name . ' edited!</div>');
            redirect('sales/customer');
        }
    }
    //delete an asset
    public function delete_customer()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('id');
        // get data on deleted sub menu
        $deleteCust = $this->db->get_where('customer', array('id' => $itemtoDelete))->row_array();
        // delete customer
        $this->db->delete('customer', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Customer named ' . $deleteCust["name"] . ' with ID ' . $deleteCust["id"] . ' deleted!</div>');
        redirect('sales/customer');
    }
}
