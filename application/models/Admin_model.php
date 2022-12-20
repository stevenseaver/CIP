<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getUserRole()
    {
        $query = "SELECT `user`.*,`user_role`.`role`
                    FROM `user` JOIN `user_role`
                      ON `user`.`role_id` = `user_role`.`id`
            ";
        return $this->db->query($query)->result_array();
    }

    public function getEmployeeRole()
    {
        $query = "SELECT `user`.*,`user_role`.`role`
                    FROM `user` JOIN `user_role`
                      ON `user`.`role_id` = `user_role`.`id`
                   WHERE `role_id` != 3
            ";
        return $this->db->query($query)->result_array();
    }
}
