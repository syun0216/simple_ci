<?php
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/4/7
 * Time: 下午4:36
 */

class Company_news_model extends MY_Model
{
    public $table = 'companynews';

    /**
     * @param array $where
     * @param null $table
     * @param array $options
     * @return mixed
     */
    public function fetch($where=array(), $table=NULL, $options=array()) {
        $options['order_by'] = 'id DESC';
        return parent::fetch($where, $table, $options);
    }

}