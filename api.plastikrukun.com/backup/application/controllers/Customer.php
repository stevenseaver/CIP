<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Configuration;
use Xendit\Invoice\InvoiceAPI;

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

        // get trans ID
        $year = date('y');
        $month = date('m');
        $time = date('s');
        $serial = rand(100, 999);
        //ref invoice
        // $ref = 'INV-' . $year . $month . $time . '-' . $data['user']['id'] . $serial;

        // $data['ref'] = $ref;
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id']])->result_array();

        $data['productCategory'] = $this->db->get('product_category')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('customer/product_page', $data);
        $this->load->view('templates/footer');
    }

    public function cart()
    {
        //load user data per session
        $data['title'] = 'Cart';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id'], 'status' => '0'])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
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
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id']])->result_array();

        //get selected item
        $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();

        $this->form_validation->set_rules('amount', 'amount', 'numeric|required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar_cust', $data);
            $this->load->view('customer/product_page', $data);
            $this->load->view('templates/footer');
        } else {
            $customer = $data['user']['id'];
            $name = $data['itemselect']['name'];
            $price = $data['itemselect']['price'];
            $amount = $this->input->post('amount');
            $prod_cat = $data['itemselect']['categories'];
            $unit = $data['itemselect']['unit_satuan'];
            $subtotal = $data['itemselect']['price'] * $amount;

            $date = time();

            $data_cart = array(
                'date' => $date,
                'item_id' => $id,
                'customer_id' => $customer,
                'item_name' => $name,
                'prod_cat' => $prod_cat,
                'qty' => $amount,
                'price' => $price,
                'unit' => $unit,
                'subtotal' => $subtotal
            );

            // update cart
            $this->db->insert('cart', $data_cart);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item added to cart!</div>');

            redirect('customer');
        }
    }

    public function update_cart()
    {
        $qty = $this->input->post('qtyID');
        $item = $this->input->post('itemID');
        $id = $this->input->post('id');
        $price = $this->input->post('priceID');

        $data_cart = array(
            'qty' => $qty,
            'subtotal' => $price * $qty
        );
        //to do: update inventory database due to amount change
        $this->db->where('id', $id);
        $this->db->update('cart', $data_cart);

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">' . $item . ' quantity changed to ' . $qty . '.</div>');
    }

    public function delete_cart_item()
    {
        $ItemID = $this->input->post('delete_item_id');
        $CustName = $this->input->post('cust_name');
        $ItemName = $this->input->post('delete_item_name');

        $this->db->where('id', $ItemID);
        $this->db->delete('cart');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $ItemName . ' on ' . $CustName . ' cart deleted!</div>');
        redirect('customer/cart');
    }

    public function clear_cart()
    {
        $custID = $this->input->post('delete_id');
        $CustName = $this->input->post('cust_name');
        $this->db->delete('cart', array('customer_id' => $custID, 'status' => 0));

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $CustName . ' cart deleted!</div>');
        redirect('customer/cart');
    }

    public function check_out()
    {
        //load user data per session
        $data['title'] = 'Order Summary';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id'], 'status' => '0'])->result_array();

        $date = time();
        $year = date('y');
        $month = date('m');
        //ref invoice
        $n = 3;
        $result = bin2hex(random_bytes($n));
        $ref = 'S' . $year . $month . $result . $data['user']['id'];

        // $this->form_validation->set_rules('address', 'address', 'required|trim');
        // $this->form_validation->set_rules('city', 'city', 'required|trim');
        // $this->form_validation->set_rules('province', 'province', 'required|trim');
        // $this->form_validation->set_rules('country', 'country', 'required|trim');
        // $this->form_validation->set_rules('postal', 'postal', 'numeric|required|trim');

        // if ($this->form_validation->run() == false) {
        $address = $data['user']['address'] . ', ' . $data['user']['city'] . ', ' . $data['user']['province'] . ', ' . $data['user']['country'] . ', ' . $data['user']['postal'];
        // } else {
        //     $address = $this->input->post('address');
        //     $city = $this->input->post('city');
        //     $province = $this->input->post('province');
        //     $country = $this->input->post('country');
        //     $postal = $this->input->post('postal');

        //     $address = $address . ', ' . $city . ', ' . $province . ', ' . $country . ', ' . $postal;

        //     $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delivery address changed!</div>');
        // }

        $data['ref'] = $ref;
        $data['date'] = $date;
        $data['address'] = $address;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('customer/checkout', $data);
        $this->load->view('templates/footer');
    }

    public function payment($ref, $id_cust, $status)
    {
        //load user data per session
        $data['title'] = 'Check Out Confirmation';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $date = time();
        // $data['ref'] = $ref;
        $data['date'] = $date;
        $address = $data['user']['address'] . ', ' . $data['user']['city'] . ', ' . $data['user']['province'] . ', ' . $data['user']['country'] . ', ' . $data['user']['postal'];

        //cek jika ada gambar yang akan di upload
        // $upload_image = $_FILES['image']['name'];
        // $file_ext = pathinfo($upload_image, PATHINFO_EXTENSION);

        // if ($upload_image) {
        //     $config['file_name']            = $ref;
        //     $config['upload_path']          = './asset/img/payment/';
        //     $config['allowed_types']        = 'gif|jpg|png';
        //     $config['max_size']             = 2048;
        //     //load lib
        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);

        //     if ($this->upload->do_upload('image')) {
                //get cart database and update stock finished goods first
                //status 0 means the cart aren't yet assigned with ref number, hence if the user add more to the cart, they still can
                $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id'], 'status' => '0'])->result_array();
                foreach ($data['dataCart'] as $ci) :
                    //get selected item
                    $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['name' => $ci['item_name'], 'status' => 7])->row_array();

                    // var_dump($data['itemselect']);
                    // data to update inventory database
                    $transaction_status = 4;
                    $name = $data['itemselect']['name'];
                    $code = $data['itemselect']['code'];
                    $category = $data['itemselect']['categories'];
                    $warehouse = 3;
                    $amount = $ci['qty'];
                    $price = $data['itemselect']['price'];
                    $pcsperpack = $data['itemselect']['pcsperpack'];
                    $packpersack = $data['itemselect']['packpersack'];
                    $in_stockOld = $data['itemselect']['in_stock'];
                    $conversion = $data['itemselect']['conversion'];

                    $data_warehouse = [
                        'name' => $name,
                        'code' => $code,
                        'pcsperpack' => $pcsperpack,
                        'packpersack' => $packpersack,
                        'conversion' => $conversion,
                        'date' => $date,
                        'price' => $price,
                        'categories' => $category,
                        'in_stock' => 0,
                        'incoming' => 0,
                        'outgoing' => $amount,
                        'status' => $transaction_status,
                        'warehouse' => $warehouse,
                        'transaction_id' => $ref
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
                endforeach;
                
                // then upload image and update cart database
                // $new_image = $ref . '.' . $file_ext;

                $data_db = array(
                    'ref' => $ref,
                    'date' => $date,
                    'status' => 1,
                    'is_paid' => 1,
                    'deliveryTo' => $address
                );

                $this->db->where('customer_id', $id_cust);
                $this->db->where('status', $status);
                $this->db->update('cart', $data_db);

                redirect('customer/history');
            // } else {
            //     $this->session->set_flashdata('message', '<div class="alert alert-danger pb-0" role="alert">' . $this->upload->display_errors() . '. Double check your address, it will reset to the original address.</div>');
            //     redirect('customer/check_out/' . $data['user']['name'] . '/1');
            // }
        // } else {
        //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">No payment image to be uploaded! Double check your address, it will reset to the original address.</div>');
        //     redirect('customer/check_out/' . $data['user']['name'] . '/1');
        // }
    }


    public function history()
    {
        //load user data per session
        $data['title'] = 'Transaction History';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id']])->result_array();

        $data['inv'] = $this->input->post('invoiceID');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('customer/history', $data);
        $this->load->view('templates/footer');
    }

    public function history_details($inv, $date, $status)
    {
        //load user data per session
        $data['title'] = 'Transaction History Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get_where('cart', ['customer_id' => $data['user']['id']])->result_array();

        $data['ref'] = $inv;
        $data['date'] = $date;
        $data['status'] = $status;
        $data['address'] = $data['user']['address'] . ', ' . $data['user']['city'] . ', ' . $data['user']['province'] . ', ' . $data['user']['country'] . ', ' . $data['user']['postal'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar_cust', $data);
        $this->load->view('customer/history_details', $data);
        $this->load->view('templates/footer');
    }

    //** XENDIT PAYMENT */
    //** XENDIT PAYMENT */

    public function submitPayment(){
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $external_id = $this->input->post('external_id');
        $amount = $this->input->post('amount');
        $name = $this->input->post('name');

        // $this->load->library('xendit');

        Configuration::setXenditKey('xnd_development_UWOVFQtA7YiczxR9nPPVHAioV8TRnL5mTU1vcJHpTW55UW2oUuJsmb3UTAqO');

        $params = ([ 
            "external_id" => $external_id,
            "amount" => $amount,
            'description' => 'Order Payment',
            'invoice_duration' => 1800,
            'currency' => 'IDR',
            'reminder_time' => 1,
            'should_send_email' => 'true',
            'payer_email' => $data['user']['email'],
            // 'mobile_number' => 
            // 'customer' => [ 
            //     [
            //         'given_names' => $data['user']['name'],
            //         'email' => $data['user']['email'],
            //         'mobile_number' => $data['user']['phone_number'],
            //     ]
            // ],
            'success_redirect_url' => base_url('customer/payment/' . $external_id . '/'. $data['user']['id'] .'/0'),
            'failure_redirect_url' => base_url('customer/payment_failed'),
        ]);

        $apiInstance = new InvoiceApi();
        $create_invoice_request = new Xendit\Invoice\CreateInvoiceRequest($params); // \Xendit\Invoice\CreateInvoiceRequest
        $for_user_id = ""; // string | Business ID of the sub-account merchant (XP feature)

        try {
            $result = $apiInstance->createInvoice($create_invoice_request, $for_user_id);
            redirect($result['invoice_url']);
        } catch (\Xendit\XenditSdkException $e) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Exception when calling API:' . ' ' . $e->getMessage() . '!</div>');
            redirect(base_url('customer/check_out')); 
        }
    }

    public function payment_failed(){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is not right, please try again!</div>');
        redirect(base_url('customer/check_out')); 
    }

    public function createPDF($inv)
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

        $this->load->view('customer/pdf_invoice', $data);
    }
}
