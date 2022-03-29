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
            $status1 = 1;  //stock awal
            $status2 = 7;  //stock akhir
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
            $status1 = 1;   //SALDO AWAL
            $status2 = 7;   //SALDO AKHIR
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
    // GBJ Warehouse //

    public function gbj_wh()
    {
        $data['title'] = 'Finished Goods Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get finished good database
        $data['finishedStock'] = $this->db->get('stock_finishedgoods')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();
        $data['cat'] = $this->db->get('product_category')->result_array();

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
        $this->form_validation->set_rules('price', 'price', 'required|trim');
        $this->form_validation->set_rules('category', 'category', 'required|trim');

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
            $price = $this->input->post('price');
            $category = $this->input->post('category');
            $date = time();
            $status1 = 1; //stock awal
            $status2 = 7; //stock akhir
            $warehouse = $this->input->post('warehouse');

            //intital stock
            $data1 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'in_stock' => $initial_stock,
                'price' => $price,
                'categories' => $category,
                'status' => $status1,
                'warehouse'  => $warehouse
            ];
            //final stock
            $data2 = [
                'name' => $name,
                'code' => $code,
                'date' => $date,
                'price' => $price,
                'categories' => $category,
                'in_stock' => $initial_stock,
                'status' => $status2,
                'warehouse'  => $warehouse
            ];

            $this->db->insert('stock_finishedgoods', $data1);
            $this->db->insert('stock_finishedgoods', $data2);

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path']          = './asset/img/products/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('picture', 'asset/img/products/' . $new_image);
                    $this->db->where('code', $code);
                    $this->db->update('stock_finishedgoods');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('inventory/gbj_wh');
                }
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item ' . $name . ' added!</div>');
            redirect('inventory/gbj_wh');
        }
    }

    public function adjust_gbj()
    {
        $data['title'] = 'Finished Goods Warehouse';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollType'] = $this->db->get('stock_roll')->result_array();
        //join warehouse database 
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['finishedStock'] = $this->warehouse_id->getGBJWarehouseID();

        //validation
        $this->form_validation->set_rules('adjust_amount', 'stock amount', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/gbj', $data);
            $this->load->view('templates/footer');
            $this->session->set_flashdata('message_adjust', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
        } else {
            $name = $this->input->post('adjust_name');
            $code = $this->input->post('adjust_code');
            $amount = $this->input->post('adjust_amount');
            $data = [
                'in_stock' => $amount
            ];
            $this->db->where('code', $code);
            $this->db->update('stock_finishedgoods', $data, 'status = 7');
            $this->session->set_flashdata('message_adjust', '<div class="alert alert-success" role="alert">Item ' . $name . ' adjusted!</div>');
            redirect('inventory/gbj_wh');
        }
    }

    public function edit_gbj()
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
        $this->form_validation->set_rules('price', 'price', 'required|trim');
        $this->form_validation->set_rules('category', 'category', 'required|trim');

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
            $price = $this->input->post('price');
            $category = $this->input->post('category');

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path']          = './asset/img/products/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['finishedStock']['picture'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'asset/img/products/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('picture', 'asset/img/products/' . $new_image);
                    $this->db->where('code', $code);
                    $this->db->update('stock_finishedgoods');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('inventory/gbj_wh');
                }
            }

            //intital stock
            $data = [
                'name' => $name,
                'price' => $price,
                'categories' => $category
            ];
            $this->db->where('code', $code);
            $this->db->update('stock_finishedgoods', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item ' . $name . ' edited!</div>');
            redirect('inventory/gbj_wh');
        }
    }

    public function delete_gbj()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('delete_code');
        // get data on deleted sub menu
        $deletedItem = $this->db->get_where('stock_finishedgoods', array('code' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('stock_finishedgoods', array('code' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Asset named ' . $deletedItem["name"] . ' with code ' . $deletedItem["code"] . ' deleted!</div>');
        redirect('inventory/gbj_wh');
    }

    // INVENTORY ASSET
    // INVENTORY ASSET
    // INVENTORY ASSET

    public function assets()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/asset_invt', $data);
        $this->load->view('templates/footer');
    }

    // INVENTORY ADD ASSET
    public function add_asset()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->form_validation->set_rules('type', 'type', 'required|trim');
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('date_acquired', 'date acquired', 'required|trim');
        $this->form_validation->set_rules('position', 'position', 'required|trim');
        $this->form_validation->set_rules('spec', 'specification', 'required|trim|max_length[4096]');
        $this->form_validation->set_rules('value', 'value', 'required|trim');
        $this->form_validation->set_rules('status', 'status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure fields sure are incomplete!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/asset_invt', $data);
            $this->load->view('templates/footer');
        } else {
            // $code = $this->input->post('code', true);
            $type = $this->input->post('type', true);
            $name = $this->input->post('name', true);
            $date = $this->input->post('date_acquired', true);
            $spec = $this->input->post('spec', true);
            $value = $this->input->post('value', true);
            $position = $this->input->post('position', true);
            $status = $this->input->post('status', true);

            $data['room_name'] = $this->db->get_where('rooms', ['room_id' =>
            $position])->row_array();
            $data['count_num'] = $this->db->get_where('inventory_type', ['code' =>
            $type])->row_array();

            $loc_code = $data['room_name']['room_code'];
            $count = $data['count_num']['count'] + 1;

            if ($count < 10) {
                $data = [
                    'code' => 'INV-' . htmlspecialchars($loc_code) . '-' . htmlspecialchars($type) . '-00' . htmlspecialchars($count),
                    // 'code' => htmlspecialchars($code),
                    'name' => htmlspecialchars($name),
                    'date_in' => htmlspecialchars($date),
                    'position' =>  htmlspecialchars($position),
                    'spec' =>  htmlspecialchars($spec),
                    'value' => htmlspecialchars($value),
                    'status' => htmlspecialchars($status),
                ];
            } else if ($count < 100) {
                $data = [
                    'code' => 'INV-' . htmlspecialchars($loc_code) . '-' . htmlspecialchars($type) . '-0' . htmlspecialchars($count),
                    // 'code' => htmlspecialchars($code),
                    'name' => htmlspecialchars($name),
                    'date_in' => htmlspecialchars($date),
                    'position' =>  htmlspecialchars($position),
                    'spec' =>  htmlspecialchars($spec),
                    'value' => htmlspecialchars($value),
                    'status' => htmlspecialchars($status),
                ];
            } else if ($count >= 100) {
                $data = [
                    'code' => 'INV-' . htmlspecialchars($loc_code) . '-' . htmlspecialchars($type) . '-' . htmlspecialchars($count),
                    // 'code' => htmlspecialchars($code),
                    'name' => htmlspecialchars($name),
                    'date_in' => htmlspecialchars($date),
                    'position' =>  htmlspecialchars($position),
                    'spec' =>  htmlspecialchars($spec),
                    'value' => htmlspecialchars($value),
                    'status' => htmlspecialchars($status),
                ];
            }

            //create QR for new item
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './application/cache'; //string, the default is application/cache/
            $config['errorlog']     = './application/logs'; //string, the default is application/logs/
            $config['imagedir']     = './asset/img/QRCode/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
            $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name = $data['code'] . '.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $data['code']; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            //update asset db
            $this->db->insert('inventory_asset', $data);

            //update count
            $this->db->set('count', $count);
            $this->db->where('code', $type);
            $this->db->update('inventory_type');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item successfully created!</div>');
            redirect('inventory/assets');
        }
    }

    public function view_QR()
    {
        $data['title'] = 'QR Code Print';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        //data from modal
        $data['code'] = $this->input->post('code', true);
        $data['name'] = $this->input->post('name', true);
        $data['date'] = $this->input->post('date', true);
        $data['pos'] = $this->input->post('pos', true);

        //load view print_qr
        $this->load->view('templates/header', $data);
        $this->load->view('inventory/print_qr', $data);
    }

    public function edit_asset()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('spec', 'spec', 'required|trim|max_length[4096]');
        $this->form_validation->set_rules('value', 'value', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/asset_invt', $data);
            $this->load->view('templates/footer');
        } else {
            $code = $this->input->post('code', true);
            $name = $this->input->post('name', true);
            $spec = $this->input->post('spec', true);
            $value = $this->input->post('value', true);

            $data = [
                'name' => htmlspecialchars($name),
                'spec' => htmlspecialchars($spec),
                'value' => htmlspecialchars($value),
            ];

            $this->db->where('code', $code);
            $this->db->update('inventory_asset', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item successfully edited!</div>');
            redirect('inventory/assets');
        }
    }

    public function toggle_asset_status($usertoToggle, $is_active, $name)
    {
        if ($is_active == 1) {
            $this->db->set('status', 2);
            $this->db->where('id', $usertoToggle);
            $this->db->update('inventory_asset');
        } else if ($is_active == 2) {
            $this->db->set('status', 0);
            $this->db->where('id', $usertoToggle);
            $this->db->update('inventory_asset');
        } else if ($is_active == 0) {
            $this->db->set('status', 1);
            $this->db->where('id', $usertoToggle);
            $this->db->update('inventory_asset');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">' . urldecode($name) . ' status changed!</div>');
        redirect('inventory/assets');
    }

    public function transfer_asset()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->form_validation->set_rules('asset_destination', 'user', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/asset_invt', $data);
            $this->load->view('templates/footer');
        } else {
            $code = $this->input->post('transfer_asset_code');
            $name = $this->input->post('transfer_asset_name');
            $asset_destination = $this->input->post('asset_destination');

            $this->db->set('position', $asset_destination);
            $this->db->where('code', $code);
            $this->db->update('inventory_asset');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . urldecode($name) . ' Location changed!</div>');
            redirect('inventory/assets');
        }
    }
    //delete an asset
    public function delete_asset()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('delete_asset_id');
        // get data on deleted sub menu
        $deleteAsset = $this->db->get_where('inventory_asset', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('inventory_asset', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Asset named ' . $deleteAsset["name"] . ' with code ' . $deleteAsset["code"] . ' deleted!</div>');
        redirect('inventory/assets');
    }
    // assign asset to a user
    public function assign_user()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->form_validation->set_rules('user_assigned', 'user', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/asset_invt', $data);
            $this->load->view('templates/footer');
        } else {
            $code = $this->input->post('assign_asset_code');
            $name = $this->input->post('assign_asset_name');
            $userdat = $this->input->post('user_assigned');

            $this->db->set('user', $userdat);
            $this->db->where('code', $code);
            $this->db->update('inventory_asset');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . urldecode($name) . ' is assigned to ' . urldecode($userdat) . '!</div>');
            redirect('inventory/assets');
        }
    }

    // assign asset to a user
    public function use_asset()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();
        //get user and invt type
        $data['user_data'] = $this->db->get('user')->result_array();
        $data['inv_type'] = $this->db->get('inventory_type')->result_array();

        $this->form_validation->set_rules('assign_asset_user', 'User', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/asset_invt', $data);
            $this->load->view('templates/footer');
        } else {
            $code = $this->input->post('assign_asset_code');
            $name = $this->input->post('assign_asset_name');
            $userdat = $this->input->post('assign_asset_user');

            $this->db->set('user', $userdat);
            $this->db->where('code', $code);
            $this->db->update('inventory_asset');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . urldecode($name) . ' is assigned to ' . urldecode($userdat) . '!</div>');
            redirect('inventory/assets');
        }
    }

    public function delete_asset_user()
    {
        $code = $this->input->post('delete_user_code');
        $name = $this->input->post('delete_user_name');
        $userdat = $this->input->post('delete_user_user');

        $this->db->set('user', null);
        $this->db->where('code', $code);
        $this->db->update('inventory_asset');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . urldecode($name) . ' is no longer assigned to ' . urldecode($userdat) . '!</div>');
        redirect('inventory/assets');
    }

    public function delete_user()
    {
        $code = $this->input->post('delete_user_code');
        $name = $this->input->post('delete_user_name');
        $userdat = $this->input->post('delete_user_user');

        $this->db->set('user', null);
        $this->db->where('code', $code);
        $this->db->update('inventory_asset');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . urldecode($name) . ' is no longer assigned to ' . urldecode($userdat) . '!</div>');
        redirect('inventory/assets');
    }

    public function list_inventory()
    {
        $data['title'] = 'Asset Inventory';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //jpoin database room and asset_inventory
        $this->load->model('Inventory_model', 'inventory_id');
        //get invt database
        $data['inventory'] = $this->inventory_id->getRoomName();
        $data['room'] = $this->db->get('rooms')->result_array();

        $this->load->view('inventory/view_list', $data);
    }

    // public function qr_code()
    // {
    //     $data['title'] = 'QR Code';
    //     $data['user'] = $this->db->get_where('user', ['nik' =>
    //     $this->session->userdata('nik')])->row_array();
    //     //jpoin database room and asset_inventory
    //     $this->load->model('Inventory_model', 'inventory_id');
    //     //get invt database
    //     $data['inventory'] = $this->inventory_id->getRoomName();
    //     $data['room'] = $this->db->get('rooms')->result_array();

    //     $this->load->view('inventory/view_qr', $data);
    // }
}
