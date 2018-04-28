<?php

class Player extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('goal_model');
    $this->load->model('assist_model');
  }

   /**
     * 获取射手榜 
     * @params int rel //联赛类型
     * @return array
     */

     public function get_player_goals_rank() {
       $rules = $this->format_rules('rel');
       if($this->check_parameters($rules,'get')) {
         $where = $this->format_value_from_client('rel','get');
         $res = $this->goal_model->fetch($where,
        $this->goal_model->table,array('order_by' =>'data DESC'));
        $this->output(SUCCESS_CODE,'获取射手榜成功',$res);
       }else {
         $this->normal_error_output();
       }
     }

     /**
     * 获取助攻榜
     * @params int rel //联赛类型
     * @return array
     */

    public function get_player_assist_rank() {
      $rules = $this->format_rules('rel');
      if($this->check_parameters($rules,'get')) {
        $where = $this->format_value_from_client('rel','get');
        $res = $this->assist_model->fetch($where,
       $this->assist_model->table,array('order_by' =>'data DESC'));
       $this->output(SUCCESS_CODE,'获取助攻榜成功',$res);
      }else {
        $this->normal_error_output();
      }
    }

}