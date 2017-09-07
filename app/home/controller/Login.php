<?php
/**
 * 登录
 * 
 */

namespace app\home\controller;

use think\Controller;

class Login extends Controller
{
    /**
     * 实例化模型
     * 
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->room = model('Room');
        $this->user = model('User');
    }
    
    /**
     * 登录页
     * 
     */
    public function index()
    {
        return $this->fetch();
    }
    
    /**
     * 处理登录请求
     * 
     */
    public function doLogin()
    {
        if (empty($_POST['username']) || $_POST['pwd'] === ''){
            return $this->error('非法访问！');
        }
        $username = input('post.username/s'); // 强制转字符串
        $pwd = md5(input('post.pwd'));
        
        // 判断用户名是否存在
        if (!$this->user->haveUser($username)){
            return ['code' => 0]; // 用户名或手机号码不存在
        }
        
        // 判断账户是否启用
        $isEnabled = $this->user->isEnabled($username);
        if (!$isEnabled){
            return ['code' => 2]; // 该账户未启用
        }
        
        // 判断账户是否对应角色
        if (!$this->user->haveRole($isEnabled->id)){ // 传入的user_id
            return ['code' => 3]; // 尚未分配角色
        }
        
        // 密码与用户名是否匹配
        $result = $this->user->doLogin($username, $pwd);
        if ($result){
            session('uid', $result['id']); // 写入操作人id
            session('uname', $result['name']);
            if (input('?post.rememberMe')){ // 勾选记住我
                cookie('username', input('post.username'), 3600*24*7); // 记用户名，时效一周
            }
            return ['name'=> $result['name'], 'code' => 1]; // 验证成功
        } else {
            return ['code' => -1]; // 密码错误
        }
    }
}