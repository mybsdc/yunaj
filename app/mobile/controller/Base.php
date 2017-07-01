<?php
/**
 * 公共控制器
 * 
 */

namespace app\mobile\controller;

use think\Controller;

class Base extends Controller
{
    // 访问控制
    public function _initialize()
    {
        parent::_initialize();
        if (!session('?checkuserid')){
            $this->redirect('mobile/login/index'); // 重定向至登录页
        }
    }
    
    /**
     * 判断当前用户有检查权限的城市
     * @param int $user_id 用户id
     * 
     */
    /* public function getMyCity($user_id)
    {
        
    } */
}