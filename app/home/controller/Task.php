<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6 0006
 * Time: 9:47
 */

namespace app\home\controller;

use think\Controller;
class Task extends Base
{
    //任务页面显示
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
        $model = model("Taskset");
        // $id=$_SESSION['uid'];
        $id = session('uid');
//        $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
//        echo json_encode($res);
//        exit;
        $role_id = $model->table("yunaj_role2user")->field("role_id")->where("user_id={$id}")->select();
        $arr=array();
        for ($i=0;$i<count($role_id);$i++){
            $arr[]=$role_id[$i]['role_id'];
        }
        $arr_string=implode(",",$arr);
        $zzjg_id = $model->table("yunaj_role")->field("zzjg_id")->where("id in({$arr_string})")->select();
        $zzjg_id=array_unique($zzjg_id);
        $zzjg_id=array_merge($zzjg_id);
        $zid=array();
        for($i=0;$i<count($zzjg_id);$i++){
            $type = $model->table("yunaj_zzjg")->field("type")->where("id={$zzjg_id[$i]['zzjg_id']}")->select();
            if($type[0]['type']==3){
                $d = $model->table("yunaj_zzjg")->field("parent_id")->where("id={$zzjg_id[$i]['zzjg_id']}")->select();
                $zid[]=$d[0]['parent_id'];
            }else{
                $zid[]=$zzjg_id[$i]['zzjg_id'];
            }
        }
        $zid=array_unique($zid);
        $zid=array_merge($zid);
        $arr_string1=implode(",",$zid);
        $xid = $model->table("yunaj_city2zzjg")->field("xzqy_id")->where("zzjg_id in ({$arr_string1})")->select();
        $arr2=array();
        for ($i=0;$i<count($xid);$i++){
            $arr2[]=$xid[$i]['xzqy_id'];
        }
        $arr_string2=implode(",",$arr2);
        if($arr_string2==""){
            return $this->fetch("task/tishi");
            exit;
        }
        $ct = $model->table("yunaj_xzqy")->where("id in ({$arr_string2})")->select();//查出城市
        $re=$model->table("yunaj_user")->order("id desc")->select();//查出所有用户
        $task=$model->where("createdbyid={$id}")->order("id desc")->limit($start*$num,$num)->select();
        $jsuser="";
        $cx="";
        for($i=0;$i<count($task);$i++){
            if($task[$i]['checkrange']==1){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,b.name,ps.name psname,ps.id pid,x.id xid")->
                join("yunaj_build b"," b.id=y.ywid")->
                join("yunaj_project ps"," ps.id=b.proj_id")->
                join("yunaj_xzqy x"," x.id=ps.xzqy_id")->
                where("y.taskid={$task[$i]['id']}")->select();
//                echo $model->getLastSql();
//                exit;
            }else if($task[$i]['checkrange']==2){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,p.name,x.id xid")->
                join("yunaj_project p"," p.id=y.ywid")->
                join("yunaj_xzqy x"," x.id=p.xzqy_id")->
                where("y.taskid={$task[$i]['id']}")->select();
            }else if($task[$i]['checkrange']==3){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,x.name")->
                join("yunaj_xzqy x"," x.id=y.ywid")->
                where("y.taskid={$task[$i]['id']}")->select();
            }
            $jsuser[]=$model->table("yunaj_task2czr c")->field("c.*,u.name")->
            join("yunaj_user u"," u.id=c.czrid")->
            where("c.taskid={$task[$i]['id']}")->select();//查出城市
        }
//        $task=$model->table("yunaj_taskset t")->field("t.*,c.type,c.czrid,u.name uname")->
//        join("yunaj_task2czr c"," c.taskid=t.createdbyid")->
//        join("yunaj_user u"," u.id=c.czrid")->
//        order("id desc")->limit($start*$num,$num)->select();//查出所有任务
        $count=$model->where("createdbyid={$id}")->count();
        $this->assign("res", $res);
        $this->assign("re", $re);
        $this->assign("task", $task);
        $this->assign("jsuser", $jsuser);
        $this->assign("cx", $cx);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign('pageCount',$pageCount);
        $this->assign('ct',$ct);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        return $this->fetch("task/tk1");
    }
//分页
    function taskPage(){
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
       
        $id=session("uid");
        $model = model("Taskset");
        $mh=input("post.mh");
        $sta=input("post.ks");
        $en=input("post.js");
        $m="";
        $tm="";
        if($mh==""){
            $m="";
        }else{
            $mh=trim($mh);
            $m="AND ( name like '%{$mh}%')";
        }
        if($en!="" && $sta!=""){
            $tm="AND bgndate>='{$sta}' AND enddate<='{$en}'";
        }else{
            $tm="";
        }
        $task=$model->where("createdbyid={$id} {$tm} {$m}")->order("id desc")->limit($start*$num,$num)->select();
//        echo $model->getLastSql();
//        exit;
        $jsuser="";
        $cx="";
        for($i=0;$i<count($task);$i++){
            if($task[$i]['checkrange']==1){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,b.name,ps.name psname,ps.id pid")->
                join("yunaj_build b"," b.id=y.ywid")->
                join("yunaj_project ps"," ps.id=b.proj_id")->
                where("y.taskid={$task[$i]['id']}")->select();
//                echo $model->getLastSql();
//                exit;
            }else if($task[$i]['checkrange']==2){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,p.name")->
                join("yunaj_project p"," p.id=y.ywid")->
                where("y.taskid={$task[$i]['id']}")->select();
            }else if($task[$i]['checkrange']==3){
                $cx[] = $model->table("yunaj_task2ywmx y")->field("y.*,x.name")->
                join("yunaj_xzqy x"," x.id=y.ywid")->
                where("y.taskid={$task[$i]['id']}")->select();
            }
            $jsuser[]=$model->table("yunaj_task2czr c")->field("c.*,u.name")->
            join("yunaj_user u"," u.id=c.czrid")->
            where("c.taskid={$task[$i]['id']}")->select();//查出城市
        }
//        $task=$model->table("yunaj_taskset t")->field("t.*,c.type,c.czrid,u.name uname")->
//        join("yunaj_task2czr c"," c.taskid=t.createdbyid")->
//        join("yunaj_user u"," u.id=c.czrid")->
//        order("id desc")->limit($start*$num,$num)->select();//查出所有任务
        $count=$model->where("createdbyid={$id}  {$tm} {$m}")->count();
        $this->assign("task", $task);
        $this->assign("jsuser", $jsuser);
        $this->assign("cx", $cx);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        return $this->fetch("task/tk2");
    }
    //获取区域
    function getQy(){
        $id=input("post.id");
        $model = model("Taskset");
        $res=$model->table("yunaj_xzqy")->where("parent_id={$id}")->select();
        echo json_encode($res);
    }
    //获取小区
    function getXq(){
        $id=input("post.id");
        $model = model("Taskset");
        $res=$model->table("yunaj_project")->where("xzqy_id={$id}")->select();
        echo json_encode($res);
    }

    //获取楼栋
    function getLd(){
        $id=input("post.id");
        $model = model("Taskset");
        $res=$model->table("yunaj_build")->where("proj_id={$id}")->select();
        echo json_encode($res);
    }

    //用户模糊查询
    function tkUser(){
        $va=input("post.va");
        $model = model("Taskset");
        if($va!=""){
            $m="AND (name like '%{$va}%' or code like '%{$va}%' or mobile like '%{$va}%')";
        }else{
            $m="";
        }
        $re=$model->table("yunaj_user")->where("1=1 {$m}")->select();
        $this->assign("re",$re);
        echo $this->fetch("task/tkuser");
    }

    //新增任务到数据库
    function addTask(){
        $id=session("uid");
        date_default_timezone_set("prc");
        $cjsj=time();
        $tid=input("post.taskid");//任务名
        $name=input("post.name");//任务名
        $start=input("post.start");//开始时间
        $end=input("post.end");//结束时间
        $ct=input("post.ct");//城市
        $qy=input("post.qy");//区域
        $xq=input("post.xq");//小区街道
        $lid=input("post.lid/a");//楼栋id数组
        $jid=input("post.jid/a");//检查人id数组
        $sid=input("post.sid/a");//审核人id数组
        $cjid=session("uid");
        $model = model("Taskset");
        $t="";
        if((int)$tid==0){
            $t="";
        }else{
            $t=$tid;
        }
        $rid=$model->field("id")->where("(bgndate>={$start} AND enddate<={$end}) OR (bgndate<={$start} AND enddate>={$end}) OR (bgndate>={$start} AND bgndate<={$end}) OR (enddate>={$start} AND enddate<={$end}) AND status='1'")->select();//查询上传的时间段有没有其他任务
        $ywid="";
        if($rid){//如果有执行下面的操作，没有执行else里面的插入操作
            for($i=0;$i<count($rid);$i++){//循环取出已存在任务中的所有楼栋
                if($rid[$i]['id']==$t){
                    continue;
                }else{
                    $tp=$model->table("yunaj_task2ywmx")->where("taskid={$rid[$i]['id']}")->select();
//                echo json_encode(tp);
//                exit;
//                echo  $tp[0]['type'];
                    if($tp[0]['type']==1){//type为1，楼栋
//                    echo 1;
//                    exit;
                        for($k=0;$k<count($tp);$k++){
                            $ywid[]=$tp[$k]['ywid'];
                        }
                    }else if($tp[0]['type']==2){//type为2，小区街道
//                    echo 2;
//                    exit;
                        $bid=$model->table("yunaj_build")->field("id")->where("proj_id={$tp[0]['ywid']}")->select();
                        for($k=0;$k<count($bid);$k++){
                            $ywid[]=$bid[$k]['id'];
                        }
                    }else if($tp[0]['type']==3){////type为3，区域
                        $pid=$model->table("yunaj_project")->field("id")->where("xzqy_id={$tp[0]['ywid']}")->select();
                        $arr="";
                        for($k=0;$k<count($pid);$k++){
                            $arr[]=$pid[$k]['id'];
                        }
                        $arr_string=implode(",",$arr);
                        $bid=$model->table("yunaj_build")->field("id")->where("proj_id in({$arr_string})")->select();
                        for($k=0;$k<count($bid);$k++){
                            $ywid[]=$bid[$k]['id'];
                        }
//                    echo 3;
//                    exit;
                    }
                }
            }
            $ywid=array_unique($ywid);//去除数组中重复的id
            $ywid=array_merge($ywid);//重新排列数组下标
//            echo json_encode($ywid);
//            echo json_encode($lid);
//            exit;
            $error="";//已存在的楼栋数组
            if($lid){//从上传的数据查出楼栋，再和同时间段的其他任务楼栋对比，取出重复的楼栋id
                for($i=0;$i<count($lid);$i++){
                    if(in_array($lid[$i],$ywid)){
                        $error[]=$lid[$i];
                    }
                }
            }elseif($xq!="" && $lid=="" ){
                $bid=$model->table("yunaj_build")->field("id")->where("proj_id={$xq}")->select();
                for($i=0;$i<count($bid);$i++){
                    if(in_array($bid[$i]['id'],$ywid)){
                        $error[]=$bid[$i]['id'];
                    }
                }
            }elseif ($qy!="" && $xq=="" && $lid==""){
                $pid1=$model->table("yunaj_project")->field("id")->where("xzqy_id={$qy}")->select();
                $arr1="";
                for($i=0;$i<count($pid1);$i++){
                    $arr1[]=$pid1[$i]['id'];
                }
                $arr_string1=implode(",",$arr1);
                $bid=$model->table("yunaj_build")->field("id")->where("proj_id in({$arr_string1})")->select();
                for($i=0;$i<count($bid);$i++){
                    if(in_array($bid[$i]['id'],$ywid)){
                        $error[]=$bid[$i]['id'];
                    }
                }
            }
//            echo json_encode($error);
//            exit;
            if($error){//判断有没有已存在的楼栋
                $str="";
                if($lid){//从上传的数据查出楼栋，再和同时间段的其他任务楼栋对比，取出重复的楼栋id
                    $arr2="";
                    for($i=0;$i<count($error);$i++){
                        $arr2[]=$error[$i];
                    }
                    $arr_string2=implode(",",$arr2);
                    $bname=$model->table("yunaj_build")->field("name")->where("id in({$arr_string2})")->select();
//                    echo json_encode($bname);
//                    exit;
                    $pname=$model->table("yunaj_project")->field("name")->where("id ={$xq}")->select();
                    $str=$pname[0]['name']."中的(";
                    for($i=0;$i<count($bname);$i++){
                        $str.=$bname[$i]['name'];
                    }
                    $str.="),已在其他任务中存在，请修改后再提交！";
                }elseif($xq!="" && $lid==""){//小区街道
                    $arr2="";
                    for($i=0;$i<count($error);$i++){
                        $arr2[]=$error[$i];
                    }
                    $arr_string2=implode(",",$arr2);
                    $bname=$model->table("yunaj_build")->field("name")->where("id in({$arr_string2})")->select();
//                    echo json_encode($bname);
//                    exit;
                    $pname=$model->table("yunaj_project")->field("name")->where("id ={$xq}")->select();
                    $str=$pname[0]['name']."中的(";
                    for($i=0;$i<count($bname);$i++){
                        $str.=$bname[$i]['name'];
                    }
                    $str.="),已在其他任务中存在，请修改后再提交！";
                }elseif ($qy!="" && $xq=="" && $lid==""){//区域
                    $arr2="";
                    for($i=0;$i<count($error);$i++){
                        $arr2[]=$error[$i];
                    }
                    $arr_string2=implode(",",$arr2);
                    $pid=$model->table("yunaj_build")->field("proj_id")->where("id in({$arr_string2})")->select();
                    $bname=$model->table("yunaj_build")->field("proj_id,name")->where("id in({$arr_string2})")->select();
                    $pid=array_unique($pid);
                    $pid=array_merge($pid);
                    $arr3="";
                    for($i=0;$i<count($pid);$i++){
                        $arr3[]=$pid[$i]['proj_id'];
                    }
                    $arr_string3=implode(",",$arr3);
                    $pname=$model->table("yunaj_project")->field("name,id")->where("id in({$arr_string3})")->select();
                    $xname=$model->table("yunaj_xzqy")->field("name")->where("id ={$qy}")->select();
                    $str=$xname[0]['name']."中的";
//                    echo json_encode($pname);
//                    exit;
                    for($i=0;$i<count($pname);$i++){
                            $str.=$pname[$i]['name']."(";
                        for($k=0;$k<count($bname);$k++){
                            if($bname[$k]['proj_id']==$pname[$i]['id']){
                                $str.=$bname[$k]['name'];
                            }
                            if($k==count($bname)-1){
                                $str.=")、";
                            }
                        }
                    }
                    $str.=",已在其他任务中存在，请修改后再提交！";
                }
                echo $str;
                exit;
            }else{
                $fw="";//范围类型
                if($lid){//如果上传的楼栋id不为空，范围则为1
                    $fw=1;
                }elseif($xq!="" && $lid==""){//楼栋为空，小区街道不为空，范围为2
                    $fw=2;
                }elseif ($qy!="" && $xq=="" && $lid==""){//只有区域部位空，则为3
                    $fw=3;
                }
                if($tid==0){//如果tid为0执行新增操作，
                    $in=$model->execute("insert into yunaj_taskset VALUES (null,'{$name}','{$start}','{$end}','{$fw}','{$cjsj}','{$cjid}','1','')");//把数据插入任务表
                    if($in){//插入成功后的操作
                        $tkid=$model->getLastInsID();//取出插入后的id
                        if($fw==1){//判断范围，执行
                            for($i=0;$i<count($lid);$i++){
                                $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$lid[$i]}')");
                            }
                        }elseif($fw==2){//判断范围，执行
                            $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$xq}')");
                        }elseif($fw==3){//判断范围，执行
                            $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$qy}')");
                        }
                        for($i=0;$i<count($jid);$i++){
                            $in2=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tkid}','0','{$jid[$i]}')");
                        }
                        for($i=0;$i<count($sid);$i++){
                            $in3=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tkid}','1','{$sid[$i]}')");
                        }
                        echo 'true';
                        exit;
                    }else{//插入失败后的操作
                        echo 'false';
                        exit;
                    }
                }else{//为其他值执行修改操作
                    $up=$model->execute("update yunaj_taskset set name='{$name}',bgndate='{$start}',enddate='{$end}',checkrange='{$fw}' WHERE    id='{$tid}'");//把数据插入任务表
                    $model->table("yunaj_task2ywmx")->where("taskid='{$tid}'")->delete();
                    $model->table("yunaj_task2czr")->where("taskid='{$tid}'")->delete();
//                    echo $model->getLastSql();
//                    exit;
                    if($fw==1){//判断范围，执行
                        for($i=0;$i<count($lid);$i++){
                            $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$lid[$i]}')");
                        }
                    }elseif($fw==2){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$xq}')");
                    }elseif($fw==3){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$qy}')");
                    }
                    for($i=0;$i<count($jid);$i++){
                        $in2=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tid}','0','{$jid[$i]}')");
                    }
                    for($i=0;$i<count($sid);$i++){
                        $in3=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tid}','1','{$sid[$i]}')");
                    }
                    echo 'true1';
                    exit;
                }
            }
        }else{
            $fw="";//范围类型
            if($lid){//如果上传的楼栋id不为空，范围则为1
                 $fw=1;
            }elseif($xq!="" && $lid==""){//楼栋为空，小区街道不为空，范围为2
                $fw=2;
            }elseif ($qy!="" && $xq=="" && $lid==""){//只有区域部位空，则为3
                $fw=3;
            }
            if($tid==0){//如果tid为0执行新增操作，
                $in=$model->execute("insert into yunaj_taskset VALUES (null,'{$name}','{$start}','{$end}','{$fw}','{$cjsj}','{$cjid}','1', null)");//把数据插入任务表
                if($in){//插入成功后的操作
                    $tkid=$model->getLastInsID();//取出插入后的id
                    if($fw==1){//判断范围，执行
                        for($i=0;$i<count($lid);$i++){
                            $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$lid[$i]}')");
                        }
                    }elseif($fw==2){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$xq}')");
                    }elseif($fw==3){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tkid}','{$qy}')");
                    }
                    for($i=0;$i<count($jid);$i++){
                        $in2=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tkid}','0','{$jid[$i]}')");
                    }
                    for($i=0;$i<count($sid);$i++){
                        $in3=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tkid}','1','{$sid[$i]}')");
                    }
                    echo 'true';
                    exit;
                }else{//插入失败后的操作
                    echo 'false';
                    exit;
                }
            }else{//为其他值执行修改操作
                $up=$model->execute("update yunaj_taskset set name='{$name}',bgndate='{$start}',enddate='{$end}',checkrange='{$fw}' WHERE    id='{$tid}'");//把数据插入任务表
                    $model->table("yunaj_task2ywmx")->where("taskid='{$tid}'")->delete();
                    $model->table("yunaj_task2czr")->where("taskid='{$tid}'")->delete();
//                echo $model->getLastSql();
//                exit;
                    if($fw==1){//判断范围，执行
                        for($i=0;$i<count($lid);$i++){
                            $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$lid[$i]}')");
                        }
                    }elseif($fw==2){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$xq}')");
                    }elseif($fw==3){//判断范围，执行
                        $in1=$model->execute("insert into yunaj_task2ywmx VALUES (null,'{$fw}','{$tid}','{$qy}')");
                    }
                    for($i=0;$i<count($jid);$i++){
                        $in2=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tid}','0','{$jid[$i]}')");
                    }
                    for($i=0;$i<count($sid);$i++){
                        $in3=$model->execute("insert into yunaj_task2czr VALUES (null,'{$tid}','1','{$sid[$i]}')");
                    }
                    echo 'true1';
                    exit;
            }

        }

    }


    //作废
    function abandoned(){
        $id=input("post.id");//审核人id数组
        $model = model("Taskset");
        $res=$model->execute("update yunaj_taskset set status='0' WHERE id={$id}");
        echo $res?"true":"false";
    }
}