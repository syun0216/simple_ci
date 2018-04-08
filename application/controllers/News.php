<?php
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/4/3
 * Time: 上午11:13
 */

class News extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }

    /**
     * @params int page
     * @params int limit
     * @return array
     */
    public function get_news() {
        $rules = $this->format_rules('page,limit');
        if($this->check_parameters($rules,'get')) {
            $options = $this->format_value_from_client('page,limit','get');
            $res = $this->news_model->fetch(array(),$this->news_model->table,$options);
            $this->output(SUCCESS_CODE,'获取信息成功',$res);
        }else{
            $this->normal_error_output();
        }
    }

}