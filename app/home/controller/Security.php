<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3 0003
 * Time: 9:51
 */

namespace app\home\controller;
use think\Controller;

class Security extends Base
{
    //显示安全维度页面
    function show(){
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
        $model=model("Csdetail");
        $tname=input("get.tname");
        //        $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $re=$model->table("yunaj_ywcs")->select();
        $c=$model->where("ywcs_id=1")->count();
        $ses=$model->where("ywcs_id=1")->order("id desc")->limit($start*$num,$num)->select();
        $count=$c;
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("res",$res);
        $this->assign("re",$re);
        $this->assign("ses",$ses);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('tname',$tname);
        $this->assign('start',$start);
        return   $this->fetch("security/su1");
    }

    //明细分页
    function suPage(){
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
        $model=model("Csdetail");
        $id=input("post.id");
        $c=$model->where("ywcs_id='{$id}'")->count();
        $ses=$model->where("ywcs_id='{$id}'")->order("id desc")->limit($start*$num,$num)->select();
        $count=$c;
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("ses",$ses);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        return   $this->fetch("security/su2");
    }

    //新增明细
    function addCd(){
        $model=model("Csdetail");
        $question=input("post.question");
        $ywcs_id=input("post.ywcs");
        // $question='乌龟爬';
        // $ywcs_id='1';
        $d1=input("post.d1");
        $d2=input("post.d2");
        if($d1=="" || $d2==""){
            $name=$question;
        }else{
            $name=$question."|".$d1."|".$d2;
        }
        $pd=$model->table("yunaj_csdetail")->where("ywcs_id='{$ywcs_id}' AND name='{$name}'")->select();
        if($pd){
            echo "false";
            exit;
        }
        $res=$model->execute("insert into yunaj_csdetail VALUES (null,{$ywcs_id},'{$name}')");
        echo $res?"true":"false";
    }

    //删除明细
    function deleteSu(){
        $id=input("post.id");
        $model=model("Csdetail");
        $res=$model->where("id={$id}")->delete();
        echo $res?"true":"false";
    }

    //修改明细
    function updateSu(){
        $model=model("Csdetail");
        $question=input("post.sname");
        $d1=input("post.d1");
        $d2=input("post.d2");
        $id=input("post.sid");
        if($d1=="" || $d2==""){
            $name=$question;
        }else{
            $name=$question."|".$d1."|".$d2;
        }
        $pd=$model->table("yunaj_csdetail")->where("name='{$name}'")->select();
        if($pd){
            echo "false";
            exit;
        }
        $res=$model->execute("update yunaj_csdetail set name='{$name}' where id={$id}");
        echo $res?"true":"false";
    }

}