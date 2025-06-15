<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // API: Get final stock by item name
    public function get_final_stock() {
        // Get 'name' from GET request
        $name = $this->input->get('name', TRUE);

        if (!$name) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Parameter "name" is required.']));
            return;
        }

        // Query the stock
        $this->db->select_sum('in_stock');
        $this->db->from('stock_finishedgoods');
        $this->db->like('LOWER(name)', strtolower($name));
        $this->db->where('status', 7);
        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'item' => $name,
                    'final_stock' => (float)$result->in_stock
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Item not found.']));
        }
    }
}
