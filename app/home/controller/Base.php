<?php
/**
 * 公共控制器
 * 
 */

namespace app\home\controller;

use think\Controller;

class Base extends Controller
{
    // 访问控制
    public function _initialize()
    {
        parent::_initialize();
        if (!session('?uid')){
            $this->redirect('home/login/index'); // 重定向至登录页
        }
    }

    //获取权限对应的模块
    function getFun(){
        $uid=session("uid");
        $model=model("User");
        $role=$model->table("yunaj_role2user")->field("role_id")->where("user_id='{$uid}'")->select();
        $arr="";
        for($i=0;$i<count($role);$i++){
            $arr[]=$role[$i]["role_id"];
        }
        $arr_string=implode(",",$arr);
        $rid=$model->table("yunaj_role")->field("r_id")->where("id in({$arr_string})")->select();
        $arr1="";
        for($i=0;$i<count($rid);$i++){
            $arr1[]=$rid[$i]["r_id"];
        }
        $arr1=array_unique($arr1);
        $arr1=array_merge($arr1);
        $arr_string1=implode(",",$arr1);
        $fid=$model->table("yunaj_role2func")->field("func_id")->where("role_id in({$arr_string1})")->select();
        $arr2="";
        for($i=0;$i<count($fid);$i++){
            $arr2[]=$fid[$i]["func_id"];
        }
        $arr2=array_unique($arr2);
        $arr2=array_merge($arr2);
        $arr_string2=implode(",",$arr2);
        $fun=$model->table("yunaj_fun")->where("id in({$arr_string2})")->order("case id when 6 then 1 when 1 then 2 when 2 then 3 when 3 then 4 when 4 then 5 when 5 then 6 end")->select();
        return $fun;
    }
}