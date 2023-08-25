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
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getCustomer();
        // $data['dataCart'] = $this->db->get_where('cart')->result_array();

        // $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/sales', $data);
        $this->load->view('templates/footer');
    }

    public function sales_detail($customer, $inv, $date, $status)
    {
        //load user data per session
        $data['title'] = 'Customer Transaction Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['customer'] = $customer;
        $data['ref'] = $inv;
        $data['date'] = $date;
        $data['status'] = $status;

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();
        $data['address'] = $this->db->get_where('cart', ['ref' => $data['ref']])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
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
            // reset all in_stock on stock_finishedgoods database to the previous value
            $data['salesData'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $ref])->result_array();
            
            foreach ($data['salesData'] as $ci) :
                //get selected item
                $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['name' => $ci['name'], 'status' => 7])->row_array();
                
                $amount = $ci['outgoing'];
                
                echo $amount;
                
                $code = $data['itemselect']['code'];
                $in_stockOld = $data['itemselect']['in_stock'];
                
                // data to update inventory database
                $data2_warehouse = [
                    'in_stock' => $in_stockOld - $amount
                ];
                
                $this->db->where('code', $code);
                $this->db->where('status', 7);
                $this->db->update('stock_finishedgoods', $data2_warehouse);
            endforeach;
            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status changed into deliveries, final stock updated!</div>');
            redirect('sales/deliveryorder');
        } else if ($status_change_to == 3) {
            //invoice
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaction finished, send invoice to customer!</div>');
            redirect('sales/invoice');
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
                    
                    //delete all that has $ref on stock_finishedgoods database
                    $this->db->where('transaction_id', $ref);
                    $this->db->delete('stock_finishedgoods');
                    
            // return to page
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Transaction declined!</div>');
            redirect('sales/');
        }
    }

    public function add_salesorder($ref){
        //load user data per session
        $data['title'] = 'Add New Sales Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $date = time();
        $data['ref'] = $ref;    
        $data['date'] = $date;

        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $ref])->result_array();
        $data['gbjData'] = $this->db->get_where('stock_finishedgoods', ['status' => 7])->result_array();

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('code', 'code', 'required|trim');
        $this->form_validation->set_rules('price', 'price', 'required|trim');
        $this->form_validation->set_rules('amount', 'amount', 'numeric|required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar_cust', $data);
            $this->load->view('sales/add_salesorder', $data);
            $this->load->view('templates/footer');
        } else {
            // $customer = $data['user']['id'];
            // $name = $data['itemselect']['name'];
            // $price = $data['itemselect']['price'];
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $price = $this->input->post('price');
            $amount = $this->input->post('amount');
            // $prod_cat = $data['itemselect']['categories'];
            $subtotal = $price * $amount;

            echo $name . ' ';
            echo $code . ' ';
            echo $price . ' ';
            echo $amount . ' ';
            echo $subtotal;

            // $date = time();

            // $data_cart = array(
            //     'date' => $date,
            //     'item_id' => $id,
            //     'customer_id' => $customer,
            //     'item_name' => $name,
            //     'prod_cat' => $prod_cat,
            //     'qty' => $amount,
            //     'price' => $price,
            //     'subtotal' => $subtotal
            // );

            // // update cart
            // $this->db->insert('cart', $data_cart);
            // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item added to cart!</div>');

            // redirect('sales/add_salesorder/' . $ref);
        }
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
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/enlarge_image', $data);
        $this->load->view('templates/footer');
    }

    public function deliveryorder()
    {
        //load user data per session
        $data['title'] = 'Delivery Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getCustomer();

        $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/deliveryorder', $data);
        $this->load->view('templates/footer');
    }

    public function delivery_detail($customer, $inv, $date, $status)
    {
        //load user data per session
        $data['title'] = 'Delivery Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['customer'] = $customer;
        $data['ref'] = $inv;
        $data['date'] = $date;
        $data['status'] = $status;

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();
        $data['address'] = $this->db->get_where('cart', ['ref' => $data['ref']])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/delivery_detail', $data);
        $this->load->view('templates/footer');
    }

    public function createPDF($type, $inv, $customer, $date)
    {
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['user_name'] = $data['user']['name'];
        $data['ref'] = $inv;
        $data['cust_name'] = urldecode($customer);
        $data['date'] = $date;
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
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getCustomer();

        $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/invoice', $data);
        $this->load->view('templates/footer');
    }

    public function invoice_detail($customer, $inv, $date, $status)
    {
        //load user data per session
        $data['title'] = 'Invoice Order Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['customer'] = $customer;
        $data['ref'] = $inv;
        $data['date'] = $date;
        $data['status'] = $status;

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();
        $data['address'] = $this->db->get_where('cart', ['ref' => $data['ref']])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/invoice_detail', $data);
        $this->load->view('templates/footer');
    }

    public function salesinfo()
    {
        $data['title'] = 'Sales Info';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $this->load->model('Sales_model', 'custID');
        $data['dataCart'] = $this->custID->getInfo(0);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/salesinfo', $data);
        $this->load->view('templates/footer');
    }

    public function info_detail($customer, $inv, $date, $status)
    {
        //load user data per session
        $data['title'] = 'Transaction Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['customer'] = $customer;
        $data['ref'] = $inv;
        $data['date'] = $date;
        $data['status'] = $status;

        $data['dataCart'] = $this->db->get_where('cart', ['ref' => $data['ref']])->result_array();
        $data['address'] = $this->db->get_where('cart', ['ref' => $data['ref']])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('sales/info_detail', $data);
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
                'terms_id' => $terms,
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
