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
        //get cart database
        $data['dataCart'] = $this->db->get('cart')->result_array();

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
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();

        //get selected item
        $data['itemselect'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();

        $this->form_validation->set_rules('amount', 'amount', 'numeric|required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('customer/product_page', $data);
            $this->load->view('templates/footer');
        } else {
            $amount = $this->input->post('amount');

            $data_cart = array(
                'item_id' => $id,
                'customer' => $data['user']['name'],
                'qty' => $amount,
                'name' => $data['itemselect']['name'],
                'price' => $data['itemselect']['price'],
                'subtotal' => $data['itemselect']['price'] * $amount
            );

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

        $this->db->where('id', $id);
        $this->db->update('cart', $data_cart);

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">' . $item . ' quantity changed to ' . $qty . '.</div>');
    }


    public function delete_cart_item()
    {
        $CustName = $this->input->post('cust_name');
        $ItemName = $this->input->post('delete_ind_item');

        $this->db->where('customer', $CustName);
        $this->db->delete('cart', array('name' => $ItemName));

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $ItemName . ' on ' . $CustName . ' cart deleted!</div>');
        redirect('customer/cart');
    }

    public function clear_cart()
    {
        $name = $this->input->post('delete_name');
        $this->db->delete('cart', array('customer' => $name));

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $name . ' cart deleted!</div>');
        redirect('customer/cart');
    }

    public function history()
    {
        //load user data per session
        $data['title'] = 'Transaction History';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get('cart')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/history', $data);
        $this->load->view('templates/footer');
    }

    public function check_out($name, $status)
    {
        //load user data per session
        $data['title'] = 'Check Out Confirmation';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get('cart')->result_array();

        $date = time();
        $year = date('y');
        $month = date('m');
        $serial = rand(100, 999);
        $ref = 'INV-' . $year . $month . '-' . $serial;

        $data['ref'] = $ref;
        $data['date'] = $date;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/checkout', $data);
        $this->load->view('templates/footer');
    }

    public function payment($ref, $name, $status)
    {
        //load user data per session
        $data['title'] = 'Check Out Confirmation';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get cart database
        $data['dataCart'] = $this->db->get('cart')->result_array();

        $date = time();
        $data['ref'] = $ref;
        $data['date'] = $date;

        //cek jika ada gambar yang akan di upload
        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['upload_path']          = './asset/img/payment/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            //load lib
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $new_image = $this->upload->data('file_name');

                $data_db = array(
                    'ref' => $ref,
                    'date' => $date,
                    'status' => 1
                );

                $this->db->set('img', $new_image);
                $this->db->where('customer', $name);
                $this->db->where('status', $status);
                $this->db->update('cart', $data_db);

                redirect('customer/history');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger pb-0" role="alert">' . $this->upload->display_errors() . '</div>');
                redirect('customer/check_out/' . $data['user']['name'] . '/0');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">No payment image to be uploaded!</div>');
            redirect('customer/check_out/' . $data['user']['name'] . '/0');
        }
    }
}
