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
    
    public function getSalesOrderData($status)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `status` = $status
                   ORDER BY `ref`
        ";
        return $this->db->query($query)->result_array();
    }
    
    public function getSaleswithTimeFrameEqualTo($status, $start_date, $end_date)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `status` = $status AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `ref`
        ";
        return $this->db->query($query)->result_array();
    }
    
    public function getSaleswithTimeFrame($not_status, $start_date, $end_date)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `status` != $not_status AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `ref`
        ";
        return $this->db->query($query)->result_array();
    }
    
    public function getSaleswithTimeFrameDualParameters($not_status1, $not_status2, $start_date, $end_date)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `status` != $not_status1 AND `status` != $not_status2 AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `ref`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getRow($inv)
    {
        $query = "SELECT `user`.*,`cart`.*
                    FROM `user` JOIN `cart`
                      ON `cart`.`customer_id` = `user`.`id`
                   WHERE `ref` = '$inv'
                   
        ";
        return $this->db->query($query)->row_array();
    }
}
