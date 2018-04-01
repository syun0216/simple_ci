<?php
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/3/30
 * Time: 下午5:09
 */

class Info extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('info_model');
    }

    /**
     * 通过user_id获取用户详情
     * @params int user_id
     * @return array
     */
    public function get_user_info()
    {
        $rules = $this->format_rules('user_id');
        if($this->check_parameters($rules,'get')) {
            $attr = $this->format_value_from_client('user_id','get');
            $res = $this->info_model->fetch($attr);
            $this->output(SUCCESS_CODE, '获取用户详情成功', $res);
        }else{
            $this->normal_error_output();
        }
    }

    /**
     * 修改用户信息
     */
    public function edit_user_info() {
        $rules = $this->format_rules('user_id,nick,intro,sex');
        if($this->check_parameters($rules,'post')) {
            $where = $this->format_value_from_client('user_id');
            $attr = $this->format_value_from_client('nick,intro,sex');
            $res = $this->info_model->edit($attr,$where);
            $this->output(SUCCESS_CODE,'编辑成功',$res);
        }else {
            $this->normal_error_output();
        }
    }
}