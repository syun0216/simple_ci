<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/3/23
 * Time: 下午5:17
 */

class MY_Model extends CI_Model {
    public $table = 'dumb';
    public $select = "*";
    public $order_by = "";

    //新增
    public function add($attr, $table = NULL) {
        if($table) {
            $this->db->insert($table, $attr);
        }else{
            $this->db->insert($this->table, $attr);
        }
        return $this->db->insert_id();
    }
    //查询
    //删除
    //修改
}