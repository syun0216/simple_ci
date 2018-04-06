<?php
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/4/6
 * Time: 下午7:51
 */

class Navigation_model extends MY_Model
{
    public $table = 'navigation';

    public function fetch($where=array(), $table=NULL, $options=array()) {
        $option['order_by'] = 'sort DESC';
        return parent::fetch($where, $table, $options);
    }
}