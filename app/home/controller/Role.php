<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5 0005
 * Time: 11:48
 */

namespace app\home\controller;

use think\Controller;
class role extends Base
{
    //显示角色和功能模块页面
    function show(){
        $model = model("Room");
        $tname = input("get.tname");
        $r = $model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $ro = $model->table("yunaj_roles")->select();
        $this->assign('tname', $tname);
        $this->assign("r", $r);
        $this->assign("res", $res);
        $this->assign("ro", $ro);
        return $this->fetch("roles/role");
    }
    //读取对应的功能模块
    function updateRl(){
        $model = model("Room");
        $id=input("post.id");
        $res = $model->table("yunaj_role2func")->where("role_id={$id}")->select();
        echo json_encode($res);
    }

    //修改对应的功能模块
    function updateRls(){
        $model = model("Room");
        $id=input("post.id");
        $fids=input("post.fids/a");
//        $id="4";
//        $fids=array("4","5","6");
        $res = $model->table("yunaj_role2func")->where("`role_id`='{$id}'")->select();
        if($res){
            $model->table("yunaj_role2func")->where("`role_id`='{$id}'")->delete();
        }
        $t="";
       for($i=0;$i<count($fids);$i++){
            $t=$model->execute("insert into yunaj_role2func VALUES (null,{$id},'{$fids[$i]}')");
       }
       echo $t?"true":"false";
    }
}