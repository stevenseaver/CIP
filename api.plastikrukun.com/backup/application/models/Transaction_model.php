<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    public function getMaterialStatusTransaction()
    {
        $query = "SELECT `stock_material`.*,`transaction_status`.`status`
                    FROM `stock_material` JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status`
            ";
        return $this->db->query($query)->result_array();
    }
}
