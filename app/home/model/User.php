<?php
/**
 * 该模型对应yunaj_user表
 * 
 */

namespace app\home\model;

use think\Model;

class User extends Model
{
    /**
     * 判断用户名是否存在
     * @param string $username
     * return array
     * 
     */
    public function haveUser($username)
    {
        return $this->where("code = '$username' OR mobile = '$username'")->find();
    }
    
    /**
     * 判断该用户是否启用
     * @param string $username
     * return array
     *
     */
    public function isEnabled($username)
    {
        return $this->where("(code = '$username' OR mobile = '$username') AND is_Enable = 1")->find();
    }
    
    /**
     * 判断该用户是否对应角色
     * @param string $uid
     * return array
     * 
     */
    public function haveRole($uid)
    {
        return db('role2user')->where(['user_id' => $uid])->field('user_id')->find();
    }
    
    /**
     * 处理登录请求
     * @param int $username 手机号或用户代码
     * @param int $pwd 密码
     * return array 登录结果
     * 
     */
    public function doLogin($username, $pwd)
    {
        return $result = db('user')->where("(code = '$username' OR mobile = '$username') AND pwd = '$pwd'")->find(); // 单引号不可省略，逻辑OR多个需用括号引起
    }
}