<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    //Material Warehouse //
    //Material Warehouse //
    //Material Warehouse //

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
            $date = time();
            $status1 = 1;
            $status2 = 7;
            $warehouse = $this->input->post('warehouse');
            //intital stock
            $data1 = [
                'material' => $material,
                'code' => $code,
                'date' => $date,
                'in_stock' => $initial_stock,
                'status' => $status1,
                'warehouse'  => $warehouse
            ];
            //final stock
            $data2 = [
                'material' => $material,
                'code' => $code,
                'date' => $date,
                'in_stock' => $initial_stock,
                'status' => $status2,
                'warehouse'  => $warehouse
            ];

            $this->db->insert('stock_material', $data1);
            $this->db->insert('stock_material', $data2);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item ' . $material . ' added!</div>');
            redirect('inventory/material_wh');
        }
    }

    public function material_details($id)
    {
        $data['title'] = 'Material Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //join warehouse, material, and transaction stauts database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['materialStock'] = $this->warehouse_id->getMaterialWarehouseID();
        $data['getID'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $data['code'] = $data['getID']['code'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/material_details', $data);
        $this->load->view('templates/footer');
    }

    // Production warehouse //
    // Production warehouse //
    // Production warehouse //
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

    public function add_production()
    {
        $data['title'] = 'Production Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get roll database
        $data['rollStock'] = $this->db->get('stock_roll')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['rollStock'] = $this->warehouse_id->getProductionWarehouseID();

        //validation
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('code', 'code', 'required|trim');
        $this->form_validation->set_rules('weightperm', 'initial stock', 'required|trim');
        $this->form_validation->set_rules('lipatan', 'initial stock', 'required|trim');
        $this->form_validation->set_rules('initial_stock', 'initial stock', 'required|trim');
        $this->form_validation->set_rules('warehouse', 'warehouse', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/prod', $data);
            $this->load->view('templates/footer');
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
        } else {
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $date = time();
            $weightperm = $this->input->post('weightperm');
            $lipatan = $this->input->post('lipatan');
            $code = $this->input->post('code');
            $initial_stock = $this->input->post('initial_stock');
            $status1 = 1;
            $status2 = 7;
            $warehouse = $this->input->post('warehouse');
            //initial stock
            $data1 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'weight' => $weightperm,
                'lipatan' => $lipatan,
                'in_stock' => $initial_stock,
                'status' => $status1,
                'warehouse'  => $warehouse
            ];
            //final stock
            $data2 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'weight' => $weightperm,
                'lipatan' => $lipatan,
                'in_stock' => $initial_stock,
                'status' => $status2,
                'warehouse'  => $warehouse
            ];

            $this->db->insert('stock_roll', $data1);
            $this->db->insert('stock_roll', $data2);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item ' . $name . ' added!</div>');
            redirect('inventory/prod_wh');
        }
    }

    public function prod_details($id)
    {
        $data['title'] = 'Production Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //join trans. status, prod warehouse, and warehouse database database
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['rollStock'] = $this->warehouse_id->getProductionWarehouseID();
        //get item code by using ID as anchor
        $data['getID'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $data['code'] = $data['getID']['code'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/prod_details', $data);
        $this->load->view('templates/footer');
    }

    // GBJ Warehouse //
    // GBJ Warehouse //
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

    public function gbj_details($id)
    {
        $data['title'] = 'Finished Goods Invt. Transactions';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();
        //get item code by using ID as anchor
        $data['getID'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();
        $data['code'] = $data['getID']['code'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/gbj_details', $data);
        $this->load->view('templates/footer');
    }

    public function add_gbj()
    {
        $data['title'] = 'Finished Goods Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();

        //validation
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('code', 'code', 'required|trim');
        $this->form_validation->set_rules('initial_stock', 'initial stock', 'required|trim');
        $this->form_validation->set_rules('warehouse', 'warehouse', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/gbj', $data);
            $this->load->view('templates/footer');
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
        } else {
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $initial_stock = $this->input->post('initial_stock');
            $date = time();
            $status1 = 1;
            $status2 = 7;
            $warehouse = $this->input->post('warehouse');
            //intital stock
            $data1 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'in_stock' => $initial_stock,
                'status' => $status1,
                'warehouse'  => $warehouse
            ];
            //final stock
            $data2 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'in_stock' => $initial_stock,
                'status' => $status2,
                'warehouse'  => $warehouse
            ];

            $this->db->insert('stock_finishedgoods', $data1);
            $this->db->insert('stock_finishedgoods', $data2);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item ' . $name . ' added!</div>');
            redirect('inventory/gbj_wh');
        }
    }
}
