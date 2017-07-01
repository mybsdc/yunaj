<?php
/**
 * 该模型对应yunaj_user表
 * 
 */

namespace app\mobile\model;

use think\Model;

class User extends Model
{
    /**
     * 处理登录请求
     * @param int $username 手机号或用户代码
     * @param int $pwd 密码
     * return array 登录结果
     * 
     */
    public function doLogin($username, $pwd)
    {
        return $result = db('user')->where("(code = '$username' OR mobile = '$username' OR name = '$username') AND pwd = '$pwd'")->find(); // 单引号不可省略，逻辑OR多个需用括号引起
    }
    
    /**
     * 写入用户openid
     * @param int $uid 用户id
     * @param string $openid 用户openid
     * return int 影响条数
     * 
     */
    public function inputOpenId($uid, $openid)
    {
        return $this->where(['id' => $uid])->update(['openid' => $openid]); // 首次授权，更新用户的openid字段
    }
    
    /**
     * 检查openid与当前用户是否匹配
     * @param int $uid 用户id
     * @param string $openid 用户openid
     * 
     */
    public function checkOpenid($uid, $openid)
    {
        return $this->where(['id' => $uid, 'openid' => $openid])->find();
    }
}