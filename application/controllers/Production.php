<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Audit_model', 'audit');
    }

    public function index()
    {
        $data['title'] = 'Production';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        // Sanitize inputs
        $start_date = (int) $this->input->get('start_date');
        $end_date   = (int) $this->input->get('end_date');
        $periode_id = $this->input->get('name'); // optional, derived below

        // If no valid dates passed, derive from current time
        if (!$start_date || !$end_date) {
            $periode    = getPeriodeByDate(time());
            $start_date = $periode['start_date'];
            $end_date   = $periode['end_date'];
            $periode_id = $periode['id'];
        }

        if ($start_date > $end_date) {
            show_error('Invalid date range.', 400);
        }

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['periode_id'] = $periode_id;

        //get inventory warehouse data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $transaction_query = 1; //unprocessed production order data
        $status = 3; //production order data only
        $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($status, $start_date, $end_date);
        // $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/production_report', $data);
        $this->load->view('templates/footer');
    }

    public function add_prod($id)
    {
        $data['title'] = 'Add Production Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        //this bit needs improvement
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
            $data['getID']['date'] = time();
        };

        $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $lastMaterial = $this->db->select('date')
                            ->where('transaction_id', $id)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_material')
                            ->row_array();
        
        $data['last_date'] = $lastMaterial ? date('Y-m-d', $lastMaterial['date']) : date('Y-m-d', time());

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_prodorder', $data);
        $this->load->view('templates/footer');
    }

    public function edit_prod($id)
    {
        $data['title'] = 'Add Production Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();

        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();
        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
            $data['getID']['date'] = time();
        }
        
        $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $lastMaterial = $this->db->select('date')
                            ->where('transaction_id', $id)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_material')
                            ->row_array();
        
        $data['last_date'] = $lastMaterial ? date('Y-m-d', $lastMaterial['date']) : date('Y-m-d', time());

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_prodorder', $data);
        $this->load->view('templates/footer');
    }

    //ADD ITEM PO
    public function add_item_prod($id, $status)
    {
        $data['title'] = 'Add Production Order';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get all stock akhir material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();

        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
            $data['getID']['date'] = time();
        }
        
        $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['po_id'] = $id;

        $lastMaterial = $this->db->select('date')
                            ->where('transaction_id', $id)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_material')
                            ->row_array();
        
        $data['last_date'] = $lastMaterial ? date('Y-m-d', $lastMaterial['date']) : date('Y-m-d', time());

        $this->form_validation->set_rules('materialSelect', 'material', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('description', 'description', 'required|trim');
        $this->form_validation->set_rules('campuran', 'mix amount', 'required|trim|numeric');
        $this->form_validation->set_rules('product_name', 'product name', 'required|trim');
        $this->form_validation->set_rules('report_date', 'date', 'required|trim');

        if ($this->form_validation->run() == false) {
            // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
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
            $product_name = $this->input->post('product_name');
            // $date = time();
            $date = strtotime($this->input->post('report_date'));
            $amount = $this->input->post('amount');
            $description = $this->input->post('description');
            $campuran = $this->input->post('campuran');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID, 'status' => 7])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $warehouse = $material_selected["warehouse"];
            $supplier = $material_selected["supplier"];
            $unit = $material_selected["unit_satuan"];
            $stock_old = $material_selected["in_stock"];
            $updated_stock = $stock_old - $amount;

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => $date,
                'price' => $price,
                'outgoing' => $amount,
                'in_stock' => $updated_stock,
                'unit_satuan' => $unit,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'product_name' => $product_name,
                'transaction_status' => $po_status,
                'description' => $description,
                'item_desc' => $campuran
            ];

            if($this->db->insert('stock_material', $data)){
                $inserted_id = $this->db->insert_id();
                $audit_id = $this->audit->log_audit('stock_material', $inserted_id, $po_id, 'CREATE', 'Initial stock of ' . $materialName . ': ' . $stock_old, 'Production order material added: ' . $materialName . ' with amount ' . $amount. ' ' . $unit . '. Updated stock: ' . $updated_stock);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };

            $data2 = [
                'in_stock' => $stock_old - $amount,
                'date' => $date,
                'price' => $price,
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $materialCode);
            $this->db->update('stock_material', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'. $materialName . ' with amount ' . $amount . ' ' . $unit . ' added!</div>');
            redirect('production/add_item_prod/' . $po_id . '/3/1');
        }
    }

    //update production order product name
    public function update_product_name()
    {
        $id = $this->input->post('id');
        $newName = $this->input->post('newName');

        $data['material_edited'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['transaction_id'];
        $data_old = $data['material_edited']['product_name'];

        $data = [
            'product_name' => $newName
        ];

        //update transaksi
        $this->db->where('transaction_id', $materialID);
        if($this->db->update('stock_material', $data)){
            $audit_id = $this->audit->log_audit('stock_material', 'multiple', $materialID, 'UPDATE', $data_old, 'Updated production name/title: ' . $newName);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
    }

    //update production order material amount
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

        $old_amount = [
            'date' => $data['material_edited']['date'],
            'in_stock' => $data['material_edited']['in_stock'],
            'outgoing' => $data['material_edited']['outgoing']
        ];

        $updated_amount = [
            'date' => $date,
            'in_stock' => $update_stock,
            'outgoing' => $amount
        ];

        //update transaksi
        $this->db->where('id', $id);
        // $this->db->set('outgoing', $amount);
        if($this->db->update('stock_material', $updated_amount)){
            $audit_id = $this->audit->log_audit('stock_material', $id, $prodID, 'UPDATE', 'Old ' . $data['material_edited']['name'] . ' usage: ' . $old_amount['outgoing'] . ' with stock ' . $old_amount['in_stock'], 'Updated amount used: ' . $updated_amount['outgoing'] . ' with final stock: ' . $updated_amount['in_stock']);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
        
        $data2 = [
            'in_stock' => $update_stock,
            'date' => $date
        ];
        //update stock akhir
        $this->db->where('status', '7');
        $this->db->where('code', $materialID);
        $this->db->update('stock_material', $data2);
        // log_audit('stock_material', $prodID, 'UPDATE');
    }

    //update production order material amount
    public function update_desc()
    {
        $id = $this->input->post('id');
        $prodID = $this->input->post('prodID');
        $amount = $this->input->post('qtyID');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_material', ['id' => $id])->row_array();
        $old_data = [
            'item_desc' => $data['material_edited']['item_desc'],
            'date' => $data['material_edited']['date']
        ];

        $data = [
            'item_desc' => $amount,
            'date' => $date
        ];

        //update transaksi
        $this->db->where('id', $id);
        // $this->db->set('item_desc', $amount);
        if($this->db->update('stock_material', $data)){
            $audit_id = $this->audit->log_audit('stock_material', $id, $prodID, 'UPDATE', $old_data, 'Updated description: ' . $data['item_desc'] . ' with date: ' . $data['date']);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
    }

    public function update_usage()
    {
        $id = $this->input->post('id');
        $prodID = $this->input->post('prodID');
        $amount = $this->input->post('qtyID');

        // --- Validation ---
        if (empty($id) || !is_numeric($id)) {
            return $this->_json_error('INVALID_ID', 'Invalid material id.', 400);
        }

        if ($amount === null || $amount === '' || !is_numeric($amount)) {
            return $this->_json_error('INVALID_AMOUNT', 'Usage amount must be a valid number.', 400);
        }

        if ($amount < 0) {
            return $this->_json_error('NEGATIVE_AMOUNT', 'Usage amount cannot be negative.', 400);
        }

        // --- Fetch existing record ---
        $material_edited = $this->db->get_where('stock_material', ['id' => $id])->row_array();

        if (!$material_edited) {
            return $this->_json_error('NOT_FOUND', 'Material record not found.', 404);
        }

        $old_term = $material_edited['term'];
        $data = ['term' => $amount];

        // --- Update ---
        $this->db->where('id', $id);
        if (!$this->db->update('stock_material', $data)) {
            return $this->_json_error('DB_UPDATE_FAILED', 'Failed to update usage in database.', 500);
        }

        // --- Audit log (non-fatal if it fails, but we report it) ---
        $audit_id = $this->audit->log_audit(
            'stock_material', $id, $prodID, 'UPDATE',
            'Update usage from: ' . $old_term, ' to: ' . $amount
        );

        $audit_warning = null;
        if (!$audit_id) {
            log_message('error', 'Audit log failed for stock_material id: ' . $id);
            $audit_warning = 'Usage updated, but audit log failed to record.';
        }

        $remaining = $material_edited['item_desc'] - $amount;

        $response = [
            'status'   => 'success',
            'remaining' => number_format($remaining, 2, ',', '.')
        ];

        if ($audit_warning) {
            $response['warning'] = $audit_warning;
        }

        echo json_encode($response);
    }

    /**
     * Helper to send a consistent JSON error response with HTTP status code.
     */
    private function _json_error($code, $message, $http_status = 400)
    {
        $this->output->set_status_header($http_status);
        echo json_encode([
            'status'  => 'error',
            'code'    => $code,
            'message' => $message
        ]);
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
        $this->load->view('production/details_prodorder', $data);
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
        if($this->db->delete('stock_material')){
            $audit_id = $this->audit->log_audit('stock_material', $id, $po_id, 'DELETE', 'Material ' . $data['material_edited']['name'] . ' used.', 'Material ' . $data['material_edited']['name'] . ' deleted. Final stock: ' . $update_stock);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material ' . $name . ' with amount ' . $amount . '  deleted!</div>');
        redirect('production/add_prod/' . $po_id);
    }

    public function delete_all_prod_order()
    {
        $this->form_validation->set_rules('confirm_key', 'confirmation key', 'required|trim');

        $po_id = $this->input->post('delete_po_id');
        $confirm_key = $this->input->post('confirm_key');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Production order not deleted, confirm key is missing!</div>');
            redirect('production/');
        } else {
            if($confirm_key == 'hapus'){
                //delete related PO items
                $data['material_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->result_array();
                $data['roll_selected'] = $this->db->get_where('stock_roll', ['transaction_id' => $po_id])->result_array();
                $data['gbj_selected'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $po_id])->result_array();
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
                if($this->db->delete('stock_material')){
                    $audit_id = $this->audit->log_audit('stock_material', 'multiple', $po_id, 'DELETE', 'Production order ' . $po_id . ' existed',  'Production order ' . $po_id . ' deleted');
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };
                };
        
                if(!empty($data['roll_selected'])){
                    //delete related PO items in roll_warehouse
                    $date = time();
        
                    foreach ($data['roll_selected'] as $rs) :
                        $data['updatestock'] = $this->db->get_where('stock_roll', ['code' => $rs['code'], 'status' => 7])->row_array();
                        $stock_akhir = $data['updatestock']['in_stock'];
                        if ($rs['status'] == 3) { 
                            $update_stock = ($stock_akhir - $rs['incoming']);
                            $stock_akhir = $update_stock;
        
                            $data2 = [
                                'in_stock' => $update_stock,
                                'date' => $date
                            ];
        
                            // update stock akhir
                            $this->db->where('status', '7');
                            $this->db->where('code', $rs['code']);
                            $this->db->update('stock_roll', $data2);
                        } else {
        
                        }
                    endforeach;
                    $this->db->where('transaction_id', $po_id);
                    if($this->db->delete('stock_roll')){
                        $audit_id = $this->audit->log_audit('stock_roll', 'multiple', $po_id, 'DELETE', 'Roll item on Prod. Order ' . $po_id . ' existed',  'Roll item on Prod. Order ' . $po_id . ' deleted');
                        if (!$audit_id) {
                            log_message('error', 'Audit log failed');
                        };
                    }; 
                }
                
                
                if(!empty($data['gbj_selected'])){
                    //delete related PO items in stock_finishedgoods warehouse
                    $date = time();
        
                    foreach ($data['gbj_selected'] as $gs) :
                        $data['updatestock'] = $this->db->get_where('stock_finishedgoods', ['code' => $gs['code'], 'status' => 7])->row_array();
                        $stock_akhir = $data['updatestock']['in_stock'];
                        if ($gs['transaction_status'] == 2 or $gs['unit_satuan'] != 'pack') { 
                            //only update if item is already converted to pack or item unit is in weight
                            $update_stock = ($stock_akhir - $gs['incoming']);
                            $stock_akhir = $update_stock;
            
                            $data2 = [
                                'in_stock' => $update_stock,
                                'date' => $date
                            ];
                            // update stock akhir
                            $this->db->where('status', '7');
                            $this->db->where('code', $gs['code']);
                            $this->db->update('stock_finishedgoods', $data2);
                        } else {
        
                        }
                    endforeach;
                    $this->db->where('transaction_id', $po_id);
                    // $this->db->delete('stock_finishedgoods');   
                    if($this->db->delete('stock_finishedgoods')){
                        $audit_id = $this->audit->log_audit('stock_finishedgoods', 'multiple', $po_id, 'DELETE', 'FG item on Prod. Order ' . $po_id . ' existed',  'FG item on Prod. Order ' . $po_id . ' deleted');
                        if (!$audit_id) {
                            log_message('error', 'Audit log failed');
                        };
                    }; 
                }
        
        
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Production order unsaved, item(s) are deleted!</div>');
                redirect('production/');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Production order not deleted, confirm key is not correct!</div>');
                redirect('production/');
            };
        };
    }

    public function createPDF($po_id)
    {
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['ref'] = $po_id;
        $data['getRow'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->row_array();

        if($data['getRow'] == null ){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">There is no data yet!</div>');
            redirect('production/add_prod/'. $po_id);
        } else {
            $data['date'] = $data['getRow']['date'];
            $data['batch'] = $data['getRow']['description'];
            $data['product_name'] = $data['getRow']['product_name'];
            
            $this->load->view('production/view_prodorder', $data);
        }
    }

    public function createPDF_prod($po_id)
    {
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['ref'] = $po_id;
        $data['getRow'] = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->row_array();

        if($data['getRow'] == null ){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">There is no data yet!</div>');
            redirect('production/add_prod/'. $po_id);
        } else {
            $data['date'] = $data['getRow']['date'];
            $data['batch'] = $data['getRow']['description'];
            $data['product_name'] = $data['getRow']['product_name'];
            
            $this->load->view('production/print_prodorder', $data);
        }
    }

    /*** INPUT ROLL
     * ROLL ITEM INPUT AFTER BEING EXTRUDED VIA EXTRUDER MACHINE
     */
    public function inputRoll()
    {
        $data['title'] = 'Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        // Sanitize inputs
        $start_date = (int) $this->input->get('start_date');
        $end_date   = (int) $this->input->get('end_date');
        $periode_id = $this->input->get('name'); // optional, derived below

        // If no valid dates passed, derive from current time
        if (!$start_date || !$end_date) {
            $periode    = getPeriodeByDate(time());
            $start_date = $periode['start_date'];
            $end_date   = $periode['end_date'];
            $periode_id = $periode['id'];
        }

        if ($start_date > $end_date) {
            show_error('Invalid date range.', 400);
        }

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['periode_id'] = $periode_id;

        //get inventory warehouse data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $transaction_query = 1; //unprocessed production order data
        $status = 3; //production order data only
        $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($status, $start_date, $end_date);
        // $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/roll_report', $data);
        $this->load->view('templates/footer');
    }

    public function roll_details($prodID)
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
        $this->load->view('production/details_roll', $data);
        $this->load->view('templates/footer');
    }

    public function add_roll($prodID)
    {
        $data['title'] = 'Add Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollSelect'] = $this->db->order_by('name','ASC')->get_where('stock_roll', ['status' => 7])->result_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();

        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['po_id'] = $prodID;

        // Get the last material item used in this production order
        $lastMaterial = $this->db->select('date')
                            ->where('transaction_id', $prodID)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_material')
                            ->row_array();
        
        $data['last_material_date'] = $lastMaterial ? date('Y-m-d', $lastMaterial['date']) : date('Y-m-d', time());

        // Get the last roll item used in this production order
        $lastRoll = $this->db->select('name, code, weight, lipatan, price, batch, transaction_desc, date')
                            ->where('transaction_id', $prodID)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_roll')
                            ->row_array();
        if (!$lastRoll) {
            $lastRoll = $this->db->select('name, code, weight, lipatan, price, batch, transaction_desc, date')
                                ->where('transaction_id', $prodID)
                                ->order_by('id', 'DESC')
                                ->limit(1)
                                ->get('stock_roll')
                                ->row_array();
        };
        
        $data['lastRoll'] = $lastRoll;
        $data['last_date'] = $data['lastRoll'] ? date('Y-m-d', $data['lastRoll']['date']) : date('Y-m-d', time());

        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();

        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
        };
        //MATERIAL ITEMS HERE

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_roll', $data);
        $this->load->view('templates/footer');
    }

    public function add_roll_item($prodID, $status, $warehouse)
    {
        $data['title'] = 'Add Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollSelect'] = $this->db->order_by('name','ASC')->get_where('stock_roll', ['status' => 7])->result_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();

        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['po_id'] = $prodID;

        //MATERIAL ITEMS HERE
        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();

        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
        };

        $this->form_validation->set_rules('rollName', 'roll item', 'trim|required');
        $this->form_validation->set_rules('code', 'code', 'trim|required');
        $this->form_validation->set_rules('amount', 'amount', 'trim|required');
        $this->form_validation->set_rules('price_roll', 'price', 'trim|required');
        $this->form_validation->set_rules('batch', 'batch', 'trim|required');
        $this->form_validation->set_rules('roll_no', 'roll description', 'trim|required');
        $this->form_validation->set_rules('report_date', 'date', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_roll', $data);
            $this->load->view('templates/footer');
        } else {
            $item = $this->input->post('rollName');
            $code = $this->input->post('code');
            $weight = $this->input->post('weight');
            $lipatan = $this->input->post('lipatan');
            $date = strtotime($this->input->post('report_date'));
            // $date = time() - 86400;
            $amount = $this->input->post('amount');
            $price = $this->input->post('price_roll');
            $batch = $this->input->post('batch');
            $roll_no = $this->input->post('roll_no');
            $transaction_status = 2;

            $rollSelect = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();
            $stock_old = $rollSelect['in_stock'];

            // if ($item == 'AVALAN ROLL' or $item == 'PRONGKOLAN ROLL'){
            //     $price_inputed = $this->input->post('price_roll');
            //     $price_before = $rollSelect['price'];

            //     $amount_inputed = $amount;
            //     $amount_before = $stock_old;

            //     $price_update = ($price_inputed*$amount_inputed)+($price_before*$amount_before)/($amount_inputed+$amount_before);
            // } else {
            //     $price_update = $price;
            // };
            $updated_stock = $stock_old + $amount;

            $data = [
                'name' => $item,
                'code' => $code,
                'date' => $date,
                'weight' => $weight,
                'lipatan' => $lipatan,
                'incoming' => $amount,
                'outgoing' => 0,
                'in_stock' => 0,
                'in_stock' => $updated_stock,
                'price' => $price,
                'status' => 3,
                'warehouse' => 2,
                'transaction_id' => $prodID,
                'batch' => $batch,
                'transaction_desc' => $roll_no
            ];

            if($this->db->insert('stock_roll', $data)){
                $inserted_id = $this->db->insert_id();
                $audit_id = $this->audit->log_audit('stock_roll', $inserted_id, $prodID, 'CREATE', 'Initial stock of ' . $item . ': ' . $stock_old, 'Production order roll added: ' . $item . ' with amount ' . $amount. ' kg. Updated stock: ' . $updated_stock);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };

            $data2 = [
                'in_stock' => $updated_stock,
                'date' => $date,
                'price' => $price
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $code);
            $this->db->update('stock_roll', $data2);

            // $production_status = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
            // if($production_status['transaction_status'] != 2){
            //     $this->db->where('transaction_id', $prodID)->update('stock_material', [
            //         'transaction_status' => 2
            //     ]);
            // }
            $production_status = $this->db->select('transaction_status')->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
            // Check if any row has transaction_status != 2, 2 is roll started
            $has_non_two = array_filter($production_status, fn($row) => $row['transaction_status'] < 2);

            if (!empty($has_non_two)) {
                $this->db->where('transaction_id', $prodID)->update('stock_material', [
                    'transaction_status' => 2
                ]);
            }
            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Roll ' . $item . ' with amount ' . $amount . ' kg added!</div>');
            redirect('production/add_roll/' . $prodID);
        }
    }

    // FOR THE EASE OF EXTRUSION PRODUCTION STAFF to ENTER THE ROLL PRODUCED, WE USE A GENERAL INPUT ROLL FORM THAT AUTOMATICALLY DETECTS THE PRODUCTION BATCH AND THE ROLL USED USING QR-CODES
    public function add_roll_general()
    {
        $data['title'] = 'General Roll Input Form';
        $data['user'] = $this->db->get_where('user', ['nik' => $this->session->userdata('nik')])->row_array();

        if ($this->input->post()) {
            $this->_process_add_roll_general();
            return;
        }

        $data['rollSelect'] = $this->db->order_by('name', 'ASC')->get_where('stock_roll', ['status' => 7])->result_array();
        $today_start = mktime(0,  0,  0,  date('n'), date('j'), date('Y'));
        $today_end   = mktime(23, 59, 59, date('n'), date('j'), date('Y'));

        $data['rollType'] = $this->db->get_where('stock_roll', ['status' => 3,'date >=' => date($today_start), 'date <=' => date($today_end),])->result_array();
        // $data['rollType'] = $this->db->get_where('stock_roll', ['status' => 11])->result_array(); //CHANGE INTO ONLY ASK FOR TODAY'S DATE

        $lastRoll = $this->db->select('name, code, weight, lipatan, price, batch, transaction_desc, date, transaction_id')
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_roll')
                            ->row_array();

        if (!$lastRoll) {
            $lastRoll = $this->db->select('name, code, weight, lipatan, price, batch, transaction_desc, date, transaction_id')
                                ->order_by('id', 'DESC')
                                ->limit(1)
                                ->get('stock_roll')
                                ->row_array();
        }

        $data['lastRoll'] = $lastRoll;
        $data['getID'] = $lastRoll;
        $data['last_date'] = $lastRoll ? date('Y-m-d', $lastRoll['date']) : date('Y-m-d');

        if (empty($data['getID'])) {
            $data['getID']['description']  = 1;
            $data['getID']['product_name'] = 1;
        }

        $data['last_po_id'] = $this->session->flashdata('last_po_id') ?? $data['lastRoll']['transaction_id'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_general_roll', $data);
        $this->load->view('templates/footer');
    }

    private function _process_add_roll_general()
    {
        $item    = $this->input->post('rollName');
        $code    = $this->input->post('code');
        $weight  = $this->input->post('weight');
        $lipatan = $this->input->post('lipatan');
        $date    = strtotime($this->input->post('report_date'));
        $amount  = $this->input->post('amount');
        $price   = $this->input->post('price_roll');
        $batch   = $this->input->post('batch') . '-' . $this->input->post('machine') . '-' . $this->input->post('shift') . '-' . $this->input->post('operator');
        $roll_no = $this->input->post('roll_no');
        $prodID  = $this->input->post('po_id');

        $rollSelect = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();

        if (!$rollSelect) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Roll dengan kode <strong>' . $code . '</strong> tidak ditemukan di stok.</div>');
            redirect('production/add_roll_general');
            return;
        }

        $stock_old     = $rollSelect['in_stock'];
        $updated_stock = $stock_old + $amount;

        $data = [
            'name'             => $item,
            'code'             => $code,
            'date'             => $date,
            'weight'           => $weight,
            'lipatan'          => $lipatan,
            'incoming'         => $amount,
            'outgoing'         => 0,
            'in_stock'         => $updated_stock,
            'price'            => $price,
            'status'           => 3, //prod status
            'warehouse'        => 2,
            'transaction_id'   => $prodID,
            'batch'            => $batch,
            'transaction_desc' => $roll_no
        ];

        if ($this->db->insert('stock_roll', $data)) {
            $inserted_id = $this->db->insert_id();
            $audit_id = $this->audit->log_audit('stock_roll', $inserted_id, $prodID, 'CREATE', 'Initial stock of ' . $item . ': ' . $stock_old, 'Production order roll added: ' . $item . ' with amount ' . $amount . ' kg. Updated stock: ' . $updated_stock);

            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            }

            $data2 = [
                'in_stock' => $updated_stock,
                'date'     => $date,
                'price'    => $price
            ];
            $this->db->where('status', 7);
            $this->db->where('code', $code);
            $this->db->update('stock_roll', $data2);

            // $production_status = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
            // if($production_status['transaction_status'] != 2){
            //     $this->db->where('transaction_id', $prodID)->update('stock_material', [
            //         'transaction_status' => 2
            //     ]);
            // }
            
            // Check if any row has transaction_status != 2, 2 is roll started
            $production_status = $this->db->select('transaction_status')->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
            $has_non_two = array_filter($production_status, fn($row) => $row['transaction_status'] < 2);

            if (!empty($has_non_two)) {
                $this->db->where('transaction_id', $prodID)->update('stock_material', [
                    'transaction_status' => 2
                ]);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Roll <strong>' . $item . '</strong> dengan jumlah <strong>' . $amount . ' kg</strong> berhasil ditambahkan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyimpan data. Silakan coba lagi.</div>');
        }

        $this->session->set_flashdata('last_po_id', $prodID);
        redirect('production/add_roll_general');
    }

    public function print_general_ticket()
    {
        $type = $this->input->get('type');

        $data = [
            'po_id'   => $this->input->get('po_id'),
            'id'      => $this->input->get('id'),
            'batch'   => $this->input->get('batch'),
            'name'    => $this->input->get('name'),
            'amount'  => $this->input->get('amount'),
            'gram'    => $this->input->get('gram'),
            'guset'   => $this->input->get('guset'),
            'desc'    => $this->input->get('desc'),
        ];

        $this->load->view('production/print_roll_label', $data);
    }

    public function check_po_id()
    {
        $po_id = $this->input->get('po_id');
        $result = $this->db->get_where('stock_material', ['transaction_id' => $po_id])->row_array();

        $this->output->set_content_type('application/json');
        if ($result) {
            echo json_encode([
                'status' => 'found',
                'data'   => $result
            ]);
        } else {
            echo json_encode(['status' => 'not_found']);
        }
    }

    public function get_roll_by_code()
    {
        $code = $this->input->get('code');
        $roll = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();

        if ($roll) {
            echo json_encode(['status' => 'found', 'data' => $roll]);
        } else {
            echo json_encode(['status' => 'not_found']);
        }
    }

     //delete Input Roll per item
    public function delete_item_roll_general_form()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $date = time();

        $data['material_deleted'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $materialID = $data['material_deleted']['code'];

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
        if($this->db->delete('stock_roll')){
            $audit_id = $this->audit->log_audit('stock_roll', $id, $po_id, 'DELETE', 'Roll item ' . $po_id . ': ' . $name . '  with amount ' . $amount, 'Deleted');
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        }; 
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material <strong>' . $name . '</strong> with amount <strong>' . $amount . '</strong>  kg deleted!</div>');
        redirect('production/add_roll_general');
    }

    public function add_item_prod_after_roll($prodID, $status)
    {
        $data['title'] = 'Add Roll Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['rollSelect'] = $this->db->order_by('name','ASC')->get_where('stock_roll', ['status' => 7])->result_array();
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();

        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['po_id'] = $prodID;

        //MATERIAL ITEMS HERE
        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();

        if ($data['getID'] != null) {
        } else {
            $data['getID']['description'] = 1;
            $data['getID']['product_name'] = 1;
        };

        $this->form_validation->set_rules('materialSelect', 'material', 'required');
        $this->form_validation->set_rules('mat_amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('description', 'description', 'required|trim');
        $this->form_validation->set_rules('campuran', 'mix amount', 'required|trim|numeric');
        $this->form_validation->set_rules('product_name', 'product name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_roll', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $po_id = $prodID;
            $po_status = 1;
            $materialID = $this->input->post('materialSelect');
            $price = $this->input->post('price');
            $product_name = $this->input->post('product_name');
            $date = strtotime($this->input->post('report_date'));
            $amount = $this->input->post('mat_amount');
            $description = $this->input->post('description');
            $campuran = $this->input->post('campuran');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID, 'status' => 7])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $warehouse = $material_selected["warehouse"];
            $supplier = $material_selected["supplier"];
            $unit = $material_selected["unit_satuan"];
            $stock_old = $material_selected["in_stock"];
            $updated_stock = $stock_old - $amount;

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => $date,
                'price' => $price,
                'outgoing' => $amount,
                'in_stock' => $updated_stock,
                'unit_satuan' => $unit,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'product_name' => $product_name,
                'transaction_status' => $po_status,
                'description' => $description,
                'item_desc' => $campuran
            ];

            if($this->db->insert('stock_material', $data)){
                $inserted_id = $this->db->insert_id();
                $audit_id = $this->audit->log_audit('stock_material', $inserted_id, $po_id, 'CREATE', 'Initial stock of ' . $materialName . ': '  . $stock_old . ' kg', 'Production order material added: ' . $materialName . ' with amount ' . $amount. ' ' . $unit . '. Updated stock: ' . $updated_stock . ' ' . $unit);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };

            $data2 = [
                'in_stock' => $updated_stock,
                'date' => $date,
                'price' => $price,
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $materialCode);
            $this->db->update('stock_material', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Additional material added!</div>');
            redirect('production/add_roll/' . $po_id);
        }
    }

    //update production order roll amount
    public function update_roll_amount()
    {
        $id = $this->input->post('id');
        $prodID = $this->input->post('prodID');
        $amount = $this->input->post('qtyID');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];
        $adjust_old = $data['material_edited']['incoming'];

        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_roll', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];

        $update_stock = ($stock_akhir - $adjust_old) + $amount;

        $old_amount = [
            'date' => $data['material_edited']['date'],
            'incoming' => $data['material_edited']['incoming'],
            'in_stock' => $data['material_edited']['in_stock']
        ];
                    
        //update transaksi
        $updated_amount = [
            'date' => $date,
            'incoming' => $amount,
            'in_stock' => $update_stock
        ];

        $this->db->where('id', $id);
        if($this->db->update('stock_roll', $updated_amount)){
            $audit_id = $this->audit->log_audit('stock_roll', $id, $prodID, 'UPDATE', 'Old roll amount: ' . $old_amount['incoming'] . ' with old stock: ' . $old_amount['in_stock'], 'New roll amount: ' . $updated_amount['incoming'] . ' with new stock: ' . $updated_amount['in_stock']);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
        
        //update stock akhir
        $data2 = [
            'in_stock' => $update_stock,
            'date' => $date
        ];
        $this->db->where('status', '7');
        $this->db->where('code', $materialID);
        $this->db->update('stock_roll', $data2);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Production item amount <strong>' . $data['material_edited']['name'] . '</strong> updated to <strong>' . $amount . '</strong> kg!</div>');
    }

    //update production order material amount
    public function update_roll_details($type)
    {
        $id = $this->input->post('id');
        $date = time();
        $old_item = null;
        $updated_item = null;

        $data['rollEdited'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $prodID = $data['rollEdited']['transaction_id']; 
        $rollID = $data['rollEdited']['code']; 

        if ($type == 1) { //roll number/description
            $desc = $this->input->post('descRoll');
            $before_item = $data['rollEdited']['transaction_desc'];
            $updated_item = $desc;
  
            $data = [
                'transaction_desc' => $desc
                // 'date' => $date
            ];
        } else if ($type == 2){ //batch
            $batch = $this->input->post('batchRoll');
            $before_item = $data['rollEdited']['batch'];
            $updated_item = $batch;

            $data = [
                'batch' => $batch
                // 'date' => $date
            ];
        } else if ($type == 3){ //price
            $price = $this->input->post('priceRoll');
            $before_item = $data['rollEdited']['price'];
            $updated_item = $price;

            $data = [
                'price' => $price
                // 'date' => $date
            ];
        //delete this portion if edit price don't affect stock akhir price  
            $this->db->where('status', '7');
            $this->db->where('code', $rollID);
            $this->db->update('stock_roll', $data);
        } 

        //update transaksi
        $this->db->where('id', $id);
        if($this->db->update('stock_roll', $data)){
            $audit_id = $this->audit->log_audit('stock_roll', $id, $prodID, 'UPDATE', $before_item, 'Description updated to: ' . $updated_item);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Production item details updated from ' . $before_item . ' to <strong>' . $updated_item . '</strong>!</div>');
    }

    public function changeStatus($prodID){
        $transaction_status = $this->input->get('status');
        $prodID = $this->input->get('prodID');
        
        $data = [
            'transaction_status' => $transaction_status
        ];

        $this->db->where('transaction_id', $prodID);
        $this->db->update('stock_material', $data);

        redirect('production/gbj_details/' . $prodID);
    }

    //delete Input Roll per item
    public function delete_item_roll()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $date = time();

        $data['material_deleted'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $materialID = $data['material_deleted']['code'];

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
        if($this->db->delete('stock_roll')){
            $audit_id = $this->audit->log_audit('stock_roll', $id, $po_id, 'DELETE', 'Roll item ' . $po_id . ': ' . $name . '  with amount ' . $amount, 'Deleted');
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        }; 
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material ' . $name . ' with amount ' . $amount . '  deleted!</div>');
        redirect('production/add_roll/' . $po_id);
    }

    public function delete_all_roll()
    {
        $this->form_validation->set_rules('confirm_key', 'confirmation key', 'required|trim');

        $po_id = $this->input->post('delete_roll_id');
        $confirm_key = $this->input->post('confirm_key');

        //delete related PO items
        $data['roll_selected'] = $this->db->get_where('stock_roll', ['transaction_id' => $po_id])->result_array();
        $date = time();

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Production order not deleted, confirm key is missing!</div>');
            redirect('production/');
        } else {
            if($confirm_key == 'hapus'){
                foreach ($data['roll_selected'] as $rs) :
                    $data['updatestock'] = $this->db->get_where('stock_roll', ['code' => $rs['code'], 'status' => 7])->row_array();
                    $stock_akhir = $data['updatestock']['in_stock'];
        
                    $update_stock = ($stock_akhir - $rs['incoming']);
                    $stock_akhir = $update_stock;
        
                    $data2 = [
                        'in_stock' => $update_stock,
                        'date' => $date
                    ];
        
                    // update stock akhir
                    $this->db->where('status', '7');
                    $this->db->where('code', $rs['code']);
                    $this->db->update('stock_roll', $data2);
                endforeach;
                $this->db->where('transaction_id', $po_id);
                if($this->db->delete('stock_roll')){
                    $audit_id = $this->audit->log_audit('stock_roll', 'multiple', $po_id, 'DELETE', 'All roll item on ' . $po_id, 'Deleted');
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };
                }; 
        
                $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Production order deleted, item(s) are adjusted!</div>');
                redirect('production/inputRoll');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Production order not deleted, confirm key is not correct!</div>');
                redirect('production/');
            };
        }
        
    }

    public function print_ticket(){
        $data['title'] = 'Print Roll Ticket';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data from form
        $data['prod_id'] = $this->input->post('po_id');
        $data['batch'] = $this->input->post('batch');
        $data['item'] = $this->input->post('name');
        $data['gram'] = $this->input->post('gram');
        $data['guset'] = $this->input->post('guset');
        $data['net_weight'] = $this->input->post('amount');
        $data['desc'] = $this->input->post('desc');

        $type = $this->input->get('type');
        if ($type == 1){
            $data['roll_back'] = 'add_roll';
        } else if ($type == 2){
            $data['roll_back'] = 'roll_details';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/print_ticket_roll', $data);
        $this->load->view('templates/footer');
        // echo $prod_id . ' ' . $batch . ' ' . $item . ' ' . $net_weight;
    }

    /** GBJ Report From */
    /** GBJ Report From */
    /** GBJ Report From */
    public function gbj_report()
    {
        $data['title'] = 'Finished Goods Report';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

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
        // Sanitize inputs
        $start_date = (int) $this->input->get('start_date');
        $end_date   = (int) $this->input->get('end_date');
        $periode_id = $this->input->get('name'); // optional, derived below

        // If no valid dates passed, derive from current time
        if (!$start_date || !$end_date) {
            $periode    = getPeriodeByDate(time());
            $start_date = $periode['start_date'];
            $end_date   = $periode['end_date'];
            $periode_id = $periode['id'];
        }

        if ($start_date > $end_date) {
            show_error('Invalid date range.', 400);
        }

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['periode_id'] = $periode_id;

        //get inventory warehouse data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $transaction_query = 1; //unprocessed  data
        $status = 3; //production order data only
        // $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($transaction_query, $status, $start_date, $end_date);
        $data['materialStock'] = $this->warehouse_id->prodOrderwithTimeFrame($status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/gbj_report', $data);
        $this->load->view('templates/footer');
    }

    public function gbj_details($prodID)
    {
        $data['title'] = 'Finished Goods Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        
        //material items
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
        $data['po_id'] = $prodID;
        
        //roll items
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();

        //gbj items
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $prodID])->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/details_gbj', $data);
        $this->load->view('templates/footer');
    }

    public function add_gbj($prodID)
    {
        $data['title'] = 'Finished Goods Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get GBJ item data
        $data['gbjSelect'] = $this->db->order_by('name','ASC')->get_where('stock_finishedgoods', ['status' => 7])->result_array();
        //get roll item data
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        $data['po_id'] = $prodID;

        $data['getRollID'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->row_array();
        if ($data['getRollID'] != null) {
        } else {
            $data['getRollID']['batch'] = 'No roll yet';
        };
        
        //gbj items
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $prodID])->result_array();

        // Get the last material item used in this production order
        $lastMaterial = $this->db->select('date')
                            ->where('transaction_id', $prodID)
                            ->where('status', 3)
                            ->order_by('id', 'DESC')
                            ->limit(1)
                            ->get('stock_material')
                            ->row_array();
        
        $data['last_material_date'] = $lastMaterial ? date('Y-m-d', $lastMaterial['date']) : date('Y-m-d', time());

        // Get the last roll item used in this production order
        $last_record = $this->db->select('name, code, in_stock, pcsperpack, packpersack, date, price, batch')
                       ->where('transaction_id', $prodID)
                       ->order_by('id', 'DESC')
                       ->limit(1)
                       ->get('stock_finishedgoods')
                       ->row_array();

        // Convert timestamp to Y-m-d format for HTML date input
        $data['last_record'] = $last_record;
        $data['last_date'] = $last_record ? date('Y-m-d', $last_record['date']) : date('Y-m-d', time());

        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        $data['IDCheck'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
        //MATERIAL ITEMS HERE
        
        if ($data['IDCheck'] != null) {
            } else {
                $data['IDCheck']['description'] = 1;
                $data['IDCheck']['product_name'] = 1;
                };
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/add_gbj', $data);
        $this->load->view('templates/footer');
    }

    public function receive_purchase_token(){
        $token =  time();
		$receive_purchase = array(
			'token' => $token
		);

		$this->session->set_userdata($receive_purchase);

		$receive_token = $this->session->userdata('token');

		return $token;
	}

    public function add_gbj_item($prodID, $status, $warehouse)
    {
        $data['title'] = 'Finished Goods Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get GBJ item data
        $data['gbjSelect'] = $this->db->order_by('name','ASC')->get_where('stock_finishedgoods', ['status' => 7])->result_array();
        //get roll item data
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        $data['po_id'] = $prodID;

        $data['getRollID'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->row_array();
        if ($data['getRollID'] != null) {
        } else {
            $data['getRollID']['batch'] = 'No roll yet';
        };

        //gbj items
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $prodID])->result_array();

        //MATERIAL ITEMS HERE
        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        $data['IDCheck'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        if ($data['IDCheck'] != null) {
        } else {
            $data['IDCheck']['description'] = 1;
            $data['IDCheck']['product_name'] = 1;
        };

        $this->form_validation->set_rules('gbjSelect', 'finished goods item', 'trim|required');
        $this->form_validation->set_rules('code', 'code', 'trim|required');
        $this->form_validation->set_rules('amount', 'amount', 'trim|required');
        $this->form_validation->set_rules('price_gbj', 'price', 'trim|required');
        $this->form_validation->set_rules('batch', 'batch', 'trim|required');
        $this->form_validation->set_rules('pack_no', 'description', 'trim|required');
        $this->form_validation->set_rules('report_date', 'description', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_gbj', $data);
            $this->load->view('templates/footer');
        } else {
            $item = $this->input->post('gbjSelect');
            $code = $this->input->post('code');
            $amount = $this->input->post('amount');
            $price = $this->input->post('price_gbj');
            $pcsperpack = $this->input->post('pcsperpack');
            $packpersack = $this->input->post('packpersack');
            $batch = $this->input->post('batch');
            $pack_no = $this->input->post('pack_no');
            $date = strtotime($this->input->post('report_date'));
            $transaction_status = 3;

            $gbjSelect = $this->db->get_where('stock_finishedgoods', ['code' => $code, 'status' => 7])->row_array();

            // $price = $gbjSelect['price'];
            $picture = $gbjSelect['picture'];
            $category = $gbjSelect['categories'];
            $satuan = $gbjSelect['unit_satuan'];
            $stock_old = $gbjSelect['in_stock'];

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Process interupted, please check input items!</div>');

            if ($category == 6 or $category == 7){
                $updatedStock = $stock_old + $amount;

                $data = [
                    'name' => $item,
                    'code' => $code,
                    'pcsperpack' => $pcsperpack,
                    'packpersack' => $packpersack,
                    'date' => $date,
                    'price' => $price,
                    'in_stock' => $updatedStock,
                    'incoming' => $amount,
                    'before_convert' => $amount,
                    'outgoing' => 0,
                    'status' => 3,
                    'transaction_status' => 1,
                    'categories' => $category,
                    'warehouse' => 3,
                    'picture' => $picture,
                    'transaction_id' => $prodID,
                    'batch' => $batch,
                    'description' => $pack_no,
                    'unit_satuan' => $satuan
                ];
    
                if($this->db->insert('stock_finishedgoods', $data)){
                    $inserted_id = $this->db->insert_id();
                    $audit_id = $this->audit->log_audit('stock_finishedgoods', $inserted_id, $prodID, 'CREATE', 'Initial stock of ' . $item . ': ' . $stock_old, 'Finished goods item: ' . $item . ' added with amount ' . $amount . ' ' . $satuan . '. Stock updated to: ' . $updatedStock);
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };
                };
                
                $data2 = [
                    'in_stock' => $updatedStock,
                    'date' => $date,
                    'price' => $price
                ];
    
                $this->db->where('status', '7');
                $this->db->where('code', $code);
                $this->db->update('stock_finishedgoods', $data2);
            } else {
                $data = [
                    'name' => $item,
                    'code' => $code,
                    'pcsperpack' => $pcsperpack,
                    'packpersack' => $packpersack,
                    'date' => $date,
                    'price' => $price,
                    'in_stock' => 0,
                    'incoming' => $amount,
                    'before_convert' => $amount,
                    'outgoing' => 0,
                    'status' => 3,
                    'transaction_status' => 1,
                    'categories' => $category,
                    'warehouse' => 3,
                    'picture' => $picture,
                    'transaction_id' => $prodID,
                    'batch' => $batch,
                    'description' => $pack_no,
                    'unit_satuan' => $satuan
                ];
    
                if($this->db->insert('stock_finishedgoods', $data)){
                    $inserted_id = $this->db->insert_id();
                    $audit_id = $this->audit->log_audit('stock_finishedgoods', $inserted_id, $prodID, 'CREATE', 'Initial stock of ' . $item . ': ' . $stock_old, 'Finished goods item: ' . $item . ' added with amount ' . $amount . ' kg');
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };
                };
                
                $data2 = [
                    'date' => $date,
                    'price' => $price
                ];
                
                $this->db->where('status', '7');
                $this->db->where('code', $code);
                $this->db->update('stock_finishedgoods', $data2);
            };

            $production_status_gbj = $this->db->select('transaction_status')->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
            // Check if any row has transaction_status != 4
            $has_non_four = array_filter($production_status_gbj, fn($row) => $row['transaction_status'] < 4);

            if (!empty($has_non_four)) {
                $this->db->where('transaction_id', $prodID)->update('stock_material', [
                    'transaction_status' => 4
                ]);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Finished goods ' . $item . ' with amount ' . $amount . ' kg added!</div>');
            redirect('production/add_gbj/' . $prodID);
        };
    }

    //CUT Input Roll per item
    public function cut_roll()
    {
        $po_id = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $materialStatus = $data['material_edited']['status'];
        
        if($materialStatus == 9){ 
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Material ' . $name . ' with amount ' . $amount . '  is already cut!</div>');
            redirect('production/add_gbj/' . $po_id);
        } else {
            //get selected material stock_akhir or stock akhir from id = 7
            $code = $data['material_edited']['code'];
            $batch = $data['material_edited']['batch'];

            $data['material_selected'] = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();
            $stock_akhir = $data['material_selected']['in_stock'];
            $name = $data['material_selected']['name'];
            $weight = $data['material_selected']['weight'];
            $lip = $data['material_selected']['lipatan'];
            $price = $data['material_selected']['price'];

            $setStatus = 9;
            $this->db->where('id', $id);
            $this->db->set('status', $setStatus);
            $this->db->update('stock_roll');

            //update stock akhir
            $update_stock = $stock_akhir - $amount;
    
            $data2 = [
                'in_stock' => $update_stock
            ];
            
            //insert transaction
            $data = [
                'name' => $name,
                'code' => $code,
                'date' => time(),
                'price' => $price,
                'weight' => $weight,
                'lipatan' => $lip,
                'in_stock' => $update_stock,
                'incoming' => 0,
                'outgoing' => $amount,
                'status' => 9,
                'warehouse' => 2,
                'transaction_id' => $po_id,
                'transaction_desc' => 'Bulk cut',
                'batch' => $batch
            ];
    
            //update stock akhir
            $this->db->where('status', '7');
            $this->db->where('code', $code);
            $this->db->update('stock_roll', $data2);
    
            //insert transaction
            if($this->db->insert('stock_roll', $data)){
                $inserted_id = $this->db->insert_id();
                $audit_id = $this->audit->log_audit('stock_roll', $inserted_id, $po_id, 'CREATE', 'Initial stock of ' . $name . ': ' . $stock_akhir, 'Roll item: ' . $name . ' with amount ' . $amount . ' kg cut. Stock updated to: ' . $update_stock . ' kg.');
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Material ' . $name . ' with amount ' . $amount . '  cut!</div>');
            redirect('production/add_gbj/' . $po_id);
        };
    }

    // public function change_to_cut(){
    //     $id = $this->input->post('id_check');

    //     //insert transaction
    //     $data['check_status'] = $this->db->get_where('stock_roll', ['id' => $id])->row_array();

    //     if($data['check_status']['status'] == 9) {
    //         $this->db->where('id', $id);    
    //         $this->db->set('status', 3);    
    //         if($this->db->update('stock_roll')){
    //             $audit_id = $this->audit->log_audit('stock_roll', $id, '-', 'UPDATE', '-', 'Production Order status updated to Cut');
    //             if (!$audit_id) {
    //                 log_message('error', 'Audit log failed');
    //             };
    //         };
    //     } else {
    //         $this->db->where('id', $id);    
    //         $this->db->set('status', 9);    
    //         $this->db->update('stock_roll');
    //     }
    // }
    public function change_to_cut(){
        $id = $this->input->post('id_check');

        // Get the row being undone to retrieve its incoming amount and code
        $row = $this->db->get_where('stock_roll', ['id' => $id])->row_array();
        $code = $row['code'];
        $amount = $row['incoming'];
        $transID = $row['transaction_id'];

        // Find the bulk cut row via transaction_id and transaction_desc pattern
        $bulkCutId = $row['bulk_cut_id'];

        // Fetch and update the bulk cut row
        $bulkRow = $this->db->get_where('stock_roll', ['id' => $bulkCutId])->row_array();
        $updated_outgoing = $bulkRow['outgoing'] - $amount;

        $this->db->where('id', $bulkCutId);
        $this->db->set('outgoing', $updated_outgoing);
        $this->db->update('stock_roll');

        // Add the amount back to in_stock of the current stock row (status 7)
        $current = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();
        $restored_stock = $current['in_stock'] + $amount;

        $this->db->where('code', $code);
        $this->db->where('status', 7);
        $this->db->set('in_stock', $restored_stock);
        $this->db->update('stock_roll');

        // Revert status 9 → 3
        $this->db->where('id', $id);    
        $this->db->set('status', 3);    
        if($this->db->update('stock_roll')){
            $audit_id = $this->audit->log_audit(
                'stock_roll', 
                $id, 
                '-', 
                'UPDATE', 
                'Stock before undo: ' . $current['in_stock'], 
                'Undo cut: ' . $row['name'] . ' amount ' . $amount . ' kg added back. Stock restored to: ' . $restored_stock . ' kg.'
            );
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };
    }

    public function cut_roll_bulk($po_id){
        $this->form_validation->set_rules('roll_item', 'roll item', 'trim|required');
        $this->form_validation->set_rules('cut_amount', 'cut amount', 'trim|required');
        $this->form_validation->set_rules('trans_id', 'trans_id', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            redirect('production/add_gbj/' . $po_id);
        } else {
            $code = $this->input->post('roll_item');
            $amount = $this->input->post('cut_amount');
            $transID = $this->input->post('trans_id');
            $batch = $this->input->post('bulk_batch');
            $checkedIds = json_decode($this->input->post('checked_ids'), true);
            $timestamp = time();
    
            $data['material_selected'] = $this->db->get_where('stock_roll', ['code' => $code, 'status' => 7])->row_array();
            // $data['double_data'] = $this->db->get_where('stock_roll', ['transaction_id' => $transID, 'outgoing' => $amount, 'date' => $timestamp])->row_array();
            // $doubleData = $this->db->get_where('stock_roll', [ 'transaction_id' => $transID, 'code' => $code, 'outgoing' => $amount, 'status' => 9])->row_array();
            $checkedIds = json_decode($this->input->post('checked_ids'), true);

            // Check if ANY of the checked IDs already have status 9
            $this->db->where_in('id', $checkedIds);
            $this->db->where('status', 9);
            $doubleData = $this->db->get('stock_roll')->result_array();
            
            if(!$doubleData){
                $stock_akhir = $data['material_selected']['in_stock'];
                $name = $data['material_selected']['name'];
                $weight = $data['material_selected']['weight'];
                $lip = $data['material_selected']['lipatan'];
                $price = $data['material_selected']['price'];
            
                $update_stock = $stock_akhir - $amount;
        
                $updateStock = [
                    'in_stock' => $update_stock
                ];
        
                $insertData = [
                    'name' => $name,
                    'code' => $code,
                    'date' => $timestamp,
                    'price' => $price,
                    'weight' => $weight,
                    'lipatan' => $lip,
                    'in_stock' => $update_stock,
                    'incoming' => 0,
                    'outgoing' => $amount,
                    'status' => 9,
                    'warehouse' => 2,
                    'transaction_id' => $transID,
                    'transaction_desc' => 'Bulk cut',
                    'batch' => $batch
                ];
        
                //update stock akhir
                $this->db->where('status', '7');
                $this->db->where('code', $code);
                $this->db->update('stock_roll', $updateStock);
                
                
                //insert transaction
                if($this->db->insert('stock_roll', $insertData)){
                    $inserted_id = $this->db->insert_id();
                    $audit_id = $this->audit->log_audit('stock_roll', $inserted_id, $po_id, 'CREATE', 'Initial stock of ' . $name . ': ' . $stock_akhir, 'Roll item: ' . $name . ' with amount ' . $amount . ' kg bulk cut! Stock updated to: ' . $update_stock . ' kg.');
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };

                    foreach($checkedIds as $itemId){
                        $this->db->where('id', $itemId);
                        $this->db->update('stock_roll', [
                            'status' => 9,
                            'bulk_cut_id' => $inserted_id  // ← new column, desc untouched
                        ]);
                    }
                    // foreach($checkedIds as $itemId){
                    //     // Get current transaction_desc
                    //     $itemRow = $this->db->get_where('stock_roll', ['id' => $itemId])->row_array();
                    //     $currentDesc = $itemRow['transaction_desc'];

                    //     // Strip any previously appended bulk cut id (everything after last ' - [number]')
                    //     // e.g. '1 - 123' -> '1'
                    //     if(preg_match('/^(.*?) - \d+$/', $currentDesc, $matches)){
                    //         $cleanDesc = $matches[1];
                    //     } else {
                    //         $cleanDesc = $currentDesc;
                    //     }

                    //     $this->db->where('id', $itemId);
                    //     $this->db->update('stock_roll', [
                    //         'status' => 9,
                    //         'transaction_desc' => $cleanDesc . ' - ' . $inserted_id
                    //     ]);
                    // }
                };
    
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bulk cut ' . $name . ' successful with total amount ' . $amount . ' kg!</div>');
                redirect('production/add_gbj/' . $po_id);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Data integrity maintained!</div>');
                redirect('production/add_gbj/' . $po_id);
            };
        };
    }

    public function convert_to_pack($prodID){
        $data['title'] = 'Finished Goods Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get GBJ item data
        $data['gbjSelect'] = $this->db->order_by('name','ASC')->get_where('stock_finishedgoods', ['status' => 7])->result_array();
        //get roll item data
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

        $data['po_id'] = $prodID;

        $data['getRollID'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->row_array();
        if ($data['getRollID'] != null) {
        } else {
            $data['getRollID']['batch'] = 'No roll yet';
        };

        //gbj items check if transaction status is = 2, meaning already converted, to prevent double input
        $id = $this->input->post('id');
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();
        $check_GBJ_stat = $data['gbjItems']['transaction_status'];

        if($check_GBJ_stat != 2){
            //get material data
            $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
            $data['IDCheck'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();

            if ($data['IDCheck'] != null) {
            } else {
                $data['IDCheck']['description'] = 1;
                $data['IDCheck']['product_name'] = 1;
            };

            $this->form_validation->set_rules('pack_amount', 'pack amount', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops pack amount is missing!</div>');
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('production/add_gbj', $data);
                $this->load->view('templates/footer');
            } else {
                $name = $this->input->post('name');
                $code = $this->input->post('code');
                $weight = $this->input->post('kg_amount');
                $priceperkg = $this->input->post('kg_price');
                $pack = $this->input->post('pack_amount');
                $date = time();
        
                $gbjSelect = $this->db->get_where('stock_finishedgoods', ['code' => $code, 'status' => 7])->row_array();

                $stock_old = $gbjSelect['in_stock'];

                $totalPrice = $weight * $priceperkg;
                $priceperPack = $totalPrice / $pack;
                $update_stock = $stock_old + $pack;

                $data = [
                    'in_stock' => $update_stock,
                    'date' => $date,
                    'price' => $priceperPack
                ];
                
                $this->db->where('status', '7');
                $this->db->where('code', $code);
                $this->db->update('stock_finishedgoods', $data);
                
                $data1 = [
                    'incoming' => $pack,
                    'in_stock' => $update_stock ,
                    'transaction_status' => 2,
                    'price' => $priceperPack
                ];

                $this->db->where('id', $id);
                if($this->db->update('stock_finishedgoods', $data1)){
                    $audit_id = $this->audit->log_audit('stock_finishedgoods', $id, $prodID, 'UPDATE', 'FG item: ' . $name . ' with initial stock ' . $stock_old, 'FG item: ' . $name . ' with amount ' . $weight . ' kg converted to: ' . $pack . ' pack. Stock updated to: ' . $update_stock);
                    if (!$audit_id) {
                        log_message('error', 'Audit log failed');
                    };
                };
        
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Amount converted!</div>');
                redirect('production/add_gbj/' . $prodID);
            };
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Data integrity maintained!</div>');
            redirect('production/add_gbj/' . $prodID);
        };
    }

    //update production order roll amount
    public function update_gbj_amount()
    {
        $id = $this->input->post('id');
        $prodID = $this->input->post('prodID');
        $amount = $this->input->post('qtyID');
        $cat = $this->input->post('cat');
        $status = $this->input->post('status');

        $date = time();

        $data['material_edited'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];
        $name = $data['material_edited']['name'];
        $adjust_old = $data['material_edited']['incoming'];
        $last_price = $data['material_edited']['price'];
        $prodID = $data['material_edited']['transaction_id'];

        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_finishedgoods', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];
        $unit_satuan = $data['material_selected']['unit_satuan'];
        
        if ($cat == 6 or $cat == 7 or $unit_satuan == 'kg' or $status == 2){
            //if item has been converted into packs, or bulk products, or weighted, update transaksi dan stock akhir
            $update_stock = ($stock_akhir - $adjust_old) + $amount;
            $update_price = ($last_price * $adjust_old)/$amount;
            
            $data2 = [
                'in_stock' => $update_stock,
                // 'date' => $date
            ];
            
            //update transaksi
            $this->db->where('id', $id);
            $this->db->set('incoming', $amount);
            $this->db->set('in_stock', $update_stock);
            if ($cat == 6 or $cat == 7 or $unit_satuan == 'kg') {
                $this->db->set('before_convert', $amount);
            } else {
                $this->db->set('price', $update_price);
            };
            if($this->db->update('stock_finishedgoods')){
                $audit_id = $this->audit->log_audit('stock_finishedgoods', $id, $prodID, 'UPDATE', 'FG item: ' . $name . ' amount: ' . $adjust_old . ' with initial stock ' . $stock_akhir, 'FG item: ' . $name . '  edited to: ' . $amount . ' pack. Stock updated to: ' . $update_stock);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };
            //update stock akhir
            $this->db->where('status', '7');
            $this->db->where('code', $materialID);
            $this->db->update('stock_finishedgoods', $data2);
        } else if($cat != 6 or $cat != 7 or $unit_satuan != 'kg' and $status != 2) {           
            //item that is not converted into packs, update transaksi only
            $this->db->where('id', $id);
            $this->db->set('incoming', $amount);
            $this->db->set('before_convert', $amount);
            if($this->db->update('stock_finishedgoods')){
                $audit_id = $this->audit->log_audit('stock_finishedgoods', $id, $prodID, 'UPDATE', 'FG item: ' . $name . ' amount: ' . $adjust_old . ' with initial stock ' . $stock_akhir, 'FG item: ' . $name . '  edited to: ' . $amount . ' pack. Stock not updated because changes made before converting to packs.');
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Amount updated!</div>');
        // redirect('production/add_gbj/' . $prodID);
    }

    public function print_ticket_gbj(){
        $data['title'] = 'Print Finished Goods Ticket';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get data from form
        $data['prod_id'] = $this->input->post('po_id');
        $data['batch'] = $this->input->post('batch');
        $data['item'] = $this->input->post('name');
        $data['net_weight'] = $this->input->post('weight');
        $data['amount'] = $this->input->post('amount');
        $data['desc'] = $this->input->post('desc');

        $type = $this->input->get('type');
        if ($type == 1){
            $data['roll_back'] = 'add_gbj';
        } else if ($type == 2){
            $data['roll_back'] = 'gbj_details';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/print_ticket_gbj', $data);
        $this->load->view('templates/footer');
        // echo $prod_id . ' ' . $batch . ' ' . $item . ' ' . $net_weight;
    }

    public function add_item_prod_after_gbj($id, $status)
    {
        $data['title'] = 'Finished Goods Input';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get GBJ item data
        $data['gbjSelect'] = $this->db->order_by('name','ASC')->get_where('stock_finishedgoods', ['status' => 7])->result_array();
        //get roll item data
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $id])->result_array();
        //get inventory warehouse data
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();

        $data['po_id'] = $id;

        $data['getRollID'] = $this->db->get_where('stock_roll', ['transaction_id' => $id])->row_array();
        if ($data['getRollID'] != null) {
        } else {
            $data['getRollID']['batch'] = 'No roll yet';
        };

        //gbj items
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $id])->result_array();

        //MATERIAL ITEMS HERE
        //MATERIAL ITEMS HERE
        //get material data
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();
        $data['IDCheck'] = $this->db->get_where('stock_material', ['transaction_id' => $id])->row_array();

        if ($data['IDCheck'] != null) {
        } else {
            $data['IDCheck']['description'] = 1;
            $data['IDCheck']['product_name'] = 1;
        };

        $this->form_validation->set_rules('materialSelect', 'material', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('description', 'description', 'required|trim');
        $this->form_validation->set_rules('campuran', 'mix amount', 'required|trim|numeric');
        $this->form_validation->set_rules('product_name', 'product name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('production/add_gbj', $data);
            $this->load->view('templates/footer');
        } else {
            //get data to be inserted to inventory stock_material warehouse
            $po_id = $id;
            $po_status = 1;
            $materialID = $this->input->post('materialSelect');
            $price = $this->input->post('price');
            $product_name = $this->input->post('product_name');
            $date = strtotime($this->input->post('report_date'));
            $amount = $this->input->post('amount');
            $description = $this->input->post('description');
            $campuran = $this->input->post('campuran');

            $material_selected = $this->db->get_where('stock_material', ['id' => $materialID, 'status' => 7])->row_array();
            $materialName = $material_selected["name"];
            $materialCode = $material_selected["code"];
            $materialCat = $material_selected["categories"];
            $warehouse = $material_selected["warehouse"];
            $supplier = $material_selected["supplier"];
            $unit = $material_selected["unit_satuan"];
            $stock_old = $material_selected["in_stock"];
            $updated_stock = $stock_old - $amount;

            $data = [
                'transaction_id' => $po_id,
                'code' => $materialCode,
                'name' => $materialName,
                'categories' => $materialCat,
                'date' => $date,
                'price' => $price,
                'outgoing' => $amount,
                'in_stock' => $updated_stock,
                'unit_satuan' => $unit,
                'status' => $status,
                'warehouse' => $warehouse,
                'supplier' => $supplier,
                'product_name' => $product_name,
                'transaction_status' => $po_status,
                'description' => $description,
                'item_desc' => $campuran
            ];

            if($this->db->insert('stock_material', $data)){
                $inserted_id = $this->db->insert_id();
                $audit_id = $this->audit->log_audit('stock_material', $inserted_id, $po_id, 'CREATE', 'Initial stock of ' . $materialName . ': '  . $stock_old . ' kg', 'Production order material added: ' . $materialName . ' with amount ' . $amount. ' ' . $unit . '. Updated stock: ' . $updated_stock . ' ' . $unit);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };

            $data2 = [
                'in_stock' => $stock_old - $amount,
                'date' => $date,
                'price' => $price,
            ];

            $this->db->where('status', '7');
            $this->db->where('code', $materialCode);
            $this->db->update('stock_material', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Additional material added!</div>');
            redirect('production/add_gbj/' . $po_id);
        }
    }

    //update production order GBJ descriptipn
    public function update_gbj_details($type)
    {
        $id = $this->input->post('id');
        $data['material_edited'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();
        $materialID = $data['material_edited']['code'];
        $po_id = $data['material_edited']['transaction_id'];

        $old_item = null;
        $updated_item = null;
        
        $date = time();
        if ($type == 1) { //description
            $old_item = $data['material_edited']['description'];
            $desc = $this->input->post('descGBJ');
            $updated_item = $desc;
        
            $data = [
            'description' => $desc,
            // 'date' => $date
            ];
        } else if ($type == 2){ //price
            $old_item = $data['material_edited']['price'];
            $price = $this->input->post('priceGBJ');
            $updated_item = $price;

            $data = [
                'price' => $price,
                // 'date' => $date
            ];
            //delete this portion if edit price don't affect stock akhir price  
            $this->db->where('status', '7');
            $this->db->where('code', $materialID);
            $this->db->update('stock_finishedgoods', $data);
        } else if ($type == 3){ //batch description
            $old_item = $data['material_edited']['batch'];
            $batchDesc = $this->input->post('batchGBJ');
            $updated_item = $batchDesc;

            $data = [
                'batch' => $batchDesc,
                // 'date' => $date
            ];
        } 

        //update transaksi
        $this->db->where('id', $id);
        if($this->db->update('stock_finishedgoods', $data)){
            $audit_id = $this->audit->log_audit('stock_finishedgoods', $id, $po_id, 'UPDATE', $old_item, 'Updated to: ' . $updated_item);
            if (!$audit_id) {
                log_message('error', 'Audit log failed');
            };
        };

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Details updated!</div>');
    }
    
    //delete individual gbj input
    public function delete_gbj_input(){
        $prodID = $this->input->post('delete_po_id');
        $id = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');
        $amount = $this->input->post('delete_amount');
        $status = $this->input->post('trans_status');
        $cat = $this->input->post('item_cat');
        
        $date = time();
        
        $data['material_deleted'] = $this->db->get_where('stock_finishedgoods', ['id' => $id])->row_array();
        $materialID = $data['material_deleted']['code'];
        
        //get selected material stock_akhir or stock akhir from id = 7
        $data['material_selected'] = $this->db->get_where('stock_finishedgoods', ['code' => $materialID, 'status' => 7])->row_array();
        $stock_akhir = $data['material_selected']['in_stock'];
        
        if ($cat == 6 or $cat == 7 or $status == 2){
            //if converted into packs, or bulk products, or weighted, update transaction and stock akhir
            $update_stock = $stock_akhir - $amount;
            
            $data2 = [
                'in_stock' => $update_stock,
                'date' => $date
            ];
            
            //update transaction
            $this->db->where('id', $id);
            if($this->db->delete('stock_finishedgoods')){
                $audit_id = $this->audit->log_audit('stock_finishedgoods', $id, $prodID, 'DELETE', 'Item ' . $name . ' with amount ' . $amount . '. Initial stock: ' . $stock_akhir, 'Delete transaction. Updated stock: ' . $update_stock);
                if (!$audit_id) {
                    log_message('error', 'Audit log failed');
                };
            };
            //update stock akhir
            $this->db->where('status', '7');
            $this->db->where('code', $materialID);
            $this->db->update('stock_finishedgoods', $data2);
        } else if($cat != 6 or $cat != 7 and $status != 2) {           
            //if not converted into packs, update transaction only
            $this->db->where('id', $id);
            $this->db->delete('stock_finishedgoods');
        }
        
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Items deleted!</div>');
        redirect('production/add_gbj/' . $prodID);
    }

    public function pdf_prodReport($prodID)
    {
        $data['title'] = 'Production Report';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //material items
        $data['inventory_selected'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->result_array();
        $data['getID'] = $this->db->get_where('stock_material', ['transaction_id' => $prodID])->row_array();
        $data['po_id'] = $prodID;
        
        //roll items
        $data['rollType'] = $this->db->get_where('stock_roll', ['transaction_id' => $prodID])->result_array();

        //gbj items
        $data['gbjItems'] = $this->db->get_where('stock_finishedgoods', ['transaction_id' => $prodID])->result_array();
        
        $this->load->view('production/pdf_report', $data);
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
        $data['material'] = $this->db->order_by('categories','ASC')->get_where('stock_material', ['status' => 7])->result_array();

        // $data['material_selected'] = $this->db->get('cogs_calculator')->result_array();
        $user_id = $data['user']['id'];
        $this->load->model('Calculator_model', 'calculator');
        $data['material_selected'] = $this->calculator->getMaterialName($user_id);

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
                'user_id' => $user_id,
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
        //get material database
        $data['materialStock'] = $this->db->order_by('categories','ASC')->get('stock_material')->result_array();

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

    /** Gramatur function */
    /** Gramatur calculates gramature and/or thickness of a certain product */
    public function gramatur(){
        $data['title'] = 'Gramatur Calculator';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/gramatur', $data);
        $this->load->view('templates/footer');
    }

    // USAGE
    public function usage()
    {
        $data['title'] = 'Production Summary';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        
        // Sanitize inputs
        $start_date = (int) $this->input->get('start_date');
        $end_date   = (int) $this->input->get('end_date');
        $periode_id = $this->input->get('name'); // optional, derived below

        // If no valid dates passed, derive from current time
        if (!$start_date || !$end_date) {
            $periode    = getPeriodeByDate(time());
            $start_date = $periode['start_date'];
            $end_date   = $periode['end_date'];
            $periode_id = $periode['id'];
        }

        if ($start_date > $end_date) {
            show_error('Invalid date range.', 400);
        }

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['periode_id'] = $periode_id;

        $status = 3; //produciton order data only
        //get materials usage data
        $this->load->model('Warehouse_model', 'warehouse_id');
        $data['materialUsage'] = $this->warehouse_id->MaterialUsagePerItem($status, $start_date, $end_date);
        $data['rollProduced'] = $this->warehouse_id->rollProduced($start_date, $end_date);
        $data['fgProduced'] = $this->warehouse_id->fgProduced($status, $start_date, $end_date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('production/material_usage', $data);
        $this->load->view('templates/footer');
    }
}
