<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26 0026
 * Time: 14:35
 */

namespace app\home\controller;
use think\Controller;

class User extends Base
{
    //获取用户
   public function getUser(){
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
       $model=model('Fun');
       $tname=$_REQUEST['tname'];
//               $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
       $res = $this->getFun();
       $c=$model->table("yunaj_user")->select();
       $re=$model->table("yunaj_user")->order("id desc")->limit(0,$num)->select();
       $count=count($c);
       $pageCount = (int)$count;
       $page=$start+1;
       $pageCount = ceil($pageCount / $num);
       $this->assign("re",$re);
       $this->assign("res",$res);
       $this->assign('pageCount',$pageCount);
       $this->assign('count',$count);
       $this->assign('page',$page);
       $this->assign('num',$num);
       $this->assign('start',$start);
       $this->assign('tname',$tname);
       return  $this->fetch("user/user");

   }
    //用户分页
    public function userPage(){
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
        $re=$model->where($m)->order("id desc")->limit($start*$num,$num)->select();
        $count=count($c);
        $pageCount = (int)$count;
        $page=$start+1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("re",$re);
        $this->assign('pageCount',$pageCount);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('num',$num);
        $this->assign('start',$start);
        $this->assign('mh',$mh);
        echo  $this->fetch("user/userpage");
    }

    //新增用户
    function addUser(){
        $model=model('User');
        date_default_timezone_set("prc");
        $pwd=input("post.password");
        $pwd=md5($pwd);
        $times=time();
        $data['name']=input("post.username");
        $data['code']=input("post.code");
        $data['mobile']=input("post.phone");
        $data['pwd']=$pwd;
        $data['createdate']=$times;
        $id=$model->field("id")->where("mobile='{$data['mobile']}' OR code='{$data['code']}'")->select();
        if($id){
            echo 'false';
        }else{
            $res=$model->save($data);
            echo  $res?"true":"false";
        }
    }
    
    //账号启用禁用
    function userSwitch(){
        $model=model('User');
        $id=input("post.id");
        $data['is_Enable']=input("post.enable");
        $res=$model->where("id='{$id}'")->update($data);
        echo  $res?"true":"false";
    }

    //修改用户信息
    function updateUser(){
        $model=model('User');
        $uid=input("post.u_id");
        $data['name']=input("post.username");
        $data['code']=input("post.code");
        $data['mobile']=input("post.phone");
        $mm=input("post.pwd");
        $m="";
        if($mm!=""){
            $data['pwd']=md5($mm);
            $m="AND pwd='{$data['pwd']}'";
        }else{
            $m="";
        }
        $r=$model->where("name='{$data['name']}' AND code='{$data['code']}' AND mobile='{$data['mobile']}' AND id='{$uid}' '{$m}'")->select();
//        echo $model->getLastSql();
//        echo json_encode($r);
//        exit;
        if($r){
            echo "false";
            exit;
        }
        $res=$model->where("id='{$uid}'")->update($data);
        echo $res?"true":"false1";
    }

    //导出用户数据
    function checkExcel(){
       
        $model=model("User");
        $res=$model->select();
        if(!$res){
            echo "false";
            exit;
        }
        $filename =  "用户".date('YmdHis').".xls";
        vendor("PHPExcel.PHPExcel");
    
        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        for ($k = 1; $k <= count($res) + 1; $k++) {
            if ($k == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
                $objPHPExcel->getActiveSheet()->setCellValue('B1', '用户名称');
                $objPHPExcel->getActiveSheet()->setCellValue('C1', '用户代码');
                $objPHPExcel->getActiveSheet()->setCellValue('D1', '手机号码');
                $objPHPExcel->getActiveSheet()->setCellValue('E1', '账号状态');
                $objPHPExcel->getActiveSheet()->setCellValue('F1', '录入时间');
            } else {
                $f="";
                if($res[$k-2]['is_Enable']==1){
                    $f="启用";
                }else{
                    $f="未启用";
                }
                $times=date("Y-m-d H:i:s",$res[$k-2]['createdate']);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$k, $k-1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $res[$k-2]['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$k, $res[$k-2]['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$k, $res[$k-2]['mobile']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$k, $f);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$k, $times);
            }
        }
  
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
     
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;
    }

    //修改密码
    function udPwd(){
        $id=session("uid");
        $name=input("post.username");
        $yPwd=md5(input("post.yPwd"));
        $npwd=md5(input("post.nPwd"));
        $model=model("User");
        $re=$model->where("id='{$id}' AND pwd='{$yPwd}'")->select();
        if($re){
            $res=$model->execute("update yunaj_user set pwd='{$npwd}' WHERE id='{$id}'");
            if($res){
                $_SESSION=array();
                session_destroy();
                echo "true";
            }else{
                echo "false";
            }
        }else{
            echo "false1";
        }

    }

    //删除session
    function deleteSession(){
        $_SESSION=array();
        session_destroy();
    }
}