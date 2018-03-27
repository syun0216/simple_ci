<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function get_user()
    {
        $res = $this->user_model->fetch();
        $this->output(200,"ok",$res);
    }

    public function add_user()
    {
        $where = array(
            'account' => $this->post_value('account'),
            'password' => $this->post_value('password')
        );
        $res = $this->user_model->fetch($where);
        if($res) {
            $this->output(SAME_ROW,'存在同名用户',NULL);
        }
        $rules = array(
            array(
                'field' => 'account',
                'rules' => array('required')
            ),
            array(
                'field' => 'password',
                'rules' => array('password')
            )
        );
        $this->check_parameters($rules, 'post');
        $key = 'account,password';
        $attr = $this->format_value_from_client($key, 'post');
        $res = $this->user_model->add($attr);
        $this->output($res);
    }

    public function edit_user() {

    }
}