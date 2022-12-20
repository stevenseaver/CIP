<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
    public function getTerms()
    {
        $query = "SELECT `supplier`.*,`payment_terms`.`terms`
                    FROM `supplier` JOIN `payment_terms`
                      ON `payment_terms`.`id` = `supplier`.`terms_id`
            ";
        return $this->db->query($query)->result_array();
    }
}
