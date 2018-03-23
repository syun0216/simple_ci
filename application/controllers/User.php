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
        $res = $this->user_model->getUser();
        $this->output($res);
    }

    public function add_user()
    {
        var_dump($this->input->post('account'));
        $res = $this->user_model->add(
            array('account' => $this->post_value('account'),
                'password' => $this->post_value('password'))
        );
        $this->output($res);
    }
}