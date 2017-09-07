<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/30 0030
 * Time: 10:45
 */

namespace app\home\controller;
use think\Controller;

class City extends Base
{
    //城市概况
    function show(){
        $model=model("Zzjg");
        $tname=input("get.tname");
        //        $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $ces=$model->table("yunaj_xzqy")->select();
        $this->assign("ces",$ces);
        $this->assign("res",$res);
        $this->assign("tname",$tname);
        return  $this->fetch("city/ct1");
    }

    //获取街道表
    function street(){
        if (isset($_POST['start'])) {
            $start = $_POST['start'];
        } else {
            $start = 0;
        }
        if (isset($_POST['num'])) {
            $num = $_POST['num'];
        } else {
            $num =config("PAGE_NUM");
        }
        if($start<0){
            $start=0;
        }
        $did=input("post.did");
        $par=input("post.par");
        $model=model("Zzjg");
        $res="";
        $c="";
        if($did!="" && $par==""){
            $re=$model->table("yunaj_xzqy")->field("id")->where("parent_id={$did}")->select();
            $arr=array();
            for($k=0;$k<count($re);$k++){
                array_push($arr,$re[$k]['id']);
            }
            $arr_string = implode(',', $arr);
            $res=$model->table("yunaj_project")->where("xzqy_id in({$arr_string})")->order("id desc")->limit($start*$num,$num)->select();
            $c=$model->table("yunaj_project")->where("xzqy_id in({$arr_string})")->select();
            $res=array_unique($res);
        }else{
            $c=$model->table("yunaj_project")->where("xzqy_id={$did}")->select();
            $res=$model->table("yunaj_project")->where("xzqy_id={$did}")->order("id desc")->limit($start*$num,$num)->select();
        }
        $count=count($c);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("res",$res);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('par',$par);
        $this->assign('start',$start);
        echo   $this->fetch("city/ct2");
    }

    //新增街道
    function addStreet(){
        $did=input("post.did");
        $name=input("post.name");
        $model=model("Zzjg");
        $pd=$model->table("yunaj_project")->where("xzqy_id={$did} AND name='{$name}'")->select();
        if($pd){
            echo "false";
            exit;
        }
        $res=$model->execute("insert into yunaj_project VALUES (null,{$did},'{$name}','')");
        echo $res?"true":"false";
    }

    //删除街道
    function deleteStreet(){
        $id=input("post.id");
        $model=model("Zzjg");
        echo $model->table("yunaj_project")->where("id={$id}")->delete();
    }

    //修改名称
    function upName(){
        $id=input("post.id");
        $name=input("post.name");
        $model=model("Zzjg");
        $pid=$model->table("yunaj_xzqy")->field("parent_id")->where("id={$id}")->select();
        if(intval($pid[0]['parent_id'])>0){
            $nid=$model->table("yunaj_xzqy")->field("id")->where("parent_id={$pid[0]['parent_id']} AND name='{$name}'")->select();
            if($nid){
                echo "false";
                exit;
            }
            $res=$model->execute("update yunaj_xzqy set name='{$name}' WHERE id={$id}");
            echo $res?"true":"false";
        }else{
            $nid=$model->table("yunaj_xzqy")->field("id")->where("parent_id=0 AND name='{$name}'")->select();
            if($nid){
                echo "false";
                exit;
            }
            $res=$model->execute("update yunaj_xzqy set name='{$name}' WHERE id={$id}");
            echo $res?"true":"false";
        }
    }

    //新增区域/城市
    function addQ(){
        $pid=input("post.pid");
        $name=input("post.name");
        $model=model("Zzjg");
        if($pid!="" && $pid!=null){
            $pd=$model->table("yunaj_xzqy")->where("parent_id={$pid} AND name='{$name}'")->select();
            if($pd){
                echo "false";
                exit;
            }
            $res=$model->execute("insert into yunaj_xzqy VALUES (null,'{$name}',{$pid},1)");
            echo $res?"true":"false";
        }else{
            $pd=$model->table("yunaj_xzqy")->where("parent_id=0 AND name='{$name}'")->select();
            if($pd){
                echo "false";
                exit;
            }
            $res=$model->execute("insert into yunaj_xzqy VALUES (null,'{$name}',0,0)");
            echo $res?"true":"false";
        }

    }

    //删除城市或区域
    function deleteCq(){
        $id=input("post.did");
        $model=model("Zzjg");
        $pd=$model->table("yunaj_xzqy")->field("id")->where("parent_id={$id}")->select();
        $pzid=$model->table("yunaj_project")->field("id")->where("xzqy_id={$id}")->select();
        $rid=$model->table("yunaj_roomlog")->field("id")->where("xzqy_id={$id}")->select();
        $czid=$model->table("yunaj_city2zzjg")->field("id")->where("xzqy_id={$id}")->select();
        if($pd){
            echo "false";
            exit;
        }
        if($pzid){
            echo "false";
            exit;
        }
        if($rid){
            echo "false";
            exit;
        }
        if($czid){
            echo "false";
            exit;
        }
        $res=$model->table("yunaj_xzqy")->where("id={$id}")->delete();
        echo $res?"true":"false";
    }
}