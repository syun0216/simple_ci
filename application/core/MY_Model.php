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
    public function fetch($where=array(), $table=NULL, $options=array())
    {
        if($table){
            $table_name = $table;
        } else {
            $table_name = $this->table;
        }

        foreach($where as $k=>$w){
            $this->db->where($k, $w);
        }

        foreach($options as $k=>$v){
            switch ($k){
                case 'select':
                    $this->db->select($v);
                    break;
                case 'order_by':
                    $this->db->order_by($v);
                    break;
                default:
                    break;
            }
        }

        $res = $this->db->from($table_name)
            ->get()->result_array();

        return $res;
    }
    //删除
    public function delete($where, $table = NULL){
        $table = $table?$table:$this->table;
        $this->db->delete($table, $where);
    }
    //修改
    public function edit($attribute, $where, $table = NULL){
        $table = $table?$table:$this->table;
        $this->db->update($table, $attribute, $where);
        $res = $this-> fetch($where);
        $hasChange = true;
        foreach ($attribute as $k => $v) {
            if($v !== $res[0][$k]) {
                $hasChange = false;
                break;
            }
        }
        return $hasChange;
    }
}