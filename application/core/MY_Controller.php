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

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->helper('resultcode');
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
        if($form_validation->run() === FALSE) {
            throw new Exception('参数出错',INVALID_PARAMETER);
        }
    }

    /**
     * 将get或者post参数存成数组以便插入数据库
     * @param string $key
     * @param string $method default='get'
     * @return array
     */
    public function format_value_from_client($key='', $method='get') {
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