<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/3/23
 * Time: 下午5:38
 */

class MY_Controller extends CI_Controller {
    // 重写ci的input、output、form_validation
    public $db;
    /** @var CI_Input */
    public $input;
    /** @var CI_Output */
    public $output;
    /** @var CI_Form_validation */
    public $form_validation;
    /** @var CI_Loader */
    public $load;

    //MODEL START
    /** @var user_model*/
    public $user_model;

    public function __construct()
    {
        parent::__construct();
//        $this->load->database();
        $this->load->library('form_validation');
        $this->load->helper('resultcode');
        $this->load->library('session');
        $this->db = $this->load->database('qhdata', TRUE);
        $this->set_user_from_session();
    }

    private function set_user_from_session() {
        $s_user = $this->session->userdata('user');
        $uri = strtoupper($this->uri->uri_string());
//        if(in_array($uri,array('USER/LOGIN','COMPANY_NEWS/GET_COMPANY_NEWS'))) {
//
//        } else {
//            if(!$s_user['id']) {
//                $this->output->set_status_header(401);
//                die;
//            }else{
//                $this->uid = $s_user['id'];
//            }
//        }
    }

    public function output($code=SUCCESS_CODE, $msg="", $data=array()){
        $output = $this->output;

        $ret=array(
            'code'  =>  $code,
            'msg'   =>  $msg?$msg:NULL,
            'data'  =>  $data
        );

        //TODO:跨域的临时解决方案
        $output->set_header("Access-Control-Allow-Origin:*");
        $output->set_content_type('application/json');
        $output->set_output(json_encode($ret));

    }

    /**
     * 快速输出最常规的参数出错错误
     */
    public function normal_error_output() {
        $this->output(INVALID_PARAMETER,'参数不正确',$this->form_validation->error_array());
    }

    /**
     * 检测参数是否符合规则
     * @param array $rules
     * @param string $method
     * @throws MY_Exception
     */
    public function check_parameters($rules = array(), $method = 'post') {
        $form_validation = $this->form_validation;
        if($method === 'get') {
            $data = array();
            foreach($rules as $f){
                $data[$f['field']] = $this->input->get($f['field']);
            }
            $form_validation->set_data($data);
        }else {

        }
        $form_validation->set_rules($rules);
        if($form_validation->run() === FALSE) {
            return False;
        }
        return True;
    }

    /**
     * 将get或者post参数存成数组以便插入数据库
     * @param string $key
     * @param string $method default='get'
     * @return array
     */
    public function format_value_from_client($key='', $method='post') {
        $key = explode(',',$key);
        $attribute = array();
        foreach($key as $k => $v) {
            if($method === 'get') {
                $attribute[$v] = $this->get_value($v);
            }else {
                $attribute[$v] = $this->post_value($v);
            }
        }
        return $attribute;
    }

    /**
     * @param string $rules
     * @return array
     */
    //转换rules 为可用array以供检测
    public function format_rules($rules='') {
        $arr = explode(',',$rules);
        $result = array();
        foreach ($arr as $k => $v) {
            array_push($result,
                array(
                    'field' => $v,
                    'rules' => array('required')
                )
            );
        }
        return $result;
    }


    //获取post接口的参数(in body)
    public function post_value($field, $default=NULL){
        $input = $this->input;

        if($input->post($field) || $input->post($field) === '0'){
            return $input->post($field);
        } else {
            return $default;
        }
    }

    //获取get接口的参数(in query)
    public function get_value($field, $default=NULL){
        $input = $this->input;

        if($input->get($field) || $input->get($field) === '0'){
            return $input->get($field);
        } else {
            return $default;
        }
    }
}