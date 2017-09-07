<?php
namespace app\home\controller;
use think\Controller;
class Index extends Base
{
    function index(){
        $model=model('Fun');
        //        $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $this->assign("res",$res);
        return  $this->fetch("index/index");
    }
    public function tNav()
    {
        $fid=input("post.fid");
        $model=model('Fun');
        $res=$model->where("parent_id={$fid}")->select();
        $this->assign("res",$res);
        echo  $this->fetch("index/tnav");
    }
}
