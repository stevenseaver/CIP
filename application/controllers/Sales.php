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
        //load user data per session
        $data['title'] = 'Sales Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $status = 1;
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getSalesOrderData($status);
        // $data['dataCart'] = $this->db->get_where('cart')->result_array();

        // $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/sales', $data);
        $this->load->view('templates/footer');
    }

    public function sales_detail($inv)
    {
        //load user data per session
        $data['title'] = 'Customer Transaction Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataRow'] = $this->custID->getRow($inv);

        $data['customer'] = $data['dataRow']['name'];
        $data['ref'] = $inv;
        $data['date'] = $data['dataRow']['date'];
        $data['status'] = $data['dataRow']['status'];
        $data['address'] = $data['dataRow']['deliveryTo'];

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/sales_detail', $data);
        $this->load->view('templates/footer');
    }

    public function sales_status_change($ref, $status_change_to)
    {
        $this->db->where('ref', $ref);
        $this->db->set('status', $status_change_to);
        $this->db->update('cart');

        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status changed!</div>');
        if ($status_change_to == 2) {
            // delivery order
            // USE THIS IF ITEM STOCK AKHIR IS CHANGED ON DELIVERY
            $data['salesData'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $ref])->result_array();
            //integrity_check to prevent multiple input on slow network or double press on button
            $data['integrity_check'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $ref])->row_array();
            if($data['integrity_check']['transaction_status'] == 0){
                foreach ($data['salesData'] as $ci) :
                    //get selected item
                    $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['name' => $ci['name'], 'status' => 7])->row_array();
                    
                    $amount = $ci['outgoing'];
                    
                    $code = $data['itemselect']['code'];
                    $in_stockOld = $data['itemselect']['in_stock'];
    
                    // data to update inventory stock akhir
                    $data = [
                        'in_stock' => $in_stockOld - $amount
                    ];
                    
                    $this->db->where('code', $code);
                    $this->db->where('status', 7);
                    $this->db->update('stock_finishedgoods', $data);
    
                    $data_warehouse = [
                        'transaction_status' => 1,
                        'in_stock' => $in_stockOld - $amount
                    ];
    
                    $this->db->where('code', $code);
                    $this->db->where('transaction_id', $ref);
                    $this->db->update('stock_finishedgoods', $data_warehouse);
                endforeach;
                
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status changed into deliveries, final stock updated!</div>');
                redirect('sales/deliveryorder');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Data integrity maintained!</div>');
                redirect('sales/deliveryorder');
            };
            
        } else if ($status_change_to == 3) {
            //invoice
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaction finished, send invoice to customer!</div>');
            redirect('sales/salesinfo');
            // redirect('sales/invoice');
        } else if ($status_change_to == 4) {
            // USE THIS IF ITEM STOCK AKHIR IS CHANGED ON PAYMENT
            // reset all in_stock on stock_finishedgoods database to the previous value
            // $data['salesData'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $ref])->result_array();
            
            // foreach ($data['salesData'] as $ci) :
            //     //get selected item
            //     $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['name' => $ci['name'], 'status' => 7])->row_array();
            
            //     $amount = $ci['outgoing'];
            
            //     echo $amount;
            
            //     $code = $data['itemselect']['code'];
            //     $in_stockOld = $data['itemselect']['in_stock'];
            
            //     // data to update inventory database
            //     $data2_warehouse = [
            //         'in_stock' => $in_stockOld + $amount
            //     ];
            
            //     $this->db->where('code', $code);
            //     $this->db->where('status', 7);
            //     $this->db->update('stock_finishedgoods', $data2_warehouse);
            // endforeach;
            $ref = $this->input->post('delete_ref');

            $this->db->where('ref', $ref);
            $this->db->set('status', $status_change_to);
            $this->db->update('cart');
                    
            //delete all that has $ref on stock_finishedgoods database
            $this->db->where('transaction_id', $ref);
            $this->db->delete('stock_finishedgoods');

            //delete all that has $ref on cart database
            // $this->db->where('ref', $ref);
            // $this->db->delete('cart');
                    
            // return to page
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Transaction declined!</div>');
            redirect('sales/');
        };
    }

    public function add_salesorder($ref){
        //load user data per session
        $data['title'] = 'Add New Sales Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        // $date = time();
        $data['ref'] = $ref;    
        // $data['date'] = $date;

        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $ref])->result_array();
        $data['gbjData'] = $this->db->get_where('stock_finishedgoods', ['status' => 7])->result_array();
        $data['custData'] = $this->db->get_where('user', ['role_id' => 3])->result_array();
        
        $this->form_validation->set_rules('cust_name', 'customer name', 'required|trim');
        $this->form_validation->set_rules('cust_id', 'customer ID', 'required|trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('so_date', 'sales order date', 'required|trim');
        
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('code', 'code', 'trim');
        $this->form_validation->set_rules('price', 'price', 'numeric|required|trim');
        $this->form_validation->set_rules('amount', 'amount', 'numeric|required|trim');
        $this->form_validation->set_rules('discount', 'discount', 'numeric|trim');
        $this->form_validation->set_rules('bal', 'sack amount', 'required|numeric|trim');
        $this->form_validation->set_rules('weight', 'weight', 'required|numeric|trim');
        $this->form_validation->set_rules('notes', 'reference', 'required|trim');
        
        //to get cust data
        $data['custDetails'] = $this->db->get_where('cart', ['ref' => $ref])->row_array();
        if($data['custDetails']){
            $data['input_cust_id'] = $data['custDetails']['customer_id'];
            $data['input_cust_address']= $data['custDetails']['deliveryTo'];
            $data['date'] = $data['custDetails']['date'];
            
            $data['custName'] = $this->db->get_where('user', ['id' => $data['input_cust_id']])->row_array();
            $data['input_cust_name'] = $data['custName']['name'];
        } else {
            $data['input_cust_name'] = null;
            $data['input_cust_id'] = null;
            $data['input_cust_address']= null;
            $data['date'] = null;
        }

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sales/add_salesorder', $data);
            $this->load->view('templates/footer');
        } else {
            $cust_id = $this->input->post('cust_id');
            $cust_address = $this->input->post('address');

            if($data['date']){
                $date = $this->input->post('so_date');
            } else {
                $date = strtotime($this->input->post('so_date'));
            };
            
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $price = $this->input->post('price');
            $amount = $this->input->post('amount');
            $sack = $this->input->post('bal');
            $weight = $this->input->post('weight');
            $discount = $this->input->post('discount');
            $desc = $this->input->post('notes');
            if($discount != 0){
                $subtotal = ($price-$discount) * $amount;
            } else {
                $subtotal = $price * $amount;
            };

            //get selected item
            $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['code' => $code, 'status' => 7])->row_array();

            $prod_cat = $data['itemselect']['categories'];
            $item_id = $data['itemselect']['id'];
            $unit = $data['itemselect']['unit_satuan'];

            // add data to cart database
            $data_cart = array(
                'ref' => $ref,
                'date' => $date,
                'item_id' => $item_id,
                'customer_id' => $cust_id,
                'item_name' => $name,
                'prod_cat' => $prod_cat,
                'deliveryTo' => $cust_address,
                'qty' => $amount,
                'sack' => $sack,
                'weight' => $weight,
                'unit' => $unit,
                'price' => $price,
                'discount' => $discount,
                'subtotal' => $subtotal,
                'status' => 1,
                'description' => $desc
            );

            $this->db->insert('cart', $data_cart);
            $inserted_id = $this->db->insert_id();

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Process interupted!</div>');

            //add data to stock_finishedgoods database
            $transaction_status = 4;
            $warehouse = 3;
            $pcsperpack = $data['itemselect']['pcsperpack'];
            $packpersack = $data['itemselect']['packpersack'];
            $in_stockOld = $data['itemselect']['in_stock'];
            $conversion = $data['itemselect']['conversion'];
            if($discount != 0 or $discount != null){
                $netprice = $price-$discount;
            } else {
                $netprice = $price;
            };

            $data_warehouse = [
                'name' => $name,
                'code' => $code,
                'pcsperpack' => $pcsperpack,
                'packpersack' => $packpersack,
                'conversion' => $conversion,
                'date' => $date,
                'price' => $netprice,
                'categories' => $prod_cat,
                'in_stock' => 0,
                'incoming' => 0,
                'outgoing' => $amount,
                'unit_satuan' => $unit,
                'before_convert' => $weight, //before_convert col is used to store the item's weight
                'picture' => $inserted_id,
                'status' => $transaction_status,
                'warehouse' => $warehouse,
                'transaction_id' => $ref,
                'description' => $desc
                // 'customer_id' => $cust_id
            ];
            
            // USE THIS IF ITEM STOCK AKHIR IS CHANGED ON PAYMENT
            // $data2_warehouse = [
            //     'in_stock' => $in_stockOld - $amount,
            //     'date' => $date
            // ];

            // update inventory
            $this->db->insert('stock_finishedgoods', $data_warehouse);
            // USE THIS IF ITEM STOCK AKHIR IS CHANGED ON PAYMENT
            // update inventory stock_akhir
            // $this->db->where('code', $code);
            // $this->db->update('stock_finishedgoods', $data2_warehouse, 'status = 7');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item ' . $name .  ' with amount ' . $amount . ' ' . $unit .' added to cart!</div>');

            redirect('sales/add_salesorder/' . $ref);
        }
    }

    public function update_so()
    {
        $ref = $this->input->post('ref');
        $qty = $this->input->post('qtyID');
        $item_name = $this->input->post('item_name');
        $id = $this->input->post('id');
        $price = $this->input->post('priceID');
        $discount = $this->input->post('discID');
        $sack = $this->input->post('sackID');
        $weight = $this->input->post('weightID');
        $desc = $this->input->post('refID');

        $data_cart = array(
            'qty' => $qty,
            'price' => $price,
            'discount' => $discount,
            'subtotal' => ($price - $discount) * $qty,
            'sack' => $sack,
            'weight' => $weight,
            'description' => $desc
        );
        //to do: update inventory database due to amount change
        $this->db->where('id', $id);
        $this->db->update('cart', $data_cart);

        $data_warehouse = array(
            'outgoing' => $qty,
            'before_convert' => $weight,
            'price' => ($price - $discount),
            'description' => $desc
        );

        $this->db->where('transaction_id', $ref);
        $this->db->where('picture', $id);
        $this->db->update('stock_finishedgoods', $data_warehouse);

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">' . $item_name . ' details changed!</div>');
    }

    public function enlarge_image($img_name){
        //load user data per session
        $data['title'] = 'Payment Upload View';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getCustomer();

        $data['inv'] = $this->input->post('invoiceID');
        $data['image_name'] = $img_name;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/enlarge_image', $data);
        $this->load->view('templates/footer');
    }

    public function delete_cart_item($ref)
    {
        $ItemID = $this->input->post('delete_item_id');
        $CustName = $this->input->post('cust_name');
        $ItemName = $this->input->post('delete_item_name');

        $this->db->where('id', $ItemID);
        $this->db->delete('cart');

        $this->db->where('picture', $ItemID); //picture column is used to store cart ID
        $this->db->where('name', $ItemName);
        $this->db->delete('stock_finishedgoods');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $ItemName . ' on ' . $CustName . ' cart deleted!</div>');
        redirect('sales/add_salesorder/' . $ref);
    }

    public function clear_cart()
    {
        $refID = $this->input->post('delete_id');
        $this->db->delete('cart', array('ref' => $refID));

        $this->db->where('transaction_id', $refID);
        $this->db->delete('stock_finishedgoods');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cart deleted!</div>');
        redirect('sales/add_salesorder/' . $refID);
    }

    public function deliveryorder()
    {
        //load user data per session
        $data['title'] = 'Delivery Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $periode_id = $this->input->get('name');

        if($this->input->get('start_date') == null){
            //show data in current periode
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
            foreach($data['periode'] as $per) :
                if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
                    $data['current_periode'] = $per['period'];
                    $data['start_date'] = $per['start_date'];
                    $data['end_date'] = $per['end_date'];
                };
            endforeach;
            
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
        } else {
            //get data parameters
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

            $data['current_periode'] = $data['selectedMonth']['period'];
        }

        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getSaleswithTimeFrameEqualTo(2, $start_date, $end_date);
        // $data['dataCart'] = $this->custID->getCustomer();

        $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/deliveryorder', $data);
        $this->load->view('templates/footer');
    }

    public function delivery_detail($inv)
    {
        //load user data per session
        $data['title'] = 'Delivery Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataRow'] = $this->custID->getRow($inv);

        $data['customer'] = $data['dataRow']['name'];
        $data['ref'] = $inv;
        $data['date'] = $data['dataRow']['date'];
        $data['status'] = $data['dataRow']['status'];
        $data['address'] = $data['dataRow']['deliveryTo'];
        $data['reference'] = $data['dataRow']['description'];

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/delivery_detail', $data);
        $this->load->view('templates/footer');
    }

    public function createPDF($type, $inv)
    {
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->model('Sales_model', 'custID');
        $data['dataRow'] = $this->custID->getRow($inv);

        $data['ref'] = $inv;
        $data['cust_name'] = $data['dataRow']['name'];
        $data['date'] = $data['dataRow']['date'];
        $data['status'] = $data['dataRow']['status'];
        $data['address'] = $data['dataRow']['deliveryTo'];
        $data['user_name'] = $data['user']['name'];

        if ($type == 1) {
            $this->load->view('sales/pdf_sales_order', $data);
        } else if ($type == 2) {
            $this->load->view('sales/pdf_delivery_order', $data);
        } else if ($type == 3) {
            $this->load->view('sales/pdf_invoice', $data);
        } else if ($type == 4) {
            $this->load->view('sales/pdf_info', $data);
        }
    }

    public function invoice()
    {
        $data['title'] = 'Sales Invoice';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $periode_id = $this->input->get('name');

        if($this->input->get('start_date') == null){
            //show data in current periode
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
            foreach($data['periode'] as $per) :
                if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
                    $data['current_periode'] = $per['period'];
                    $data['start_date'] = $per['start_date'];
                    $data['end_date'] = $per['end_date'];
                };
            endforeach;
            
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
        } else {
            //get data parameters
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

            $data['current_periode'] = $data['selectedMonth']['period'];
        }

        //get cart database
        $status = 3;
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getSaleswithTimeFrameEqualTo($status, $start_date, $end_date);
        $data['dataCartperItem'] = $this->custID->getSaleswithTimeFrameEqualToperItem($status, $start_date, $end_date);

        // $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/invoice', $data);
        $this->load->view('templates/footer');
    }

    public function invoice_detail($inv)
    {
        //load user data per session
        $data['title'] = 'Invoice Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataRow'] = $this->custID->getRow($inv);

        $data['customer'] = $data['dataRow']['name'];
        $data['ref'] = $inv;
        $data['date'] = $data['dataRow']['date'];
        $data['status'] = $data['dataRow']['status'];
        $data['address'] = $data['dataRow']['deliveryTo'];
        $data['reference'] = $data['dataRow']['description'];

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/invoice_detail', $data);
        $this->load->view('templates/footer');
    }

    public function salesinfo()
    {
        $data['title'] = 'Sales Info';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $periode_id = $this->input->get('name');

        if($this->input->get('start_date') == null){
            //show data in current periode
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
            foreach($data['periode'] as $per) :
                if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
                    $data['current_periode'] = $per['period'];
                    $data['start_date'] = $per['start_date'];
                    $data['end_date'] = $per['end_date'];
                };
            endforeach;
            
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
        } else {
            //get data parameters
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

            $data['current_periode'] = $data['selectedMonth']['period'];
        }

        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getSaleswithTimeFrame(0, $start_date, $end_date);
        $data['dataCartperItem'] = $this->custID->getSalesPerItem(0, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/salesinfo', $data);
        $this->load->view('templates/footer');
    }

    public function info_detail($inv)
    {
        //load user data per session
        $data['title'] = 'Transaction Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataRow'] = $this->custID->getRow($inv);

        $data['customer'] = $data['dataRow']['name'];
        $data['ref'] = $inv;
        $data['date'] = $data['dataRow']['date'];
        $data['status'] = $data['dataRow']['status'];
        $data['address'] = $data['dataRow']['deliveryTo'];
        $data['reference'] = $data['dataRow']['description'];

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sales/info_detail', $data);
        $this->load->view('templates/footer');
    }

    //update production order product name
    public function update_sales_ref()
    {
        $ref = $this->input->post('id');
        $newName = $this->input->post('newName');

        $data = [
            'description' => $newName
        ];

        //update transaksi
        $this->db->where('transaction_id', $ref);
        $this->db->update('stock_finishedgoods', $data);

        $this->db->where('ref', $ref);
        $this->db->update('cart', $data);
    }
    
    public function paid()
    {
        $ref = $this->input->post('ref_id');

        $data = [
            'is_paid' => 1
        ];
        
        $this->db->where('ref', $ref);
        $this->db->update('cart', $data);

        //to get the correct period to redirect after a sales invoice is set to paid
        $data['getID'] = $this->db->get_where('cart', ['ref' => $ref])->row_array();
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
        
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Invoice ' . $ref . ' paid!</div>');
        redirect('sales/salesinfo/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '');
        // redirect('sales/salesinfo');
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
        // $this->load->model('Sales_model', 'terms_id');
        // $data['customer'] = $this->terms_id->getTerms();
        $data['customer'] = $this->db->get_where('user', ['role_id' => 3])->result_array();
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
                'terms_id' => $terms,
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
        // $this->form_validation->set_rules('account', 'account', 'trim');
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
            // $account = $this->input->post('account');
            // $terms = $this->input->post('terms');

            $data = [
                'name' => $name,
                'address' => $address,
                'email' => $email,
                'phone_number' => $phone_number,
                // 'bank_account' => $account,
                // 'terms_id' => $terms,
            ];
            $this->db->where('id', $id);
            $this->db->update('user', $data);
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
