<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3 0003
 * Time: 15:20
 */

namespace app\home\controller;

use think\Controller;

class Initialization extends Base
{
    //显示用户初始化
    function show()
    {
        if (isset($_POST['start'])) {
            $start = $_POST['start'];
        } else {
            $start = 0;
        }
        if (isset($_POST['num'])) {
            $num = $_POST['num'];
        } else {
            $num = config("PAGE_NUM");
        }
        if ($start < 0) {
            $start = 0;
        }
        $model = model("Room");
        $tname = input("get.tname");
        //        $res=$model->table("yunaj_fun")->where("parent_id=0")->select();
        $res = $this->getFun();
        $ct = $model->table("yunaj_xzqy")->where("type=0")->select();
        $qy = $model->table("yunaj_xzqy")->where("type=1")->select();
        $xq = $model->table("yunaj_project")->select();
        $c=$model->count();
        $room=$model->table("yunaj_room r")->field("r.*,p.name pname,b.name bname,x.name xname,c.name cname,c1.name csname")->
        join("yunaj_project p","p.id=r.proj_id")->
        join("yunaj_xzqy x","x.id=p.xzqy_id")->
        join("yunaj_build b","b.id=r.bld_id")->
        join("yunaj_csdetail c","c.id=r.type","left")->
        join("yunaj_csdetail c1","c1.id=r.brand","left")->
        order("id desc")->limit($start*$num,$num)->select();
        $count=$c;
        $pageCount = (int)$count;
        $page = $start + 1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("res", $res);
        $this->assign("ct", $ct);
        $this->assign("qy", $qy);
        $this->assign("xq", $xq);
        $this->assign("room",$room);
        $this->assign('pageCount', $pageCount);
        $this->assign('count', $count);
        $this->assign('page', $page);
        $this->assign('num', $num);
        $this->assign('tname', $tname);
        $this->assign('start', $start);
        return $this->fetch("initialization/iitz1");
    }

    //分页
    function getPage(){
        if (isset($_POST['start'])) {
            $start = $_POST['start'];
        } else {
            $start = 0;
        }
        if (isset($_POST['num'])) {
            $num = $_POST['num'];
        } else {
            $num = config("PAGE_NUM");
        }
        if ($start < 0) {
            $start = 0;
        }
        $model = model("Room");
        $ct = input("post.ct");
        $qy = input("post.qy");
        $xq = input("post.xq");
        $va = input("post.va");
        $c="";
        $q="";
        $x="";
        $v="";
        if($ct=='全部'|| $ct==""){
            $c="";
            $q="";
            $x="";
        }else{
            $c="AND xr.id='{$ct}'";
            if($qy=="全部" || $qy==""){
                $q="";
                $x="";
            }else{
                $q="AND x.id='{$qy}'";
                if($xq=="全部" || $xq==""){
                    $x="";
                }else{
                    $x="AND p.id='{$xq}'";
                }
            }
        }
        if($va==""){
            $v="";
        }else{
            $v="AND (room like '%{$va}%' or cstcode like '%{$va}%')";
        }
        $con=$model->table("yunaj_room r")->field("r.id")->
        join("yunaj_project p","p.id=r.proj_id")->
        join("yunaj_xzqy x","x.id=p.xzqy_id")->
        join("yunaj_xzqy xr","xr.id=x.parent_id","left")->
        join("yunaj_build b","b.id=r.bld_id")->
        join("yunaj_csdetail c","c.id=r.type","left")->
        join("yunaj_csdetail c1","c1.id=r.brand","left")->
        where("1=1 {$c} {$q} {$x} {$v}")->select();
        $room=$model->table("yunaj_room r")->field("r.*,p.name pname,b.name bname,x.name xname,c.name cname,c1.name csname")->
        join("yunaj_project p","p.id=r.proj_id")->//小区
        join("yunaj_xzqy x","x.id=p.xzqy_id")->//区域
        join("yunaj_xzqy xr","xr.id=x.parent_id")->//城市
        join("yunaj_build b","b.id=r.bld_id")->
        join("yunaj_csdetail c","c.id=r.type","left")->
        join("yunaj_csdetail c1","c1.id=r.brand","left")->
        where("1=1 {$c} {$q} {$x} {$v}")->
        order("id desc")->limit($start*$num,$num)->select();
//        echo $model->getLastSql();
//        exit;
        $count=count($con);
        $pageCount = (int)$count;
        $page = $start + 1;
        $pageCount = ceil($pageCount / $num);
        $this->assign("room",$room);
        $this->assign('pageCount', $pageCount);
        $this->assign('count', $count);
        $this->assign('page', $page);
        $this->assign('num', $num);
        $this->assign('start', $start);
        return $this->fetch("initialization/iitz2");
    }

//导出excel模板
    function checkOut()
    {
        $filename = "用户初始化模板" . date('YmdHis') . ".xls";
//            iconv("UTF-8", "GB2312//IGNORE", $filename);
        vendor("PHPExcel.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_WHITE));//设置颜色为绿色
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(
            array(
                'font' => array(
                    'bold' => true
                ),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startcolor' => array(
                        'rgb' => '17A3FF'
                    ),
                    'endcolor' => array(
                        'rgb' => '17A3FF'
                    )
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);;
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '区域');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "小区/街道");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "楼栋");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '单元');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "楼层");
        $objPHPExcel->getActiveSheet()->setCellValue('F1', "房号");
        $objPHPExcel->getActiveSheet()->setCellValue('G1', "用户编号");
        $objPHPExcel->getActiveSheet()->setCellValue('H1', "用户姓名");
        $objPHPExcel->getActiveSheet()->setCellValue('I1', "联系电话");
        $objPHPExcel->getActiveSheet()->setCellValue('J1', "气表类型");
        $objPHPExcel->getActiveSheet()->setCellValue('K1', "气表品牌");
        $objPHPExcel->getActiveSheet()->setCellValue('L1', "进气方向");
        $objPHPExcel->getActiveSheet()->setCellValue('M1', "表底数");
//            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $filename = iconv("utf-8", "gb2312", $filename);
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/', $ua)) {
            $filename = str_replace('+', '%20', urlencode($filename));
        }
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }

    //导入excel
    function checkIn()
    {
        $file = request()->file('excel');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>1048576,'ext'=>'xls,xlsx','autoSub' => true])->move(ROOT_PATH . 'public' . DS . 'pc/excel');
        if ($info) {
        $path= str_replace("\\","/",$info->getSaveName());
//        $path='20170714/33f9ea228243e165d1b48176d662ece7.xls';
        $model=model('Room');
        $ren = array();//返回数据的数组
        //导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
//要导入的xls文件，位于根目录下的Public文件夹
        $arrs = explode(".", $path);//$info['savename']
        $e_type = $arrs[1];
        $filename = "./public/pc/excel/".$path;
//创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        if ($e_type == "xls") {
            //如果excel文件后缀名为.xls，导入这个类
            vendor("PHPExcel.Reader.Excel5");
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } else {
            //如果excel文件后缀名为.xlsx，导入这下类
            vendor("PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }
        $PHPExcel = $PHPReader->load($filename);
//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
//获取总列数
        $allColumn = $currentSheet->getHighestColumn();
//获取总行数
        $allRow = $currentSheet->getHighestRow();
        $pnum = array();
        $p = 0;
        //循环取出excel表中的所有用户编号
        for ($currentRow =2; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            $pnum[$p] = trim((string)$currentSheet->getCell("G" . $currentRow)->getValue());//取出所有用户编号
            $p++;
        }
        $unique_arr = array_unique($pnum);// 获取不重复数据的数组
        $repeat_arr = array_diff_assoc($pnum, $unique_arr);//通过不重复的数据找出重复的数据
        $txt="";
        $a=0;
        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
//    //从哪列开始，A表示第一列
            $a1=0;
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                $address = $currentColumn . $currentRow;
                $qy="";
                if ($currentColumn >='A' && $currentColumn <= 'G') {
                    if ($currentSheet->getCell("A".$currentRow)->getValue()!=null &&$currentSheet->getCell("B" . $currentRow)->getValue() != null && $currentSheet->getCell("C" . $currentRow)->getValue() != null && $currentSheet->getCell("D" . $currentRow)->getValue() != null && $currentSheet->getCell("E" . $currentRow)->getValue() != null && $currentSheet->getCell("F" . $currentRow)->getValue() != null && $currentSheet->getCell("G" . $currentRow)->getValue() != null) { //判断A-G数据是否为空，为空就加入异常数据
                        $name = (string)$currentSheet->getCell("A" . $currentRow)->getValue();
                        $qy = $model->table("yunaj_xzqy")->field("id")->where("name='{$name}'")->select();
                        if ($qy) {
                            $txt[$a][$a1] = (string)$currentSheet->getCell($address)->getValue();
                            $a1++;
                        }else{
                            array_push($repeat_arr, (string)$currentSheet->getCell("G" . $currentRow)->getValue());
                            break;
                        }
                    } else {
                        array_push($repeat_arr, (string)$currentSheet->getCell("G" . $currentRow)->getValue());
                        break;
                    }
                } else {
                    if ($currentSheet->getCell($address)->getValue() == null || $currentSheet->getCell($address)->getValue() == '') {
                        $txt[$a][$a1] = "";
                        $a1++;
                    } else {
                        $txt[$a][$a1] = (string)$currentSheet->getCell($address)->getValue();
                        $a1++;
                    }
                }

            }
            $a++;
        }//去除EXCEL表中正常数据
        if ($txt){
            $ren['room']="0";
            foreach ($txt as $key => $value) {
                foreach ($repeat_arr as $k => $v) {
                    if (in_array($v, $value)) unset($txt[$key]);
                }
            }//排除正常数据中重复数据
            $txt=array_merge($txt);//重新排序最后的正常数据
        }
        
        $ren['counterror']=count($repeat_arr);
        $repeat_arr=array_unique($repeat_arr);//去除异常数据中重复的编号
        $repeat_arr=array_merge($repeat_arr);//重新排序异常数据
        $er = array();
        if ($repeat_arr) { //当$repeat_arr不为空，导出异常数据到excel表
            $repeat_arr=array_merge($repeat_arr);//重新排序数组
            $er = array();
            $rp = 0;
            //                    echo json_encode($repeat_arr);
            //                    exit;
            for ($i = 0; $i < count($repeat_arr); $i++) {
                for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
                    //    //从哪列开始，A表示第一列
                    if ((string)$currentSheet->getCell("G" . $currentRow)->getValue() === $repeat_arr[$i]) {
                        $er[$rp][0] = (string)$currentSheet->getCell("A" . $currentRow)->getValue();
                        $er[$rp][1] = (string)$currentSheet->getCell("B" . $currentRow)->getValue();
                        $er[$rp][2] = (string)$currentSheet->getCell("C" . $currentRow)->getValue();
                        $er[$rp][3] = (string)$currentSheet->getCell("D" . $currentRow)->getValue();
                        $er[$rp][4] = (string)$currentSheet->getCell("E" . $currentRow)->getValue();
                        $er[$rp][5] = (string)$currentSheet->getCell("F" . $currentRow)->getValue();
                        $er[$rp][6] = (string)$currentSheet->getCell("G" . $currentRow)->getValue();
                        $er[$rp][7] = (string)$currentSheet->getCell("H" . $currentRow)->getValue();
                        $er[$rp][8] = (string)$currentSheet->getCell("I" . $currentRow)->getValue();
                        $er[$rp][9] = (string)$currentSheet->getCell("J" . $currentRow)->getValue();
                        $er[$rp][10] = (string)$currentSheet->getCell("K" . $currentRow)->getValue();
                        $er[$rp][11] = (string)$currentSheet->getCell("L" . $currentRow)->getValue();
                        $er[$rp][12] = (string)$currentSheet->getCell("M" . $currentRow)->getValue();
                        $rp++;
                    } else {
                        continue;
                    }
                }
            }//通过异常编号取出完整数组，到er数组
        }
        if($er){
            $PHPExcel->removeSheetByIndex(0);
//                        $msgWorkSheet = new \PHPExcel_Worksheet($PHPExcel, 'card_message'); //创建一个工作表
//                        $PHPExcel->addSheet($msgWorkSheet); //插入工作表
            $PHPExcel->createSheet();
            $PHPExcel->setActiveSheetIndex(); //切换到新创建的工作表
            $filename1 = "异常数据" . date('YmdHis') . ".xls";
            $PHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_WHITE));//设置颜色为绿色
            $PHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startcolor' => array(
                            'rgb' => '17A3FF'
                        ),
                        'endcolor' => array(
                            'rgb' => '17A3FF'
                        )
                    )
                )
            );
            $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);;
            $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
            $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
            $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
            $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
            $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
            $PHPExcel->getActiveSheet()->setCellValue('A1', '区域');
            $PHPExcel->getActiveSheet()->setCellValue('B1', "小区/街道");
            $PHPExcel->getActiveSheet()->setCellValue('C1', "楼栋");
            $PHPExcel->getActiveSheet()->setCellValue('D1', '单元');
            $PHPExcel->getActiveSheet()->setCellValue('E1', "楼层");
            $PHPExcel->getActiveSheet()->setCellValue('F1', "房号");
            $PHPExcel->getActiveSheet()->setCellValue('G1', "用户编号");
            $PHPExcel->getActiveSheet()->setCellValue('H1', "用户姓名");
            $PHPExcel->getActiveSheet()->setCellValue('I1', "联系电话");
            $PHPExcel->getActiveSheet()->setCellValue('J1', "气表类型");
            $PHPExcel->getActiveSheet()->setCellValue('K1', "气表品牌");
            $PHPExcel->getActiveSheet()->setCellValue('L1', "进气方向");
            $PHPExcel->getActiveSheet()->setCellValue('M1', "表底数");
            for ($i = 0; $i < count($er); $i++) {
                $PHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 2), $er[$i][0], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("B" . ($i + 2), $er[$i][1], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("C" . ($i + 2), $er[$i][2], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("D" . ($i + 2), $er[$i][3], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("E" . ($i + 2), $er[$i][4], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("F" . ($i + 2), $er[$i][5], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("G" . ($i + 2), $er[$i][6], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("H" . ($i + 2), $er[$i][7], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("I" . ($i + 2), $er[$i][8], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("J" . ($i + 2), $er[$i][9], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("K" . ($i + 2), $er[$i][10], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("L" . ($i + 2), $er[$i][11], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValue("M" . ($i + 2), $er[$i][12]);
            }
            ob_end_clean();
            $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
// 输出Excel表格到浏览器下载
//                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//                        header('Content-Disposition: attachment;filename='.$filename1);
//                        header('Cache-Control: max-age=0');
            $filePath = './public/pc/excel/error/' . $filename1;
            $filePath = iconv("utf-8", "gb2312", $filePath);
            $objWriter->save($filePath);
            $filePath = iconv("gb2312", "utf-8", $filePath);//json不能返回GBK的数据。所以必须再转一次码
            $ren['errorpath'] = $filePath;
        }else{
            $ren['errorpath']="";
        }//把异常数据存入EXCEL，把保存路径存入数组，最后一起返回

        //把正常数据存入数据库
        $room_count=0;
        if($txt){
            for($i=0;$i<count($txt);$i++){
                $proj_id="";
                $bld_id="";
                $code="";
                $tp="";
                $br="";
                $pid=$model->table("yunaj_project")->field("id")->where("name='{$txt[$i][1]}'")->select();
                if($pid){
                    $proj_id=$pid[0]['id'];
                    $bid=$model->table("yunaj_build")->field("id")->where("proj_id={$proj_id} AND name='{$txt[$i][2]}'")->select();
                    if($bid){
                        $bld_id= $bid[0]['id'];
                    }else{
                        $code=preg_replace('/\D/s', '', $txt[$i][2]);
                        $bld_id=$model->execute("insert into yunaj_build VALUES (null,{$proj_id},'{$txt[$i][2]}',{$code})");
                        $bld_id=$model->getlastInsID();
                    }
                }else{
                    $xid=$model->table("yunaj_xzqy")->field("id")->where("name='{$txt[$i][0]}'")->select();
                    $proj_id=$model->execute("insert into yunaj_project VALUES (null,{$xid[0]['id']},'{$txt[$i][1]}',null)");
                    $proj_id=$model->getlastInsID();
                    $code=preg_replace('/\D/s', '', $txt[$i][2]);
                    $bld_id=$model->execute("insert into yunaj_build VALUES (null,{$proj_id},'{$txt[$i][2]}',{$code})");
                    $bld_id=$model->getlastInsID();
                }
                if($txt[$i][9]=="" || $txt[$i][9]==null){
                    $tp="";
                }else{
                    $csid=$model->table("yunaj_csdetail")->field("id")->where("name='{$txt[$i][9]}'")->select();
                    if($csid){
                        $tp=$csid[0]['id'];
                    }else{
                        $cdid=$model->execute("insert into yunaj_csdetail VALUES (null,2,'{$txt[$i][9]}')");
                        $tp=$model->getlastInsID();
                    }
                }
                if($txt[$i][10]=="" || $txt[$i][10]==null){
                    $br="";
                }else{
                    $cid=$model->table("yunaj_csdetail")->field("id")->where("name='{$txt[$i][10]}'")->select();
                    if($cid){
                        $br=$cid[0]['id'];
                    }else{
                        $c_id=$model->execute("insert into yunaj_csdetail VALUES (null,1,'{$txt[$i][10]}')");
                        $br=$model->getlastInsID();
                    }
                }
                $fj=$txt[$i][4].$txt[$i][5];
                $r_id=$model->table("yunaj_room")->field("id")->where("proj_id={$proj_id} AND cstcode='{$txt[$i][6]}'")->select();
                if($r_id){
                    $rid=$model->execute("update yunaj_room set bld_id={$bld_id},unit={$txt[$i][3]},floor={$txt[$i][4]},no='{$txt[$i][5]}',room='{$fj}',cstname='{$txt[$i][7]}',telphone='{$txt[$i][8]}',type='{$tp}',brand='{$br}',direction='{$txt[$i][11]}',basenumber={$txt[$i][12]} where id='{$r_id[0]['id']}'");
                    if($rid){
                        $room_count++;
                    }
                }else{
                    $rid=$model->execute("insert into yunaj_room VALUES (null,{$proj_id},{$bld_id},{$txt[$i][3]},{$txt[$i][4]},'{$txt[$i][5]}','{$fj}','{$txt[$i][6]}','{$txt[$i][7]}','{$txt[$i][8]}','{$tp}','{$br}','{$txt[$i][11]}','{$txt[$i][12]}',null)");
                    if($rid){
                        $room_count++;
                    }
                }

            }
            $ren['room']=$room_count;
        }else{
            $ren['room']="0";
        }
        echo json_encode($ren);
        exit;
        } else {
            // 上传失败获取错误信息
            echo "false";
            exit;
        }
    }

    //删除数据
    function deleteSj(){
        $model = model("Room");
        $id = input("post.id");
        $pd=$model->table("yunaj_checkinfo")->where("room_id={$id}")->select();
        if($pd){
            echo "false";
            exit;
        }
        $res=$model->where("id={$id}")->delete();
        echo $res?"true":"false";
    }

    //修改数据
    function updateIu(){
        $model = model("Room");
        $bh=input("post.bh");//用户编号
        $mz=input("post.mz");//名字
        $dh=input("post.dh");//电话
        $lx=input("post.lx");//气表类型
        $pp=input("post.pp");//气表品牌
        $bds=input("post.bds");//表底数
        $fx=input("post.fx");//方向
        $id=input("post.rf");//记录的id
        $br="";
        $tp="";
        $q=$model->field("proj_id")->where("id='{$id}'")->select();
        $xz=$model->table("yunaj_project")->field("xzqy_id")->where("id='{$q[0]['proj_id']}'")->select();
        $qs=$model->table("yunaj_room r")->field("r.id")->
        join("yunaj_project p","p.id=r.proj_id")->
        join("yunaj_xzqy x","x.id=p.xzqy_id")->
        where("x.id='{$xz[0]['xzqy_id']}' AND r.cstcode='{$bh}' AND r.id<>'{$id}'")->select();
        if($qs){
            echo "false4";
            exit;
        }
        $csid=$model->table("yunaj_csdetail")->field("id")->where("name='{$lx}'")->select();
        if($csid){
            $tp=$csid[0]['id'];
        }else{
            $cdid=$model->execute("insert into yunaj_csdetail VALUES (null,2,'{$lx}')");
            $tp=$model->getlastInsID();
        }
        $cid=$model->table("yunaj_csdetail")->field("id")->where("name='{$pp}'")->select();
        if($cid){
            $br=$cid[0]['id'];
        }else{
            $c_id=$model->execute("insert into yunaj_csdetail VALUES (null,1,'{$pp}')");
            $br=$model->getlastInsID();
        }
        $sql="update yunaj_room set cstcode='{$bh}',cstname='{$mz}',telphone='{$dh}',type='{$tp}',brand='{$br}',direction='{$fx}',basenumber='{$bds}' WHERE id='{$id}'";
        $res=$model->execute($sql);
        echo $res?"true":"false";


    }
}