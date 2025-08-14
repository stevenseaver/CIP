<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave_model extends CI_Model
{
    public function getLeaveType()
    {
        $query = "SELECT `leave_list`.*,`leave_type`.`type`
                    FROM `leave_list` JOIN `leave_type`
                      ON `leave_list`.`type` = `leave_type`.`id`
            ";
        return $this->db->query($query)->result_array();
    }
}
