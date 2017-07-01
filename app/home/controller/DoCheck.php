<?php
/**
 * 检查执行控制器 FOR 未检查列表
 * 
 */

namespace app\home\controller;

use think\Loader; // 引入Loader类
// use llf\PHPExcel\PHPExcel; 木有命名空间不支持这玩意儿

class DoCheck extends Base
{
    /**
     * 实例化模型
     * 
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->xzqy = model('Xzqy');
        $this->xq = model('Project');
        $this->room = model('Room');
        $this->task = model('Taskset');
        $this->cs = model('Ywcs'); // 业务参数模型
        $this->check = model('Checkinfo');
        $this->checkPro = model('Checkproblem'); // 检查问题记录表模型
        $this->photo = model('Checkphoto'); // 检查记录照片表模型
    }
    
    /**
     * 未检查列表
     * 
     */
    public function index()
    {
        // 获取任务列表
        $taskList = $this->task->getTaskList();
        $this->assign('taskList', $taskList);
        
        // 通过任务条件
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->notCheckList('', $task_id);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
        
        $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
        
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq);
        
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
            
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', $city_id);
            $myData['area'] = $getArea; // 取回区域数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
        
        // 通过区域id查小区
        if (input('?post.area_id')){
            $area_id = input('post.area_id/d');
            $getXq = $this->xq->getXqByAid($area_id);
            
            // 点击区域后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', '', $area_id);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
        
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
            
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', '', '', $xq_id);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
        
        // 按房号或卡号搜索
        if (input('?get.num')){
            
            // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $row = 10
            $num = input('get.num');
            $listData = $this->room->notCheckList('', '', '', '', '', '', $num);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
        
        $listData = $this->room->notCheckList();
        /* $this->assign('listData', $listData); */
        $this->assign('count', $listData['count']); // 总条数
        $this->assign('pageNum', $listData['pageNum']); // 总页数
        $this->assign('listData', $listData['list']); // 首次数据       
        
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        
        // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
    
    // 分页
    public function toPage()
    {
        // 有状态码情况
        if (input('?post.status')){
            $curr = input('post.page/d'); // 第几页
            $status = input('post.status'); // 审核状态
            if (input('?post.num')){ // 搜索功能逻辑上优先级最高
                $num = input('post.num');
                $listData = $this->room->notCheckList($curr, '', '', '', '', false, $num, $status);
                return json_encode($listData['list']);
            }
            if (input('?post.task_id')){ // 任务优先级其次
                $task_id = input('post.task_id');
                $listData = $this->room->notCheckList($curr, $task_id, '', '', '', false, '', $status);
                return json_encode($listData['list']);
            }
            if (input('?post.city_id')){
                $city_id = input('post.city_id');
                $listData = $this->room->notCheckList($curr, '', $city_id, '', '', false, '', $status);
                return json_encode($listData['list']);
            }
            
            if (input('?post.area_id')){
                $area_id = input('post.area_id');
                $listData = $this->room->notCheckList($curr, '', '', $area_id, '', false, '', $status);
                return json_encode($listData['list']);
            }
            
            if (input('?post.xq_id')){
                $xq_id = input('post.xq_id/d');
                $listData = $this->room->notCheckList($curr, '', '', '', $xq_id, false, '', $status);
                return json_encode($listData['list']);
            }
            
            if (input('?post.page')){
                $curr = input('post.page/d');
                $listData = $this->room->notCheckList($curr, '', '', '', '', false, '', $status);
                return json_encode($listData['list']);
            }
        }
        
        // 无状态情况，即待检查列表
        if (input('?post.num')){ // 搜索功能逻辑上优先级最高
            $curr = input('post.page/d');
            $num = input('post.num');
            $listData = $this->room->notCheckList($curr, '', '', '', '', '', $num);
            return json_encode($listData['list']);
        }
        if (input('?post.task_id')){ // 任务优先级其次
            $curr = input('post.page/d');
            $task_id = input('post.task_id');
            $listData = $this->room->notCheckList($curr, $task_id);
//             p($listData);
            return json_encode($listData['list']);
        }
        if (input('?post.city_id')){
            $curr = input('post.page/d');
            $city_id = input('post.city_id');
            $listData = $this->room->notCheckList($curr, '', $city_id);
            return json_encode($listData['list']);
        }
        
        if (input('?post.area_id')){
            $curr = input('post.page/d');
            $area_id = input('post.area_id');
            $listData = $this->room->notCheckList($curr, '', '', $area_id);
            return json_encode($listData['list']);
        }
        
        if (input('?post.xq_id')){
            $curr = input('post.page/d');
            $xq_id = input('post.xq_id/d');
            $listData = $this->room->notCheckList($curr, '', '', '', $xq_id);
            return json_encode($listData['list']);
        }
        
        if (input('?post.page')){
            $curr = input('post.page/d');
            $listData = $this->room->notCheckList($curr);
            return json_encode($listData['list']);
        }
    }
    
    /**
     * 待审核列表
     *
     */
    public function wait()
    {
        $status = 0; // 状态0，待审核
        // 获取任务列表
        $taskList = $this->task->getTaskList();
        $this->assign('taskList', $taskList);
    
        // 通过任务条件
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 10
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->notCheckList('', $task_id, '', '', '', false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
    
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq);
    
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
    
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', $city_id, '', '', false, '', $status);
            $myData['area'] = $getArea; // 取回区域数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        // 通过区域id查小区
        if (input('?post.area_id')){
            $area_id = input('post.area_id/d');
            $getXq = $this->xq->getXqByAid($area_id);
    
            // 点击区域后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', '', $area_id, '', false, '', $status);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
    
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList('', '', '', '', $xq_id, false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        // 按房号或卡号搜索
        if (input('?get.num')){
            $num = input('get.num');
            $listData = $this->room->notCheckList('', '', '', '', '', false, $num, $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        $listData = $this->room->notCheckList(1, '', '', '', '', false, '', $status);
        $this->assign('count', $listData['count']); // 总条数
        $this->assign('pageNum', $listData['pageNum']); // 总页数
        $this->assign('listData', $listData['list']); // 首次数据
    
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        $this->assign('type', $type);
        $this->assign('brand', $brand);
    
        // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res);
    
        return $this->fetch();
    }
    
    // 编辑检查记录 - 待审核以及未通过审核的，对应的检查者可以编辑
    public function editLog()
    {
        $check_id = input('get.check_id/d');
        
        // 获取房间以及检查人信息
        $roomInfo = $this->room->getCheckInfo($check_id);
        $this->assign('roomInfo', $roomInfo);
//         p($roomInfo);
        // 问题详情
        $toGetPro = $this->checkPro->toGetPro($check_id);
        $this->assign('toGetPro', $toGetPro);
//         p($toGetPro);
        
        // 获取图片地址
        $imgUrl = $this->photo->getImgUrl($check_id);
        $this->assign('imgUrl', $imgUrl);
        
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        
        // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
    
    // 删除图片以及图片信息
    public function deleteImg()
    {
        $photo = model('Checkphoto'); // 检查记录照片表模型
        $url = input('get.nowImgUrl');
        $result = $photo->deleteImg($url);
        echo $result;exit;
    }
    
    public function test()
    {
        \Map::getLngLat('内江师范学院'); // 调用百度地图接口
    }
    
    // 导出数据为Excel
    public function toExcel()
    {
        Loader::import('llf.PHPExcel.PHPExcel');
        
        // 实例化对象
        $obj_excel = new \PHPExcel(); // 新建Excel表
        
        // 得到列表
        $result = [];
        
        // 存在状态码的数据 0待审核 1 已通过审核 -1 未通过审核
        if (input('?get.status')){
            
            // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 1
            $status = input('get.status/d');
            if (input('?get.num') && !empty(input('get.num'))){ // 模糊搜索，逻辑上优于其它
                $num = input('get.num');
                $result = $this->room->notCheckList('', '', '', '', '', true, $num, $status); // 参数true标识生成Excel数据
            } else if (input('?get.toTask') && !empty(input('get.toTask'))){ // 传任务id
                $task_id = input('get.toTask');
                $result = $this->room->notCheckList('', $task_id, '', '', '', true, '', $status);
            } else if (input('?get.toXqId') && !empty(input('get.toXqId'))){ // 小区
                $xq_id = input('get.toXqId/d');
                $result = $this->room->notCheckList('', '', '', '', $xq_id, true, '', $status); // 参数true标识生成Excel数据
            } else if (input('?get.toAreaId') && !empty(input('get.toAreaId'))){ // 区域
                $area_id = input('get.toAreaId/d');
                $result = $this->room->notCheckList('', '', '', $area_id, '', true, '', $status); // 参数true标识生成Excel数据
            } else if (input('?get.toCityId') && !empty(input('get.toCityId'))){ // 城市
                $city_id = input('get.toCityId/d');
                $result = $this->room->notCheckList('', '', $city_id, '', '', true, '', $status); // 参数true标识生成Excel数据
            } else { // 全部
                $result = $this->room->notCheckList('', '', '', '', '', true, '', $status); // 参数true标识生成Excel数据
            }
        } else {
            
            // 待检查列表数据
            if (input('?get.num') && !empty(input('get.num'))){ // 模糊搜索，逻辑上优于其它
                $num = input('get.num');
                $result = $this->room->notCheckList('', '', '', '', '', true, $num); // 参数true标识生成Excel数据
            } else if (input('?get.toTask') && !empty(input('get.toTask'))){ // 传任务id
                $task_id = input('get.toTask');
                $result = $this->room->notCheckList('', $task_id, '', '', '', true);
            } else if (input('?get.toXqId') && !empty(input('get.toXqId'))){ // 小区
                $xq_id = input('get.toXqId/d');
                $result = $this->room->notCheckList('', '', '', '', $xq_id, true); // 参数true标识生成Excel数据
            } else if (input('?get.toAreaId') && !empty(input('get.toAreaId'))){ // 区域
                $area_id = input('get.toAreaId/d');
                $result = $this->room->notCheckList('', '', '', $area_id, '', true); // 参数true标识生成Excel数据
            } else if (input('?get.toCityId') && !empty(input('get.toCityId'))){ // 城市
                $city_id = input('get.toCityId/d');
                $result = $this->room->notCheckList('', '', $city_id, '', '', true); // 参数true标识生成Excel数据
            } else { // 全部
                $result = $this->room->notCheckList('', '', '', '', '', true); // 参数true标识生成Excel数据
            }
        }
        
        // 设置excel的第一行的标题
        $obj_excel->getActiveSheet()->setCellValue( "A1", '序号', true );
        $obj_excel->getActiveSheet()->setCellValue( "B1", '地址', true );
        $obj_excel->getActiveSheet()->setCellValue( "C1", '房号', true );
        $obj_excel->getActiveSheet()->setCellValue( "D1", '用户编号', true );
        $obj_excel->getActiveSheet()->setCellValue( "E1", '姓名', true );
        $obj_excel->getActiveSheet()->setCellValue( "F1", '联系电话', true );
        $obj_excel->getActiveSheet()->setCellValue( "G1", '气表类型', true );
        $obj_excel->getActiveSheet()->setCellValue( "H1", '品牌', true );
        $obj_excel->getActiveSheet()->setCellValue( "I1", '进气方向', true );
        
        // 写入单元格
        foreach ($result as $k => $v){
            $num = $k + 2; // 比如'A'.$num即A2刚好是tbody的第一行
        
            $obj_excel->getActiveSheet()->setCellValue('A'.$num, $v['id']); // 写入单元格，标明位置和值
            $obj_excel->getActiveSheet()->setCellValue('B'.$num, $v['areaName'] . $v['xqName']);
            $obj_excel->getActiveSheet()->setCellValue('C'.$num, $v['dong'] . $v['unit'] . '单元' . $v['room']);
            $obj_excel->getActiveSheet()->setCellValue('D'.$num, $v['cstcode']);
            $obj_excel->getActiveSheet()->setCellValue('E'.$num, $v['cstname']);
            $obj_excel->getActiveSheet()->setCellValue('F'.$num, $v['telphone']);
            $obj_excel->getActiveSheet()->setCellValue('G'.$num, $v['typeName']);
            $obj_excel->getActiveSheet()->setCellValue('H'.$num, $v['brandName']);
            $obj_excel->getActiveSheet()->setCellValue('I'.$num, $v['direction']);        
        }
        
        // 创建表（默认sheet1）
        $obj_excel->createSheet();
        $obj_writer = \PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
        
        $file_name = date('Y-m-d-H-i-s',time()).'_燃气用户未检查列表.xlsx'; // 导出的文件名
        
        // 没有以下内容，excel直接输出，有则提示下载
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename='.$file_name);
        header('Cache-Control: max-age=0');
        
        $obj_writer->save('php://output'); // 保存excel
        // $obj_writer->save(__PC__ . '/excel/' . $file_name); // 保存excel
    }
    
    // 添加检查记录
    public function addLog()
    {
        if (!isset($_GET['cstcode']) || empty(input('get.cstcode'))){
            $this->error('非法访问！');
        }
        $cstcode = input('get.cstcode');
        $roomInfo = $this->room->getRoomInfo($cstcode);
//         p($roomInfo);
        $this->assign('roomInfo', $roomInfo);
        
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        $problem = $this->cs->getCs('检查问题'); // 检查问题
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        $this->assign('problem', $problem);
        
        // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
    
    // 处理添加记录以及编辑记录请求
    public function doAddLog()
    {
        $data = input('post.'); // 不加a也可以接收到数组，见鬼！
        $data['checktime'] = time(); // 添加时间
        $data['status'] = 0; // 默认为待审核状态
//         $data['checkuserid'] = session('checkuserid');
        $data['checkuserid'] = 7; // 检查者id
//         p($data);
        // 判断是否同一检查员对同一用户的上次检查记录没通过
        $lastStatus = $this->check->getStatus($data['checkuserid'], $data['cstcode'])['id']; // 取得该条记录id
//         p($lastStatus);
        if ($lastStatus){ // 上次检查记录审核不通过，更新上次记录再审
            // $this->check->updateCheckInfo($data, $lastStatus); // 更新检查记录表 => 在房间基本信息不变的情况下，此步骤不需要
        
            // 过滤无用数据
            $pro = []; // 问题详情
            $img = []; // 照片记录
            foreach ($data as $k => $v){
                if (is_array($v)){
                    if ($k !== 'image'){ // 根据key排除图片数据，拼装问题记录数据
                        $v['check_id'] = $lastStatus;
                        $pro[] = $v;
                    } else {
                        foreach ($v as $k2 => $v2){
                            $img[$k2]['url'] = str_replace(strrchr($v2, '.'), '', $v2);
                            $img[$k2]['showname'] = substr($v2, strrpos ($v2, '.') + 1);
                            $img[$k2]['name'] = substr(str_replace(strstr($v2, '.'), '', $v2), strrpos($v2, '/') + 1); // 替换法截取
                            $img[$k2]['check_id'] = $lastStatus;
                        }
        
                        // 新增图片记录
                        $this->photo->addImgInfo($img);
                    }
                }
            }
//             P($pro);
            // 更新问题记录详情，求审核通过
            $result = $this->checkPro->updateProLog($pro);
            if ($result){
                return true; // 更新问题记录详情成功
            } else {
                return false;
            }
        }else {
//             p($data);
            $check_id = $this->check->addCheckInfo($data); // 新增检查记录并返回自增id
            
            // 同上
            $pro = []; // 问题详情
            $img = []; // 照片记录
            foreach ($data as $k => $v){
                if (is_array($v)){
                    if ($k !== 'image'){ // 根据key排除图片数据，拼装问题记录数据
                        $v['check_id'] = $check_id;
                        $pro[] = $v;
                    } else {
                        foreach ($v as $k2 => $v2){
                            $img[$k2]['url'] = str_replace(strrchr($v2, '.'), '', $v2);
                            $img[$k2]['showname'] = substr($v2, strrpos ($v2, '.') + 1);
                            $img[$k2]['name'] = substr(str_replace(strstr($v2, '.'), '', $v2), strrpos($v2, '/') + 1); // 替换法截取
                            $img[$k2]['check_id'] = $check_id;
                        }
        
                        // 新增图片记录
                        $this->photo->addImgInfo($img);
                    }
                }
            }
//         p($pro);
            // 新增问题记录详情
            $result = $this->checkPro->inputProLog($pro); // 模型层已过滤非数据表字段
            if ($result){
                return true; // 新增成功
            } else {
                return false;
            }
        }
    }
    
    // 修改用户信息 => 废弃功能
    /* public function updateRoom()
    {
        if (input('?post.cstcode')){ // 获取用户信息
            $cstcode = input('post.cstcode');
            $roomInfo = $this->room->getRoomInfo($cstcode);
            return json_encode($roomInfo);
        }
    } */
    
    // 处理图片记录
    public function doImg()
    {
//         p($_FILES);
        // 获取表单上传文件
        $files = request()->file('image');
        $imgSaveUrl = [];
        foreach($files as $k => $file){
    
            // 移动uploads目录下
            //             $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/mobile/uploads/' . date('Y-m-d', time()) . '/');
            $info = $file->move(ROOT_PATH . 'public/pc/uploads/');
            //             p($info);
            //                 $info = $file->move('/public/mobile/uploads/');
            if($info){
                //                 $imgSaveInfo[$k]['url'] = str_replace('\\', '/', '/public/mobile' . DS . 'uploads'. DS . $info->getSaveName());
                $fileName = str_replace(strrchr($_FILES['image']['name'][$k], '.'), '', $_FILES['image']['name'][$k]); // strrchr返回'.'最后一次出现位置并替换为空
                $imgSaveUrl[]['url'] = str_replace('\\', '/', '/public/pc/uploads/' . $info->getSaveName()) . '.' . $fileName;
            } else {
    
                // 上传失败获取错误信息
                echo $file->getError();exit;
            }
        }
        echo json_encode($imgSaveUrl);exit;
    }
}
