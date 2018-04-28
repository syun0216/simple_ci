<?php

class Team extends MY_Controller {
  public function __construct()
    {
        parent::__construct();
        $this->load->model('rank_model');
    }

    public function get_team_rank() {
      // var_dump($this->get_value('rel'));
      // die;
      $rules = $this->format_rules('rel');
       if($this->check_parameters($rules,'get')) {
         $where = $this->format_value_from_client('rel','get');
         $res = $this->rank_model->fetch($where,
        $this->rank_model->table,array('order_by' =>'rank ASC'));
        $this->output(SUCCESS_CODE,'获取积分榜榜成功',$res);
       }else {
         $this->normal_error_output();
       }
    }
}