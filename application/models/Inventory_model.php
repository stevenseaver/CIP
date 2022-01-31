<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
    public function getRoomName()
    {
        $query = "SELECT `inventory_asset`.*,`rooms`.`room_name`
                    FROM `inventory_asset` JOIN `rooms`
                      ON `inventory_asset`.`position` = `rooms`.`id`
            ";
        return $this->db->query($query)->result_array();
    }
}
