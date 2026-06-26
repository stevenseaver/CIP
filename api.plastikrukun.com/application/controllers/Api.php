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
        $this->db->select('unit_satuan');
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
                    'final_stock' => (float)$result->in_stock . ' ' . $result->unit_satuan
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Item not found.']));
        }
    }

    public function verify_roll()
    {
        // Rate limit using session (no cache driver needed)
        $now     = time();
        $window  = 60; // seconds
        $max     = 30; // max requests per window

        $hits      = $this->session->userdata('rl_hits') ?: 0;
        $window_start = $this->session->userdata('rl_start') ?: $now;

        // Reset window if expired
        if ($now - $window_start > $window) {
            $hits         = 0;
            $window_start = $now;
        }

        $hits++;
        $this->session->set_userdata('rl_hits', $hits);
        $this->session->set_userdata('rl_start', $window_start);

        if ($hits > $max) {
            $data = ['roll' => null, 'error' => '429TMR'];
            $this->load->view('verify_roll', $data);
            // return;
        }

        //Validate input
        $id = (int) $this->input->get('id');
        $po = trim($this->input->get('po', TRUE));
        // $data = ['roll' => null, 'error' => null];

        if (!$id || !$po) {
            $data['error'] = 'missing';
        } else {
            $roll = $this->db
                ->select('id, transaction_id, batch, name, code, weight, lipatan, incoming, transaction_desc, date, status')
                ->get_where('stock_roll', [
                    'id'             => $id,
                    'transaction_id' => $po
                ])->row_array();

            if ($roll) {
                $data['roll'] = $roll;
            } else {
                $data['error'] = 'not_found';
            }
        }

        $this->load->view('verify_roll', $data);
    }

    public function ping()
    {
        echo 'pong';
    }
}
