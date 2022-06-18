<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
  public function getMaterialWarehouseID()
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
            ";
    return $this->db->query($query)->result_array();
  }

  public function getProductionWarehouseID()
  {
    $query = "SELECT `stock_roll`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`
                    FROM `stock_roll` JOIN `warehouse`
                      ON `stock_roll`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_roll`.`status` = `transaction_status`.`status_id`
            ";
    return $this->db->query($query)->result_array();
  }

  public function getGBJWarehouseID()
  {
    $query = "SELECT `stock_finishedgoods`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`product_menu`.`title`
                    FROM `stock_finishedgoods` 
                    JOIN `warehouse`
                      ON `stock_finishedgoods`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_finishedgoods`.`status` = `transaction_status`.`status_id`
                    JOIN `product_menu`
                      ON `stock_finishedgoods`.`categories` = `product_menu`.`id`
            ";
    return $this->db->query($query)->result_array();
  }
}
