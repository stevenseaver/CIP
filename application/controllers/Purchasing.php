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
        $transaction_query = 1; //purchase order data
        $status = 8; //purchase order data only
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['inventory_item'] = $this->warehouse_id->purchaseOrderMaterialWH($transaction_query, $status);

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
        //get supplier data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->calc_due_date();
        //get inventory warehouse data
        $data['inventory_wh'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        //get supplier data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->getSupplierData();

        $data['supDetails'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        if($data['supDetails']){
            $data['input_sup_id'] = $data['supDetails']['supplier'];
            $data['input_sup_term']= $data['supDetails']['term'];
            $data['existing_date']= $data['supDetails']['date'];
            
            $data['supName'] = $this->db->get_where('supplier', ['id' => $data['input_sup_id']])->row_array();
            $data['input_sup_name'] = $data['supName']['supplier_name'];
        } else {
            $data['input_sup_name'] = null;
            $data['input_sup_id'] = null;
            $data['input_sup_term']= null;
            $data['existing_date']= null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/add_purchaseorder', $data);
        $this->load->view('templates/footer');
    }

    //ADD ITEM PO
    public function add_item_po($id, $status, $warehouse)
    {
        $data['title'] = 'Add Purchase Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->calc_due_date();
        //get inventory warehouse data
        $data['inventory_wh'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        // $data['inventory_item'] = $this->db->get_where('stock_material')->result_array();
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        //get supplier data
        $this->load->model('Purchase_model', 'terms_id');
        $data['supplier'] = $this->terms_id->getSupplierData();

        $data['supDetails'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        if($data['supDetails']){
            $data['input_sup_id'] = $data['supDetails']['supplier'];
            $data['input_sup_term']= $data['supDetails']['term'];
            $data['existing_date']= $data['supDetails']['date'];
            
            $data['supName'] = $this->db->get_where('supplier', ['id' => $data['input_sup_id']])->row_array();
            $data['input_sup_name'] = $data['supName']['supplier_name'];
        } else {
            $data['input_sup_name'] = null;
            $data['input_sup_id'] = null;
            $data['input_sup_term']= null;
            $data['existing_date']= null;
        }

        $this->form_validation->set_rules('sup_name', 'sup_name', 'required|trim');
        $this->form_validation->set_rules('po_date', 'po_date', 'required|trim');
        $this->form_validation->set_rules('material', 'material', 'required|trim');
        $this->form_validation->set_rules('price', 'price', 'required|trim');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('tax', 'tax', 'required|trim');
        $this->form_validation->set_rules('description', 'reference', 'trim');
        $this->form_validation->set_rules('item_desc', 'item description', 'trim');
        $this->form_validation->set_rules('term', 'term', 'trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('purchase/add_purchaseorder', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $po_id = $id;
            $po_status = 1;
            $materialID = $this->input->post('material');
            $data['supDetails'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
            if($data['supDetails']){
                $date = $this->input->post('po_date');
            } else {
                $date = strtotime($this->input->post('po_date'));
            };
            $price = $this->input->post('price');
            $amount = $this->input->post('amount');
            $supplier = $this->input->post('sup_id');
            $description = $this->input->post('description');
            $item_desc = $this->input->post('item_desc');
            $tax = $this->input->post('tax');
            $term = $this->input->post('term');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $unit = $material_selected["unit_satuan"];
            $is_paid = 0;
            // $supplier = $material_selected["supplier"];

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => $date,
                'price' => $price,
                'incoming' => $amount,
                'unit_satuan' => $unit,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'transaction_status' => $po_status,
                'description' => $description,
                'item_desc' => $item_desc,
                'tax' => $tax,
                'is_paid' => $is_paid,
                'term' => $term
            ];

            $this->db->insert('stock_material', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Purchase item added!</div>');
            redirect('purchasing/add_item_po/' . $po_id . '/8/1');
        }
    }

    //get PO details
    public function po_details($id, $supplier_id, $date)
    {
        $data['title'] = 'Purchase Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data from ID
        $data['supplier'] = $this->db->get_where('supplier', ['id' => $supplier_id])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        $data['po_id'] = $id;
        //get data
        $data['sup_name'] = $data['supplier']['supplier_name'];
        $data['sup_acc'] = $data['supplier']['bank_account'];
        $data['date'] = $date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseorder_details', $data);
        $this->load->view('templates/footer');
    }

    public function delete_item()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $this->db->where('id', $id);
        $this->db->delete('stock_material');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item ' . $name . ' with amount ' . $amount . '  deleted!</div>');
        redirect('purchasing/add_po/' . $po_id);
    }

    public function delete_all_po()
    {
        $po_id = $this->input->post('delete_po_id');

        //delete related PO items
        $this->db->where('transaction_id', $po_id);
        $this->db->delete('stock_material');

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">PO unsaved, unsaved item are deleted!</div>');
        redirect('purchasing/');
    }

    //receive order page displays all to be received items from PO
    public function receiveorder()
    {
        $data['title'] = 'Receive Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data
        $data['supplier'] = $this->db->get('supplier')->result_array();

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if ($start_date == null || $end_date == null) {
            $current_time = time();
            $year = date('Y', $current_time);
            $month = date('n', $current_time);
            $start_date = mktime(0, 0, 0, $month, 1, $year);
            $end_date = mktime(23, 59, 59, $month, date('t', $start_date), $year);
        }
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        //load inventory item of trans status = 2
        $transaction_query = 2; //receive order data
        $status = 8; //purchase order data only
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['inventory_item'] = $this->warehouse_id->purchaseOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/receiveorder', $data);
        $this->load->view('templates/footer');
    }

    //change trans status
    public function transaction_status_change($po_id, $supplier_id, $date)
    {
        $data['title'] = 'Receive Purchase Order Confirmation';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data from ID
        $data['supplier'] = $this->db->get_where('supplier', ['id' => $supplier_id])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->row_array();
        $data['poID'] = $po_id;
        //get data
        $data['sup_name'] = $data['supplier']['supplier_name'];
        $data['sup_acc'] = $data['supplier']['bank_account'];
        $data['date'] = $date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/add_receiveorder', $data);
        $this->load->view('templates/footer');
    }

    public function receive_details($id, $supplier_id, $date)
    {
        $data['title'] = 'Receive Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data from ID
        $data['supplier'] = $this->db->get_where('supplier', ['id' => $supplier_id])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        $data['poID'] = $id;
        //get data
        $data['sup_name'] = $data['supplier']['supplier_name'];
        $data['sup_acc'] = $data['supplier']['bank_account'];
        $data['date'] = $date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/receiveorder_details', $data);
        $this->load->view('templates/footer');
    }
    // public function receiveItem($id, $token)
    public function receiveItem($id)
    {
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();

        $poID = $data['inventory_selected']['transaction_id'];
        $amount = $data['inventory_selected']['incoming'];
        $date = time();
        $code = $data['inventory_selected']['code'];
        $supplier_id = $data['inventory_selected']['supplier'];
        $price = $data['inventory_selected']['price'];

        if($data['inventory_selected']['transaction_status'] == 1){
    
            //get stock akhir data
            $data['getID'] = $this->db->get_where('stock_material', ['code' => $code, 'status' => '7'])->row_array();
            $in_stockOld = $data['getID']['in_stock'];;
    
            $data = [
                'transaction_status' => 2,
                'in_stock' => $in_stockOld + $amount
            ];
    
            $this->db->where('id', $id);
            // $this->db->set('transaction_status', 2);
            $this->db->update('stock_material', $data);
    
            $data2 = [
                'in_stock' => $in_stockOld + $amount,
                'date' => $date,
                'price' => $price
            ];
    
            $this->db->where('status', '7');
            $this->db->where('code', $code);
            $this->db->update('stock_material', $data2);
            //redirect to receive_details
            redirect('purchasing/transaction_status_change/' . $poID . '/' . $supplier_id . '/' . $date);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Data integrity maintained!</div>');
            //redirect to receive_details
            redirect('purchasing/transaction_status_change/' . $poID . '/' . $supplier_id . '/' . $date);
        };

    }

    //update received item quantity on database
    public function update_amount()
    {
        $id = $this->input->post('id');
        $amount = $this->input->post('qtyID');

        $this->db->where('id', $id);
        $this->db->set('incoming', $amount);
        $this->db->update('stock_material');
    }

    //update received item quantity on database
    public function update_desc()
    {
        $selector = $this->input->post('selector');
        $id = $this->input->post('id');
        
        if($selector == 1){
            $reference = $this->input->post('refID');
    
            $this->db->where('id', $id);
            $this->db->set('description', $reference);
            $this->db->update('stock_material');
        } else if ($selector == 2){
            $price = $this->input->post('priceID');
    
            $this->db->where('id', $id);
            $this->db->set('price', $price);
            $this->db->update('stock_material');
        } else if ($selector == 3){
            $reference = $this->input->post('refID');
    
            $this->db->where('id', $id);
            $this->db->set('item_desc', $reference);
            $this->db->update('stock_material');
        }
    }

    public function createPDF($type, $po_id, $supplier, $date, $tax)
    {
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['user_name'] = $data['user']['name'];
        $data['ref'] = $po_id;
        $data['sup_name'] = urldecode($supplier);
        $data['date'] = $date;
        $data['tax'] = $tax;

        if ($type == 1) {
            $this->load->view('purchase/pdf_purchase_order', $data);
        } else if ($type == 2) {
            $this->load->view('purchase/pdf_invoice_po', $data);
        } else if ($type == 3) {
            $this->load->view('purchase/pdf_return_po', $data);
        } 
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

    //***                **//
    //***  Purchase Info **//
    //***                **//
    public function purchaseinfo()
    {
        $data['title'] = 'Purchase Info';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data
        $data['supplier'] = $this->db->get('supplier')->result_array();
        $this->load->model('Warehouse_model', 'warehouse_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        // $periode_id = $this->input->get('name');

        // if($this->input->get('start_date') == null){
        //     //show data in current periode
        //     $current_time = time();
        //     $current_year = date('Y', $current_time);
            
        //     $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
        //     foreach($data['periode'] as $per) :
        //         if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
        //             $data['current_periode'] = $per['period'];
        //             $data['start_date'] = $per['start_date'];
        //             $data['end_date'] = $per['end_date'];
        //         };
        //     endforeach;
            
        //     $start_date = $data['start_date'];
        //     $end_date = $data['end_date'];
        // } else {
        //     //get data parameters
        //     $current_time = time();
        //     $current_year = date('Y', $current_time);
            
        //     $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
        //     $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

        //     $data['current_periode'] = $data['selectedMonth']['period'];
        // }
        if ($start_date == null || $end_date == null) {
            $current_time = time();
            $year = date('Y', $current_time);
            $month = date('n', $current_time);
            $start_date = mktime(0, 0, 0, $month, 1, $year);
            $end_date = mktime(23, 59, 59, $month, date('t', $start_date), $year);
        }
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $status = 8; //purchase order data only

        $transaction_query = 2; //received order only
        $data['inventory_item_received'] = $this->warehouse_id->purchaseOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);
        $data['purchasePerItem'] = $this->warehouse_id->purchasePerItem($transaction_query, $status, $start_date, $end_date);

        $query = 3;
        $data['usagePerItem'] = $this->warehouse_id->purchasePerItem($query, $status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseinfo', $data);
        $this->load->view('templates/footer');
    }

    public function info_details($id, $supplier_id, $date)
    {
        $data['title'] = 'Purchase Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data from ID
        $data['supplier'] = $this->db->get_where('supplier', ['id' => $supplier_id])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        $data['poID'] = $id;
        //get data
        $data['sup_name'] = $data['supplier']['supplier_name'];
        $data['sup_acc'] = $data['supplier']['bank_account'];
        $data['date'] = $date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/purchaseinfo_details', $data);
        $this->load->view('templates/footer');
    }

    //update production order product name
    public function update_purchasing_ref()
    {
        $id = $this->input->post('id');
        $newName = $this->input->post('newName');

        $data['material_edited'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['transaction_id'];

        $data = [
            'description' => $newName
        ];

        //update transaksi
        $this->db->where('transaction_id', $materialID);
        $this->db->update('stock_material', $data);
    }

    public function paid() {
        $is_paid = 0;
        $trans_id = $this->input->post('ref_id');

        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $trans_id])->row_array();
        $current_time = $data['getID']['date'];
        $current_year = date('Y', $current_time);
        
        $data['periode'] = $this->db->get_where('periode_counter', ['year =' => $current_year])->result_array();
        
        foreach($data['periode'] as $per) :
            if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
                $date_ID = $per['id'];
                $start_date = $per['start_date'];
                $end_date = $per['end_date'];
            };
        endforeach;

        if($is_paid == 0){
            $this->db->where('transaction_id', $trans_id);
            $this->db->set('is_paid', 1);
            $this->db->update('stock_material');
            $this->session->set_flashdata('message_is_paid', '<div class="alert alert-success" role="alert">Good news!</div>');
            redirect('purchasing/purchaseinfo/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '');
        } else {
            $this->session->set_flashdata('message_is_paid', '<div class="alert alert-secondary" role="alert">Already paid!</div>');
            redirect('purchasing/purchaseinfo/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '');
        };
    }

    //***                **//
    //***  Purchase Return **//
    //***                **//

    public function purchase_return()
    {
        $data['title'] = 'Purchase Return';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get supplier data
        $data['supplier'] = $this->db->get('supplier')->result_array();


        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        if ($start_date == null || $end_date == null) {
            $current_time = time();
            $year = date('Y', $current_time);
            $month = date('n', $current_time);
            $start_date = mktime(0, 0, 0, $month, 1, $year);
            $end_date = mktime(23, 59, 59, $month, date('t', $start_date), $year);
        }
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        // $start_date = $this->input->get('start_date');
        // $end_date = $this->input->get('end_date');
        // $periode_id = $this->input->get('name');

        // if($this->input->get('start_date') == null){
        //     //show data in current periode
        //     $current_time = time();
        //     $current_year = date('Y', $current_time);
            
        //     $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
        //     foreach($data['periode'] as $per) :
        //         if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
        //             $data['current_periode'] = $per['period'];
        //             $data['start_date'] = $per['start_date'];
        //             $data['end_date'] = $per['end_date'];
        //         };
        //     endforeach;
            
        //     $start_date = $data['start_date'];
        //     $end_date = $data['end_date'];
        // } else {
        //     //get data parameters
        //     $current_time = time();
        //     $current_year = date('Y', $current_time);
            
        //     $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
        //     $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

        //     $data['current_periode'] = $data['selectedMonth']['period'];
        // }

        $status = 8; //purchase order data only
        $transaction_query = 2; //received order only
        
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['inventory_item_received'] = $this->warehouse_id->purchaseOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('purchase/return', $data);
        $this->load->view('templates/footer');
    }

    public function return_details($id, $supplier_id, $date)
    {
        $data['title'] = 'Return Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //get supplier data from ID
        $data['supplier'] = $this->db->get_where('supplier', ['id' => $supplier_id])->row_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        $data['poID'] = $id;
        //get data
        $data['sup_name'] = $data['supplier']['supplier_name'];
        $data['sup_acc'] = $data['supplier']['bank_account'];
        $data['sup_id'] = $supplier_id;
        $data['date'] = $date;
        
        $this->form_validation->set_rules('trans_id', 'trans_id', 'required|trim');
        $this->form_validation->set_rules('qtyID', 'qtyID', 'required|trim');
        $this->form_validation->set_rules('description', 'description', 'required|trim');
        $this->form_validation->set_rules('item_desc', 'item_desc', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('purchase/return_details', $data);
            $this->load->view('templates/footer');
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Return order form incomplete!</div>');
        } else {
            $trans_id = $this->input->post('trans_id');
            $amount = $this->input->post('qtyID');
    
            //get data from particular transaction which is being returned
            $data['getCode'] = $this->db->get_where('stock_material', ['id' => $trans_id])->row_array();
            $code = $data['getCode']['code'];
            $price = $data['getCode']['price'];
            $date2 = $data['getCode']['date'];
    
            //get data from stock akhir
            $data['getData'] = $this->db->get_where('stock_material', ['code' => $code, 'status' => 7])->row_array();
            $name = $data['getData']['name'];
            $code = $data['getData']['code'];
            $categories = $data['getData']['categories'];
            $unit_satuan = $data['getData']['unit_satuan'];
            $warehouse = $data['getData']['warehouse'];
            $supplier = $data['getData']['supplier'];
            $status = 6;
            $description = $this->input->post('description');
            $item_desc = $this->input->post('item_desc');
            $in_stockOld = $data['getData']['in_stock'];
    
            $trans_date = time();
            $year = date('y');
            $month = date('m');
            $day = date('d');
            $serial = rand(1000, 9999);
               
            $transID = 'RB-' . $year . $month . $day . '-' . $serial;
    
            //calculate new_stock
            $newStock = $in_stockOld - $amount; 
            // $update_trans_status = 3; 
    
            // $this->db->where('id', $trans_id);
            // $this->db->set('transaction_status', $update_trans_status);
            // $this->db->update('stock_material');
            
            $data = [
                // 'in_stock' => $in_stockOld - $amount,
                'in_stock' => $newStock,
                'date' => $trans_date,
                'price' => $price
            ];
            
            $this->db->where('status', 7);
            $this->db->where('code', $code);
            $this->db->update('stock_material', $data);
            
            $data2 = [
                'name' => $name,
                'code' => $code,
                'date' => $trans_date,
                'price' => $price,
                'categories' => $categories,
                'in_stock' => $newStock,
                'incoming' => 0,
                'outgoing' => $amount,
                'unit_satuan' => $unit_satuan,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'transaction_status' => 3,
                'transaction_id' => $transID,
                'description' => $description,
                'item_desc' => $item_desc
            ];
    
            $this->db->insert('stock_material', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Return order complete!</div>');
            redirect('purchasing/purchase_return');
        }
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
                'terms_id' => $terms,
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
        $this->form_validation->set_rules('terms', 'terms', 'required|trim');

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
                'terms_id' => $terms,
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
