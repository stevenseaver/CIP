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
        //get supplier data
        $data['supplier'] = $this->db->get('supplier')->result_array();
        //get inventory warehouse data
        $data['inventory_wh'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();
        $data['inventory_item'] = $this->db->get_where('stock_material')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseorder', $data);
        $this->load->view('templates/footer');
    }

    public function add_po($id)
    {
        $data['title'] = 'Add Purchase Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get inventory warehouse data
        $data['inventory_wh'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();
        $data['inventory_item'] = $this->db->get_where('stock_material')->result_array();
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/add_purchaseorder', $data);
        $this->load->view('templates/footer');
    }

    public function add_item_po($id, $status, $warehouse)
    {
        $data['title'] = 'Add Purchase Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get inventory warehouse data
        $data['inventory_wh'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();
        $data['inventory_item'] = $this->db->get_where('stock_material')->result_array();
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $this->form_validation->set_rules('po_id', 'PO ID', 'required|trim');
        $this->form_validation->set_rules('material', 'material', 'required|trim');
        $this->form_validation->set_rules('price', 'price', 'required|trim');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('purchase/add_purchaseorder', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $po_id = $id;
            $materialID = $this->input->post('material');
            $price = $this->input->post('price');
            $amount = $this->input->post('amount');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $supplier = $material_selected["supplier"];

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => time(),
                'price' => $price,
                'incoming' => $amount,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier
            ];

            $this->db->insert('stock_material', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material added!</div>');
            redirect('purchasing/add_item_po/' . $po_id . '/8/1');
        }
    }

    public function receiveorder()
    {
        $data['title'] = 'Receive Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseinfo', $data);
        $this->load->view('templates/footer');
    }

    //***                **//
    //***  Customer list **//
    //***                **//
    public function supplier()
    {
        $data['title'] = 'Supplier List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->getTerms();
        $data['terms'] = $this->db->get('payment_terms')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/supplier', $data);
        $this->load->view('templates/footer');
    }
    //add supplier data
    public function add_supplier()
    {
        $data['title'] = 'Supplier List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->getTerms();
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
            $this->load->view('purchase/supplier', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone_number = $this->input->post('phone_number');
            $account = $this->input->post('account');
            $terms = $this->input->post('terms');

            $data = [
                'supplier_name' => $name,
                'address' => $address,
                'email' => $email,
                'phone' => $phone_number,
                'bank_account' => $account,
                'terms' => $terms,
            ];
            $this->db->insert('supplier', $data);
            $lastcount = $this->db->insert_id();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New supplier: ' . $name . ' added!</div>');
            redirect('purchasing/supplier');
        }
    }

    //edit customer data
    public function edit_supplier()
    {
        $data['title'] = 'Supplier List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->getTerms();
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
            $this->load->view('purchase/supplier', $data);
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
                'supplier_name' => $name,
                'address' => $address,
                'email' => $email,
                'phone' => $phone_number,
                'bank_account' => $account,
                'terms' => $terms,
            ];
            $this->db->where('id', $id);
            $this->db->update('supplier', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Customer: ' . $name . ' edited!</div>');
            redirect('purchasing/supplier');
        }
    }
    //delete an asset
    public function delete_supplier()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('id');
        // get data on deleted sub menu
        $deleteSupplier = $this->db->get_where('supplier', array('id' => $itemtoDelete))->row_array();
        // delete supplier
        $this->db->delete('supplier', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Supplier named ' . $deleteSupplier["supplier_name"] . ' with ID ' . $deleteSupplier["id"] . ' deleted!</div>');
        redirect('purchasing/supplier');
    }
}
