<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_model extends CI_Model
{
    public function getTerms()
    {
        $query = "SELECT `customer`.*,`payment_terms`.`terms`
                    FROM `customer` JOIN `payment_terms`
                      ON `payment_terms`.`id` = `customer`.`terms_id`
            ";
        return $this->db->query($query)->result_array();
    }

    public function getCustomer()
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getInfo($not_status)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `status` != $not_status
        ";
        return $this->db->query($query)->result_array();
    }
}
