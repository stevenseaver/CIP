<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function material_wh()
    {
        $data['title'] = 'Material Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get material database
        $data['materialStock'] = $this->db->get('stock_material')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['materialStock'] = $this->warehouse_id->getMaterialWarehouseID();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/material', $data);
        $this->load->view('templates/footer');
    }

    public function add_material()
    {
        $data['title'] = 'Material Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get material database
        $data['materialStock'] = $this->db->get('stock_material')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['materialStock'] = $this->warehouse_id->getMaterialWarehouseID();
        //validation
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('code', 'code', 'required|trim');
        $this->form_validation->set_rules('initial_stock', 'initial stock', 'required|trim');
        $this->form_validation->set_rules('warehouse', 'warehouse', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/material', $data);
            $this->load->view('templates/footer');
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
        } else {
            $material = $this->input->post('name');
            $code = $this->input->post('code');
            $initial_stock = $this->input->post('initial_stock');
            $status = 1;
            $warehouse = $this->input->post('warehouse');

            $data = [
                'material' => $material,
                'code' => $code,
                'date' => time(),
                'in_stock' => $initial_stock,
                'status' => $status,
                'warehouse'  => $warehouse
            ];

            $this->db->insert('stock_material', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item ' . $material . ' added!</div>');
            redirect('inventory/material_wh');
        }
    }

    public function prod_wh()
    {
        $data['title'] = 'Production Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get roll database
        $data['rollStock'] = $this->db->get('stock_roll')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['rollStock'] = $this->warehouse_id->getProductionWarehouseID();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/prod', $data);
        $this->load->view('templates/footer');
    }

    public function gbj_wh()
    {
        $data['title'] = 'Finished Goods Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get finished good database
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/gbj', $data);
        $this->load->view('templates/footer');
    }

    public function material_details($code)
    {
        $data['title'] = 'Material Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get material database
        $data['materialStock'] = $this->db->get('stock_material')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $this->load->model('Warehouse_model', 'transaction_id');
        $data['materialStock'] = $this->warehouse_id->getMaterialWarehouseID();
        $data['code'] = $code;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/material_details', $data);
        $this->load->view('templates/footer');
    }

    public function prod_details($code)
    {
        $data['title'] = 'Production Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get roll database
        $data['rollStock'] = $this->db->get('stock_roll')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['rollStock'] = $this->warehouse_id->getProductionWarehouseID();
        $data['code'] = $code;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/prod_details', $data);
        $this->load->view('templates/footer');
    }

    public function gbj_details($code)
    {
        $data['title'] = 'Finished Goods Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get finished good database
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();
        $data['code'] = $code;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/gbj_details', $data);
        $this->load->view('templates/footer');
    }
}
