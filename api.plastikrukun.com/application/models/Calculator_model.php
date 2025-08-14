<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calculator_model extends CI_Model
{
    public function getMaterialName($id)
    {
        $query = "SELECT `stock_material`.*,`cogs_calculator`.*
                    FROM `stock_material` JOIN `cogs_calculator`
                      ON `stock_material`.`id` = `cogs_calculator`.`material_id`
                   WHERE `user_id` = $id
            ";
        return $this->db->query($query)->result_array();
    }
}
