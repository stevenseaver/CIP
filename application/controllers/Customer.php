<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        //load user data per session
        $data['title'] = 'Products List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //get finished good database
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/product_page', $data);
        $this->load->view('templates/footer');
    }

    public function cart()
    {
        //load user data per session
        $data['title'] = 'Cart';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/cart', $data);
        $this->load->view('templates/footer');
    }

    public function add_to_cart($id)
    {
        //load user data per session
        $data['title'] = 'Products List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //get finished good database
        $data['finishedStock'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();

        $cart_data = [
            'id' => $id,
            'qty' => '1',
            'price' => $data['finishedStock']['price'],
            'name' => $data['finishedStock']['name']
        ];

        $this->cart->insert($cart_data);
        redirect('customer');
    }
}
