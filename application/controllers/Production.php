<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Production';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //get inventory warehouse data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $transaction_query = 1; //unprocessed production order data
        $status = 3; //production order data only
        $data['materialStock'] = $this->warehouse_id->purchaseOrderMaterialWH($transaction_query, $status);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/production', $data);
        $this->load->view('templates/footer');
    }

    public function add_prod($id)
    {
        $data['title'] = 'Add Production Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get material data
        $data['material'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();

        $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_prodorder', $data);
        $this->load->view('templates/footer');
    }

    //ADD ITEM PO
    public function add_item_prod($id, $status, $warehouse)
    {
        $data['title'] = 'Add Production Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get all stock akhir material data
        $data['material'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();

        // $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $this->form_validation->set_rules('materialSelect', 'material', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('description', 'description', 'required|trim');
        $this->form_validation->set_rules('campuran', 'mix amount', 'required|trim|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_prodorder', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $po_id = $id;
            $po_status = 1;
            $materialID = $this->input->post('materialSelect');
            $price = $this->input->post('price');
            $date = time();
            $amount = $this->input->post('amount');
            $description = $this->input->post('description');
            $campuran = $this->input->post('campuran');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID, 'status' => 7])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $supplier = $material_selected["supplier"];

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => $date,
                'price' => $price,
                'outgoing' => $amount,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'transaction_status' => $po_status,
                'description' => $description,
                'item_desc' => $campuran
            ];

            $this->db->insert('stock_material', $data);

            $stock_old = $material_selected["in_stock"];

            $data2 = [
                'in_stock' => $stock_old - $amount,
                'date' => $date,
                'price' => $price
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $materialCode);
            $this->db->update('stock_material', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material added!</div>');
            redirect('production/add_item_prod/' . $po_id . '/3/1');
        }
    }

    //update amount
    public function update_amount()
    {
        $id = $this->input->post('id');
        $prodID = $this->input->post('prodID');
        $amount = $this->input->post('qtyID');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];
        $adjust_old = $data['material_edited']['outgoing'];

        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_material', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];

        $update_stock = ($stock_akhir + $adjust_old) - $amount;

        $data2 = [
            'in_stock' => $update_stock,
            'date' => $date
        ];

        //update transaksi
        $this->db->where('id', $id);
        $this->db->set('outgoing', $amount);
        $this->db->update('stock_material');
        //update stock akhir
        $this->db->where('status', '7');
        $this->db->where('code', $materialID);
        $this->db->update('stock_material', $data2);
    }

    //get PO details
    public function prod_details($id)
    {
        $data['title'] = 'Production Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        $data['po_id'] = $id;
        //get data
        $data['date'] = $data['getID']['date'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/prodorder_details', $data);
        $this->load->view('templates/footer');
    }
    
    //delete Production Order per item
    public function delete_item_prod_order()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];

        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_material', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];

        $update_stock = ($stock_akhir + $amount);

        $data2 = [
            'in_stock' => $update_stock,
            'date' => $date
        ];

        //update stock akhir
        $this->db->where('status', '7');
        $this->db->where('code', $materialID);
        $this->db->update('stock_material', $data2);
        //delete_item
        $this->db->where('id', $id);
        $this->db->delete('stock_material');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material ' . $name . ' with amount ' . $amount . '  deleted!</div>');
        redirect('production/add_prod/' . $po_id);
    }

    public function delete_all_prod_order()
    {
        $po_id = $this->input->post('delete_po_id');

        //delete related PO items
        $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->result_array();
        $date = time();
        // var_dump($data['material_selected']);
        foreach ($data['material_selected'] as $ms) :
            //get selected material stock_akhir or stock akhir from id = 7
            $data['updatestock'] = $this->db->get_where('stock_material', ['code' => $ms['code'], 'status' => 7])->row_array();
            $stock_akhir = $data['updatestock']['in_stock'];

            $update_stock = ($stock_akhir + $ms['outgoing']);
            // var_dump($update_stock);
            
            $data2 = [
                'in_stock' => $update_stock,
                'date' => $date
            ];
            
            //update stock akhir
            $this->db->where('status', '7');
            $this->db->where('code', $ms['code']);
            $this->db->update('stock_material', $data2);
            
        endforeach;
        $this->db->where('transaction_id', $po_id);
        $this->db->delete('stock_material');

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Production order unsaved, item(s) are deleted!</div>');
        redirect('production/');
    }

    /*** INPUT ROLL
     * ROLL ITEM INPUT AFTER BEING EXTRUDED VIA EXTRUDER MACHINE
     */
    public function inputRoll()
    {
        $data['title'] = 'Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get inventory warehouse data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $transaction_query = 1; //unprocessed purchase order data
        $status = 3; //purchase order data only
        $data['materialStock'] = $this->warehouse_id->purchaseOrderMaterialWH($transaction_query, $status);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/input_roll', $data);
        $this->load->view('templates/footer');
    }

    public function input_roll_details($prodID)
    {
        $data['title'] = 'Roll Input Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
    
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
        $data['po_id'] = $prodID;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/input_roll_details', $data);
        $this->load->view('templates/footer');
    }

    public function add_roll($prodID)
    {
        $data['title'] = 'Add Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollSelect'] = $this->db->get_where('stock_roll', ['status' => 7])->result_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
        
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['po_id'] = $prodID;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_input_roll', $data);
        $this->load->view('templates/footer');
    }

    public function add_roll_item($prodID, $status, $warehouse)
    {
        $data['title'] = 'Add Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollSelect'] = $this->db->get_where('stock_roll', ['status' => 7])->result_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
        
        //get inventory warehouse data
        $data['po_id'] = $prodID;

        $this->form_validation->set_rules('rollSelect', 'roll item', 'trim|required');
        $this->form_validation->set_rules('code', 'code', 'trim|required');
        $this->form_validation->set_rules('amount', 'amount', 'trim|required');
        $this->form_validation->set_rules('batch', 'batch', 'trim|required');
        $this->form_validation->set_rules('roll_no', 'roll number', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_input_roll', $data);
            $this->load->view('templates/footer');
        } else {
            $item = $this->input->post('rollSelect');
            $code = $this->input->post('code');
            $weight = $this->input->post('weight');
            $lipatan = $this->input->post('lipatan');
            $date = time();
            $amount = $this->input->post('amount');
            $batch = $this->input->post('batch');
            $roll_no = $this->input->post('roll_no');

            $rollSelect = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();

            $data = [ 
                'name' => $item,
                'code' => $code,
                'price' => 0,
                'date' => $date,
                'weight' => $weight,
                'lipatan' => $lipatan,
                'in_stock' => 0,
                'incoming' => $amount,
                'outgoing' => 0,
                'status' => 3,
                'warehouse' => 2,
                'transaction_id' => $prodID,
                'batch' => $batch,
                'transaction_desc' => $roll_no
            ];

            $this->db->insert('stock_roll', $data);

            $stock_old = $rollSelect['in_stock'];

            $data2 = [
                'in_stock' => $stock_old + $amount,
                'date' => $date
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $code);
            $this->db->update('stock_roll', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Roll added!</div>');
            redirect('production/add_roll/' . $prodID);
        }
    }

    //delete Input Roll per item
    public function delete_item_roll()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];

        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_roll', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];

        $update_stock = ($stock_akhir - $amount);

        $data2 = [
            'in_stock' => $update_stock,
            'date' => $date
        ];

        //update stock akhir
        $this->db->where('status', '7');
        $this->db->where('code', $materialID);
        $this->db->update('stock_roll', $data2);
        //delete_item
        $this->db->where('id', $id);
        $this->db->delete('stock_roll');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material ' . $name . ' with amount ' . $amount . '  deleted!</div>');
        redirect('production/add_roll/' . $po_id);
    }

    public function delete_all_roll()
    {
        $po_id = $this->input->post('delete_po_id');

        //delete related PO items
        $this->db->where('transaction_id', $po_id);
        $this->db->delete('stock_roll');

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Roll item order unsaved, item(s) are deleted!</div>');
        redirect('production/inputRoll');
    }

    public function gbj_report()
    {
        $data['title'] = 'Finished Goods Report';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get finished good database
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/gbj_report', $data);
        $this->load->view('templates/footer');
    }

    /** COGS Calculator function */ 
    /** COGS Calculator calculates COGS for specific material used in production */ 
    /** COGS calculation excludes electricity and labour costs. */ 
    public function cogs_calculator()
    {
        $data['title'] = 'COGS Calculator';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get material data
        $data['material'] = $this->db->get_where('stock_material', ['status' => 7])->result_array();

        // $data['material_selected'] = $this->db->get('cogs_calculator')->result_array();
        $this->load->model('Calculator_model', 'calculator');
        $data['material_selected'] = $this->calculator->getMaterialName();

        $this->form_validation->set_rules('materialSelect', 'material', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('price', 'price', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/cogs_calc', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $materialName = $this->input->post('materialSelect');
            $amount = $this->input->post('amount');
            $price = $this->input->post('price');

            $data = [
                'material_id' => $materialName,
                'amount_used' => $amount,
                'price_per_unit' => $price
            ];

            $this->db->insert('cogs_calculator', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material added!</div>');
            redirect('production/cogs_calculator/');
        }
    }

    public function calculateCOGS()
    {
        $data['title'] = 'Cost of Product';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //get material database
        $data['materialStock'] = $this->db->get('stock_material')->result_array();

        $this->form_validation->set_rules('inputFormula', 'formula', 'trim|required');
        $this->form_validation->set_rules('price', 'price', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/cops', $data);
            $this->load->view('templates/footer');
        } else {
            $formula = $this->input->post('inputFormula');
            $price = $this->input->post('price');

            //calculate item subtotal
            $weight = $formula / 10;
            $subtotal = $weight * $price;

            $data['weight'] = $weight;
            $data['subtotal'] = $subtotal;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/cops', $data);
            $this->load->view('templates/footer');
        }
    }
    
    //update amount
    public function update_cogs_amount()
    {
        $id = $this->input->post('id');
        $amount = $this->input->post('qtyID');

        //update transaksi
        $this->db->where('id', $id);
        $this->db->set('amount_used', $amount);
        $this->db->update('cogs_calculator');
    }

    //update price
    public function update_cogs_price()
    {
        $id = $this->input->post('id');
        $price = $this->input->post('price');

        //update transaksi
        $this->db->where('id', $id);
        $this->db->set('price_per_unit', $price);
        $this->db->update('cogs_calculator');
    }

    //delete all cogs
    public function delete_cogs_data()
    {
        $this->db->empty_table('cogs_calculator');
        redirect('production/cogs_calculator/');
    }

    //delete data per id
    public function delete_cogs_item($id)
    {
        //delete item
        $this->db->where('id', $id);
        $this->db->delete('cogs_calculator');
        redirect('production/cogs_calculator/');
    }

}
