<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/27 0027
 * Time: 11:06
 */

namespace app\home\controller;
use think\Controller;

class StructureSet extends Base
{
    //组织架构页面
    function set(){
        $model=model("Zzjg");
        $tname=input("get.tname");
        $re=$model->select();
//                $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $c=$model->table("yunaj_city2zzjg")->field("xzqy_id")->select();
        $ct=$model->table("yunaj_xzqy")->where("type=0")->select();
        if($c){
            foreach ($ct as $key => $value) {
                foreach ($c as $k => $v) {
                    if($v['xzqy_id']==$value['id']){
                        unset($ct[$key]);
                    }
                }
            }
        }

        $this->assign("res",$res);
        $this->assign("re",$re);
        $this->assign("ct",$ct);
        $this->assign("tname",$tname);
        return  $this->fetch("structure/stt1");
    }
    //获取角色
    function getRole(){
        $model=model("Zzjg");
        $did=input("post.d_id");
        $res=$model->table("yunaj_role")->
            field("yunaj_role.*,yunaj_roles.name")->
            where("zzjg_id={$did}")->
            join("yunaj_roles "," yunaj_roles.id=yunaj_role.r_id")->
            order("id desc")->
            select();
        echo json_encode($res);
    }

    //新增部门
    function addDepartment(){
        $model=model("Zzjg");
//        echo json_encode($_POST);
//        exit;
        $data['name']=input("post.bmName");
        $data['type']=3;
        $data['parent_id']=input("post.parent_id");
        $nm=$model->where("name='{$data['name']}' AND parent_id={$data['parent_id']}")->select();
        if($nm){
            echo "false";
            exit;
        }
        $res=$model->isUpdate(false)->save($data);
        $id=$model->id;
        $arr['is_end']=0;
        if($res){
            $model->where("id={$data['parent_id']}")->update($arr);
            $arr1['r_id']=input("post.jc");;
            $arr2['r_id']=input("post.sh");;
            $arr3['r_id']=input("post.gl");;
            $arr1['zzjg_id']=$id;
            $arr2['zzjg_id']=$id;
            $arr3['zzjg_id']=$id;
            $re="";
            if($arr1['r_id']!="" && $arr1['r_id']!=null){
                $re= $model->execute("insert into yunaj_role VALUES (null,{$arr1['zzjg_id']},{$arr1['r_id']})");
            }
            if($arr2['r_id']!="" && $arr2['r_id']!=null){
                $re= $model->execute("insert into yunaj_role VALUES (null,{$arr2['zzjg_id']},{$arr2['r_id']})");
            }
            if($arr3['r_id']!="" && $arr3['r_id']!=null){
                $re= $model->execute("insert into yunaj_role VALUES (null,{$arr3['zzjg_id']},{$arr3['r_id']})");
            }
            echo $re?"true":"false";
        }else{
            echo "false";
        }
    }

    //获取部门用户
    function getBmUser(){
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
        $model=model("Zzjg");
        $did=input("post.did");
        $par=input("post.par");
        $pars=input("post.pars");
        $role=input("post.role");
        $tp=input("post.tp");
        if($did!=""  && (int)$tp==3){//部门
            $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$did}")->select();
            $arr=array();
            for($k=0;$k<count($rid);$k++){
                array_push($arr,$rid[$k]['id']);
            }
            $arr_string = implode(',', $arr);
            $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
            $res="";
            if($uid){
                $arr1=array();
                for($k=0;$k<count($uid);$k++){
                    array_push($arr1,$uid[$k]['user_id']);
                }
                $arr1=array_unique($arr1);
                $arr1=array_merge($arr1);
                $arr_string1 = implode(',', $arr1);
                $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
            }
            $count=count($uid);
            $pageCount = (int)$count;
            $page=$start+1;
            $pageCount = ceil($pageCount / $num);
            $this->assign("res",$res);
            $this->assign('pageCount',$pageCount);
            $this->assign('count',$count);
            $this->assign('page',$page);
            $this->assign('num',$num);
            $this->assign('start',$start);
            echo $this->fetch("structure/stt4");
        }else if($did!=""  && (int)$tp==2){//单公司
            $zid=$model->field("id")->where("parent_id={$did}")->select();
            $res="";
            $uid="";
            if($zid){
                $arr3=array();
                for($k=0;$k<count($zid);$k++){
                    array_push($arr3,$zid[$k]['id']);
                }
                $arr_string3 = implode(',', $arr3);
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id in({$arr_string3})")->select();
                $arr=array();
                for($k=0;$k<count($rid);$k++){
                    array_push($arr,$rid[$k]['id']);
                }
                $arr_string = implode(',', $arr);
                $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                $uid=array_unique($uid);
                $uid=array_merge($uid);
                if($uid){
                    $arr1=array();
                    for($k=0;$k<count($uid);$k++){
                        array_push($arr1,$uid[$k]['user_id']);
                    }
                    $arr_string1 = implode(',', $arr1);
                    $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                }else{
                    $uid="";
                }
            }else{
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$did}")->select();
                if($rid){
                    $arr=array();
                    for($k=0;$k<count($rid);$k++){
                        array_push($arr,$rid[$k]['id']);
                    }
                    $arr_string = implode(',', $arr);
                    $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                    $uid=array_unique($uid);
                    $uid=array_merge($uid);
                    $res="";
                    if($uid){
                        $arr1=array();
                        for($k=0;$k<count($uid);$k++){
                            array_push($arr1,$uid[$k]['user_id']);
                        }
                        $arr_string1 = implode(',', $arr1);
                        $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                    }else{
                        $uid="";
                    }
                }
            }
            if($uid=="" || $uid==null){
                $count=0;
            }else{
                $count=count($uid);
            }
            $pageCount = (int)$count;
            $page=$start+1;
            $pageCount = ceil($pageCount / $num);
            $this->assign("res",$res);
            $this->assign('pageCount',$pageCount);
            $this->assign('count',$count);
            $this->assign('page',$page);
            $this->assign('num',$num);
            $this->assign('start',$start);
            echo $this->fetch("structure/stt4");
        }else if($did!=""  && (int)$tp==1){//区域公司
            $zid=$model->field("id,type")->where("parent_id={$did}")->select();
            $res="";
            $uid="";
            if($zid){
                $arr3=array();
                for($k=0;$k<count($zid);$k++){
                    if($zid[$k]['type']==3){//部门
                        array_push($arr3,$zid[$k]['id']);
                    }else{
                        $dgid=$model->field("id")->where("parent_id={$zid[$k]['id']}")->select();
                        if($dgid){
                            for($i=0;$i<count($dgid);$i++){
                                array_push($arr3,$dgid[$i]['id']);
                            }
                        }
                    }

                }
                $arr3=array_unique($arr3);
                $arr_string3 = implode(',', $arr3);
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id in({$arr_string3})")->select();
                $arr=array();
                for($k=0;$k<count($rid);$k++){
                    array_push($arr,$rid[$k]['id']);
                }
                $arr_string = implode(',', $arr);
                $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                $uid=array_unique($uid);
                $uid=array_merge($uid);
                if($uid){
                    $arr1=array();
                    for($k=0;$k<count($uid);$k++){
                        array_push($arr1,$uid[$k]['user_id']);
                    }
                    $arr_string1 = implode(',', $arr1);
                    $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                }else{
                    $uid="";
                }
            }else{
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$did}")->select();
                if($rid){
                    $arr=array();
                    for($k=0;$k<count($rid);$k++){
                        array_push($arr,$rid[$k]['id']);
                    }
                    $arr_string = implode(',', $arr);
                    $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                    $uid=array_unique($uid);
                    $uid=array_merge($uid);
                    $res="";
                    if($uid){
                        $arr1=array();
                        for($k=0;$k<count($uid);$k++){
                            array_push($arr1,$uid[$k]['user_id']);
                        }
                        $arr_string1 = implode(',', $arr1);
                        $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                    }else{
                        $uid="";
                    }
                }
            }
            if($uid=="" || $uid==null){
                $count=0;
            }else{
                $count=count($uid);
            }
            $pageCount = (int)$count;
            $page=$start+1;
            $pageCount = ceil($pageCount / $num);
            $this->assign("res",$res);
            $this->assign('pageCount',$pageCount);
            $this->assign('count',$count);
            $this->assign('page',$page);
            $this->assign('num',$num);
            $this->assign('start',$start);
            echo $this->fetch("structure/stt4");
        }else if($did!=""  && (int)$tp==0){//集团公司
            $zid=$model->field("id,type")->where("parent_id={$did}")->select();
            $res="";
            $uid="";
            if($zid){
                $arr3=array();
                for($k=0;$k<count($zid);$k++){
                    if($zid[$k]['type']==3){//部门
                        array_push($arr3,$zid[$k]['id']);
                    }else if($zid[$k]['type']==2){//单公司
                        $dgid=$model->field("id")->where("parent_id={$zid[$k]['id']}")->select();
                        if($dgid){
                            for($i=0;$i<count($dgid);$i++){
                                array_push($arr3,$dgid[$i]['id']);
                            }
                        }
                    }else if($zid[$k]['type']==1){//区域公司
                        $qyid=$model->field("id,type")->where("parent_id={$zid[$k]['id']}")->select();
                        $arr4=array();
                        if($qyid){
                            for($s=0;$s<count($qyid);$s++){
                                if($qyid[$s]['type']==3){
                                    array_push($arr3,$qyid[$s]['id']);
                                }else{
                                    $dgid=$model->field("id")->where("parent_id={$qyid[$s]['id']}")->select();
                                    if($dgid){
                                        for($i=0;$i<count($dgid);$i++){
                                            array_push($arr3,$dgid[$i]['id']);
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
                $arr3=array_unique($arr3);
                $arr_string3 = implode(',', $arr3);
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id in({$arr_string3})")->select();
                $arr=array();
                for($k=0;$k<count($rid);$k++){
                    array_push($arr,$rid[$k]['id']);
                }
                $arr_string = implode(',', $arr);
                $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                $uid=array_unique($uid);
                $uid=array_merge($uid);
                if($uid){
                    $arr1=array();
                    for($k=0;$k<count($uid);$k++){
                        array_push($arr1,$uid[$k]['user_id']);
                    }
                    $arr_string1 = implode(',', $arr1);
                    $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                }else{
                    $uid="";
                }
            }else{
                $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$did}")->select();
                if($rid){
                    $arr=array();
                    for($k=0;$k<count($rid);$k++){
                        array_push($arr,$rid[$k]['id']);
                    }
                    $arr_string = implode(',', $arr);
                    $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id in({$arr_string})")->select();
                    $uid=array_unique($uid);
                    $uid=array_merge($uid);
                    $res="";
                    if($uid){
                        $arr1=array();
                        for($k=0;$k<count($uid);$k++){
                            array_push($arr1,$uid[$k]['user_id']);
                        }
                        $arr_string1 = implode(',', $arr1);
                        $res=$model->table("yunaj_user")->where("id in({$arr_string1})")->limit($start*$num,$num)->select();
                    }else{
                        $uid="";
                    }
                }
            }
            if($uid=="" || $uid==null){
                $count=0;
            }else{
                $count=count($uid);
            }
            $pageCount = (int)$count;
            $page=$start+1;
            $pageCount = ceil($pageCount / $num);
            $this->assign("res",$res);
            $this->assign('pageCount',$pageCount);
            $this->assign('count',$count);
            $this->assign('page',$page);
            $this->assign('num',$num);
            $this->assign('start',$start);
            echo $this->fetch("structure/stt4");
        } else if($pars!="" && $role!=""){//角色
            $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$pars} AND r_id={$role}")->select();
            $uid=$model->table("yunaj_role2user")->field("user_id")->where("role_id={$rid[0]['id']}")->select();
            $res="";
            if($uid){
                $arr=array();
                for($k=0;$k<count($uid);$k++){
                    array_push($arr,$uid[$k]['user_id']);
                }
                $arr_string = implode(',', $arr);
                $res=$model->table("yunaj_user")->where("id in({$arr_string})")->limit($start*$num,$num)->select();
            }
            $count=count($uid);
            $pageCount = (int)$count;
            $page=$start+1;
            $pageCount = ceil($pageCount / $num);
            $this->assign('ruid',$rid[0]['id']);
            $this->assign("res",$res);
            $this->assign('pageCount',$pageCount);
            $this->assign('count',$count);
            $this->assign('page',$page);
            $this->assign('num',$num);
            $this->assign('start',$start);
            echo $this->fetch("structure/stt2");
        }
    }
    //获取用户
    function getUsers(){
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
        $mh="";
        $model=model('Fun');
        $c=$model->table("yunaj_user")->where("")->select();
        $res=$model->table("yunaj_user")->order("id desc")->limit($start*$num,$num)->select();
        $count=count($c);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("res",$res);
        $this->assign("mh",$mh);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        echo $this->fetch("structure/stt3");
    }
//分页
    public function userPages(){
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
        $mh=input("post.mh");
        $mh=trim($mh);
        if($mh!=""){
            $m="name like '%{$mh}%' or code like '%{$mh}%' or mobile like '%{$mh}%'";
        }else{
            $m="";
        }
        $model=model('User');
        $c=$model->where($m)->select();
        $res=$model->where($m)->order("id desc")->limit($start*$num,$num)->select();
        $count=count($c);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("res",$res);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        $this->assign('mh',$mh);
        echo $this->fetch("structure/stt3");
    }

    //新增用户
    function addRdu(){
        $model=model('User');
        $arr=input("post.ids/a");
        $ruid=input("post.ruid");
        $re="";
        for($i=0;$i<count($arr);$i++){
            $re=$model->table("yunaj_role2user")->where("role_id={$ruid} AND user_id={$arr[$i]}")->select();
            if($re){
                continue;
            } else{
                $model->execute("insert into yunaj_role2user VALUES (null,{$ruid},{$arr[$i]})");
            }
        }
        echo "true";
    }

    //删除用户
    function deleteRdu(){
        $ruid=input("post.ruid");
        $uid=input("post.u_id");
        $model=model('User');
        $re=$model->table("yunaj_role2user")->where("role_id={$ruid} AND user_id={$uid}")->delete();
        echo $re?"true":"false";
    }

    //得到权限
    function getR(){
        $id=input("post.id");
        $model=model('User');
        $res=$model->table("yunaj_role")->field("r_id")->where("zzjg_id={$id}")->select();
        echo  json_encode($res);
    }

    //修改公司或者部门名
    function updateDr(){
        $model=model("Zzjg");
        $name=input("post.name");
        $id=input("post.id");
        $res=$model->execute("update yunaj_zzjg set name='{$name}' WHERE id={$id}");
        echo $res?"true":"false";
    }

    //修改权限
    function updateRole(){
        $ar=input("post.role/a");
        $id=input("post.id");
//        $ar=array("2","4");
//        $id='4';
        $model=model("Zzjg");
        $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$id}")->select();
        if($rid){
            $res="";
            for($k=0;$k<count($rid);$k++){
                $model->table("yunaj_role2user")->where("role_id={$rid[$k]['id']}")->delete();
            }
            $model->table("yunaj_role")->where("zzjg_id={$id}")->delete();
            for ($i=0;$i<count($ar);$i++){
                $res=$model->execute("insert into yunaj_role VALUES (null,{$id},{$ar[$i]})");
            }
            echo $res?"true":"false1";
        }else{
            $res="";
            for ($i=0;$i<count($ar);$i++){
                $res=$model->execute("insert into yunaj_role VALUES (null,{$id},{$ar[$i]})");
            }
            echo $res?"true":"false1";
        }
    }

//删除部门
    function deleteBm(){
        $did=input("post.did");
        $model=model("Zzjg");
        $yid=$model->table("yunaj_ywcs")->field("id")->where("zzjg_id={$did}")->select();
        $rid=$model->table("yunaj_role")->field("id")->where("zzjg_id={$did}")->select();
        $zid=$model->field("id")->where("parent_id={$did}")->select();
        if($yid){
            echo "false";
            exit;
        }
        if($rid){
            echo "false";
            exit;
        }
        if($zid){
            echo "false";
            exit;
        }
        $res=$model->field("id")->where("id={$did}")->delete();
        echo $res?"true":"false";
    }

    //新增公司
    function addCom(){
//        echo json_encode($_POST);
//        exit;
        $model=model("Zzjg");
        $did=input("post.parent_id");
        $type=input("post.gl");
        $name=input("post.gsName");
        $res=$model->execute("insert into yunaj_zzjg VALUES (null,'{$name}',$did,$type,'')");
        echo $res?"true":"false";
    }

    //新增公司关联
    function addCz(){
        $id=input("post.id");
        $cid=input("post.cid");
        $model=model("Zzjg");
        $jc=$model->table("yunaj_city2zzjg")->where("xzqy_id={$cid} OR zzjg_id={$id}")->select();
        if($jc){
            echo "false";
            exit;
        }
        $res=$model->execute("insert into yunaj_city2zzjg VALUES (null,'{$cid}','{$id}')");
        echo $res?"true":"false";

    }

    //获取已关联的城市id
    function getCity(){
        $id=input("post.id");
        $model=model("Zzjg");
        $res=$model->table("yunaj_city2zzjg c")->field("x.name")->
        join("yunaj_xzqy x","x.id=c.xzqy_id")->
        where("c.zzjg_id='{$id}'")->select();
        echo $res?$res[0]['name']:"false";
    }
}