<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
    }

    public function get_user()
    {
        if($this->get_value('id') === NULL) {
            $res = $this->user_model->fetch();
        }
        else{
            $where = array(
                'id' => $this->get_value('id')
            );
            $res = $this->user_model->fetch($where);
        }
        $this->output(200,"ok",$res);
    }

    public function add_user()
    {
        $this->load->model('last_login_model');
        $where = array(
            'account' => $this->post_value('account')
        );
        $res = $this->user_model->fetch($where);
        if($res) {
            $this->output(SAME_ROW,'存在同名用户',NULL);
        }else {
            $rules = $this->format_rules('account,password');
            if($this->check_parameters($rules, 'post')) {
                $key = 'account,password';
                $attr = $this->format_value_from_client($key, 'post');
                $res = $this->user_model->add($attr);
                $this->output(SUCCESS_CODE,'OK',$res);
                //新增一条last_login
                $attr_last_login = array(
                    'user_id' => $res,
                    'last_login_time' => date('Y-m-d H:i:s')
                );
                $this->last_login_model->add($attr_last_login);
            }else {
                $this->normal_error_output();
            }
        }
    }

    public function change_password() {
        $rules = $this->format_rules('id,password');
        if($this->check_parameters($rules)) {
            $where = $this->format_value_from_client('id');
            $attr = $this->format_value_from_client('password');
            $res = $this->user_model->edit($attr,$where);
            if($res) {
                $this->output(SUCCESS_CODE,'修改密码成功',$res);
            }else{
                $this->output(UPDATE_ERROR,'修改密码失败',$res);
            }
        }else{
            $this->normal_error_output();
        }
    }

    public function login() {
        $rules = $this->format_rules('account,password');
        if($this->check_parameters($rules)){
            $where = array(
                'account' => $this->post_value('account')
            );
            $user = $this->user_model->fetch($where);
            if(!$user) {
                $this->output(ROW_NOT_FOUND,'没有该用户',NULL);
            }else{
                $this->update_user_session($user[0]);
                $this->output(SUCCESS_CODE,'登录成功',$user);
            }
        }else {
            $this->normal_error_output();
        }
    }

    private function update_user_session($user) {
        $this->load->model('last_login_model');
        $where = array(
            'user_id' => $user['id']
        );
        $attr = array(
            'last_login_time' => date('Y-m-d H:i:s')
        );
        $this->last_login_model->edit($attr,$where);

        $this->session->set_userdata('user', $user);
    }
}