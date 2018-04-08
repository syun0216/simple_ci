<?php
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/4/7
 * Time: 下午4:30
 */

class Company_news extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company_news_model');
    }

    /**
     * 获取公司讯息
     */
    public function get_company_news() {
        $res = $this->company_news_model->fetch();
        $this->output(SUCCESS_CODE,'获取公司咨询成功',$res);
    }

    public function dispatch_company_news() {
        $rules = $this->format_rules('title','content','time');
        if($this->check_parameters($rules,'post')) {
            $attr = $this->format_value_from_client('title,content,time','post');
            $res = $this->company_news_model->add($attr);
            $this->output(SUCCESS_CODE,'发布信息成功',$res);
        }else {
            $this->normal_error_output();
        }
    }

    public function edit_company_news() {
        $rules = $this->format_rules('id,title,content,time');
        if($this->check_parameters($rules,'post')) {
            $where = $this->format_value_from_client('id');
            $attr = $this->format_value_from_client('title,content,time');
            $res = $this->company_news_model->edit($attr,$where);
            if($res) {
                $this->output(SUCCESS_CODE,'修改公司信息成功',$res);
            }else{
                $this->output(UPDATE_ERROR,'修改公司信息失败',$res);
            }
        }else{
            $this->normal_error_output();
        }
    }

    public function delete_company_news() {
        $rules = $this->format_rules('id');
        if($this->check_parameters($rules,'post')) {
            $where = $this->format_value_from_client('id');
            $this->company_news_model->delete($where);
            $this->output(SUCCESS_CODE,'删除成功',NULL);
        }else {
            $this->normal_error_output();
        }
    }
}