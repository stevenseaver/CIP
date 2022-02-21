<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_model extends CI_Model
{
    public function getTerms()
    {
        $query = "SELECT `customer`.*,`payment_terms`.`terms`
                    FROM `customer` JOIN `payment_terms`
                      ON `payment_terms`.`id` = `customer`.`terms`
            ";
        return $this->db->query($query)->result_array();
    }
}
