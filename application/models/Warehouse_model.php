<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
    public function getMaterialWarehouseID()
    {
        $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
            ";
        return $this->db->query($query)->result_array();
    }

    public function getProductionWarehouseID()
    {
        $query = "SELECT `stock_roll`.*,`warehouse`.`warehouse_name`
                    FROM `stock_roll` JOIN `warehouse`
                      ON `stock_roll`.`warehouse` = `warehouse`.`warehouse_id`
            ";
        return $this->db->query($query)->result_array();
    }

    public function getGBJWarehouseID()
    {
        $query = "SELECT `stock_finishedgoods`.*,`warehouse`.`warehouse_name`
                    FROM `stock_finishedgoods` JOIN `warehouse`
                      ON `stock_finishedgoods`.`warehouse` = `warehouse`.`warehouse_id`
            ";
        return $this->db->query($query)->result_array();
    }
}