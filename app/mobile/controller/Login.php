<?php
/**
 * 登录控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;

class Login extends Controller
{
    // 登录界面
    public function index()
    {
        return $this->fetch();
    }
    
    // 处理登录请求
    public function doLogin()
    {
        $login = model('User');
        
        // Ajax数据
        if (input('?post.username')){ // 不能使用?post.作为条件，必须跟对应的数据名
            $username = input('post.username/s'); // 强制转为字符串类型
            $pwd = md5(input('post.pwd'));
            $result = $login->doLogin($username, $pwd);
            
            // 用户名密码验证成功
            if ($result){
                $uid = $result['id']; //检查者id
                $openid = $this->getBaseInfo(); // 调用微信接口获取openid
                /* if (!$openid){ // openid获取失败
                    return false;
                } */
                // $openid = 2018;
                if (empty($result['openid'])){ // 用户的第一次
                    
                    // 写入openid
                    $login->inputOpenId($uid, $openid);
                    session('checkuserid', $uid); // 写入检查者id
                    return true;
                }
                    
                // 检查openid是否匹配
                $checkResult = $login->checkOpenid($uid, $openid);
                if ($checkResult){
                    session('checkuserid', $uid); // 写入检查者id
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
    
    // 获取code
    public function getBaseInfo()
    {
//         $appid = 'wx0006e9d06b8476e2';
        $redirect_uri = urlencode(config('login.redirect_uri')); // 回调地址，urlencode编码
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('login.appid') . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_base&state=llf#wechat_redirect';
        header('location' . $url);
    }
    
    // 获取OpenId
    public function getUserOpenId()
    {
//         $appid = 'wx0006e9d06b8476e2';
//         $appsecret = 'fe013c0c76e07c6dc3e9496dc774a0f0';
        $code = $_GET['code'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('login.appid') . '&secret=' . config('login.appsecret') . '&code=' . $code . '&grant_type=authorization_code';
        // return json_decode(file_get_contents($url));
        
        // 调用微信接口并获取返回结果
        return json_decode(doCurl($url), true)['openid'];
    }
}