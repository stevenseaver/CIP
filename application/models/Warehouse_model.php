<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
  public function getMaterialWarehouseID()
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                   WHERE `status` = 7
                   ORDER BY `name`
            ";
    return $this->db->query($query)->result_array();
  }

  public function getMaterial()
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
            ";
    return $this->db->query($query)->result_array();
  }

  public function purchaseOrderMaterialWH($trans_id, $status)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                   WHERE `transaction_status` = $trans_id  AND `status` = $status 
                ORDER BY `transaction_id`
            ";
    return $this->db->query($query)->result_array();
  }

  public function purchaseOrderwithTimeFrame($trans_id, $status, $start_date, $end_date)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                   WHERE `transaction_status` = $trans_id  AND `status` = $status AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `transaction_id`
            ";
    return $this->db->query($query)->result_array();
  }
  
  public function purchasePerItem($trans_id, $status, $start_date, $end_date)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                   WHERE `transaction_status` = $trans_id  AND `status` = $status AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `name`
            ";
    return $this->db->query($query)->result_array();
  }

  public function usagePerItem($status, $start_date, $end_date)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                   WHERE `status` = $status AND `date` >= $start_date AND `date` <= $end_date
                ORDER BY `name`
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
                   WHERE `status` = 7
                ORDER BY `name`
            ";
    return $this->db->query($query)->result_array();
  }

  public function getProduction()
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
    $query = "SELECT `stock_finishedgoods`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`product_category`.`title`
                    FROM `stock_finishedgoods` 
                    JOIN `warehouse`
                      ON `stock_finishedgoods`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_finishedgoods`.`status` = `transaction_status`.`status_id`
                    JOIN `product_category`
                      ON `stock_finishedgoods`.`categories` = `product_category`.`id`
                   WHERE `status` = 7
                   ORDER BY `name`
            ";
    return $this->db->query($query)->result_array();
  }

  public function getGBJ()
  {
    $query = "SELECT `stock_finishedgoods`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`product_category`.`title`
                    FROM `stock_finishedgoods` 
                    JOIN `warehouse`
                      ON `stock_finishedgoods`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_finishedgoods`.`status` = `transaction_status`.`status_id`
                    JOIN `product_category`
                      ON `stock_finishedgoods`.`categories` = `product_category`.`id`
            ";
    return $this->db->query($query)->result_array();
  }

  public function prodOrder($trans_id, $status)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
            WHERE `transaction_status` = $trans_id  AND `status` = $status 
            ORDER BY `date`
            ";
    return $this->db->query($query)->result_array();
  }

  public function prodOrderwithTimeFrame($status, $start_date, $end_date)
  {
    $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
                    FROM `stock_material` JOIN `warehouse`
                      ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
                    JOIN `transaction_status`
                      ON `stock_material`.`status` = `transaction_status`.`status_id`
                      JOIN `material_category`
                      ON `stock_material`.`categories` = `material_category`.`id`
                      JOIN `supplier`
                      ON `stock_material`.`supplier` = `supplier`.`id`
                    WHERE `status` = $status AND `date` >= $start_date AND `date` <= $end_date
                  ORDER BY `transaction_id` ASC, `date` ASC
            ";
    return $this->db->query($query)->result_array();
  }
  
  // public function prodOrderwithTimeFrame($trans_id, $status, $start_date, $end_date)
  // {
  //   $query = "SELECT `stock_material`.*,`warehouse`.`warehouse_name`,`transaction_status`.`status_name`,`material_category`.`categories_name`,`supplier`.`supplier_name`
  //                   FROM `stock_material` JOIN `warehouse`
  //                     ON `stock_material`.`warehouse` = `warehouse`.`warehouse_id`
  //                   JOIN `transaction_status`
  //                     ON `stock_material`.`status` = `transaction_status`.`status_id`
  //                     JOIN `material_category`
  //                     ON `stock_material`.`categories` = `material_category`.`id`
  //                     JOIN `supplier`
  //                     ON `stock_material`.`supplier` = `supplier`.`id`
  //           WHERE `transaction_status` = $trans_id  AND `status` = $status AND `date` >= $start_date AND `date` <= $end_date
  //           ORDER BY `transaction_id` ASC, `date` ASC
  //           ";
  //   return $this->db->query($query)->result_array();
  // }
}
