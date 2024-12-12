<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog_model extends CI_Model
{
  public function getBlogStatus()
  {
    $query = "SELECT `blogpost`.*,`blog_type`.`type_name`,`user`.`name`
                    FROM `blogpost` JOIN `blog_type`
                      ON `blogpost`.`parent_id` = `blog_type`.`id`
                    JOIN `user`
                      ON `blogpost`.`author_id` = `user`.`id`
            ";
    return $this->db->query($query)->result_array();
  }
}
