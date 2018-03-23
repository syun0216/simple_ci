<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    public $table = 'user';

    public function getUser() {
//        $res = $this->db->simple_query('select * from user');
        $res = $this->db->select('*')->get($this->table)->result_array();
        return $res;
    }
}