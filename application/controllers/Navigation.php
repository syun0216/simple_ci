<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Syun
 * Date: 2018/4/6
 * Time: 下午7:50
 */

class Navigation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('navigation_model');
    }

    /**
     *获取菜单
     */
    public function fetch_menu() {
        $data = $this->generate_net_menu($this->navigation_model->fetch());
        $this->output(SUCCESS_CODE,'获取菜单成功',$data);
    }

    /**
     * 生成网格型菜单
     * @param $menu
     * @param int $parent_id
     * @return array
     */
    private function generate_net_menu($menu, $parent_id=0)
    {
        $ret = array();
        foreach ($menu as $m)
        {
            if ($m['parent_id'] == $parent_id) {
                $m['children'] = self::generate_net_menu($menu,$m['id']);
                $ret[] = $m;
            }
        }
        return $ret;
    }

}