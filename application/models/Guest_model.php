<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guest_model extends CI_Model
{
    private $table = 'guests';
    
    public function add_guest($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
