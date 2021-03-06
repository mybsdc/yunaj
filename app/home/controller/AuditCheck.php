<?php
/**
 * 审核检查结果
 * 
 */

namespace app\home\controller;

use think\Loader; // 引入Loader类
// use llf\PHPExcel\PHPExcel; 木有命名空间不支持这玩意儿

class AuditCheck extends Base
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
        $this->uid = session('uid'); // 操作人id，下面的任务根据此来取值
//         $this->uid = 8;
        $this->zzjg = model('Zzjg'); // 组织机构模型
    }
    
    /**
     * 未检查列表
     * 
     */
    public function index()
    {
        // 获取任务列表
        $taskList = $this->task->getTaskList($this->uid);
//         p($taskList);
        $this->assign('taskList', $taskList);
        
        // 有权限查看的城市区域和小区
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
        $this->assign('getLocation', $getLocation);

        // 通过任务条件
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->notCheckList(1, $task_id, $city_id);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        /* $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
    
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq); */
    
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
    
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 4
            $listData = $this->room->notCheckList(1, '', $city_id); // page页数必须传，如果置为空，在模型的方法里无法正确计算分页开始位置
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
            $listData = $this->room->notCheckList(1, '', '', $area_id);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
    
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->notCheckList(1, '', '', '', $xq_id);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        // 按房号或卡号搜索
        if (input('?get.num')){
    
            // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $row = 10
            $num = input('get.num');
            $listData = $this->room->notCheckList(1, '', $city_id, '', '', '', $num);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
//         $listData = $this->room->notCheckList();
        $listData = $this->room->notCheckList(1, '', $city_id);
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
        $res = $this->getFun();
        $this->assign("res",$res);
        $this->assign('tname', input('get.tname'));
    
        return $this->fetch();
    }
    
    /**
     * 待审核列表
     *
     */
    public function wait()
    {
        $status = 0; // 状态0，待审核
        
        // 获取任务列表
        $taskList = $this->task->getTaskList($this->uid);
        $this->assign('taskList', $taskList);
        
        // 有权限查看的城市区域和小区
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
        $this->assign('getLocation', $getLocation);

        // 通过任务条件
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 10
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->auditor(1, $task_id, $city_id, '', '', false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
        
        /* $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
    
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq); */
    
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
    
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
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
            $listData = $this->room->auditor(1, '', '', $area_id, '', false, '', $status);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
    
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', '', '', $xq_id, false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        // 按房号或卡号搜索
        if (input('?get.num')){
            $num = input('get.num');
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, $num, $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
//         $listData = $this->room->auditor(1, '', '', '', '', false, '', $status);
        $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
//         p($listData);
        $this->assign('count', $listData['count']); // 总条数
        $this->assign('pageNum', $listData['pageNum']); // 总页数
        $this->assign('listData', $listData['list']); // 首次数据
    
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
//         p($type);
        $this->assign('type', $type);
        $this->assign('brand', $brand);
    
        // 侧边栏
        $model=model('Fun');
        $res = $this->getFun();
        $this->assign("res",$res);
    
        return $this->fetch();
    }
    
    /**
     * 未通过审核列表
     *
     */
    public function notPass()
    {
        $status = -1; // 状态-1，未通过审核
        
        // 获取任务列表
        $taskList = $this->task->getTaskList($this->uid);
        $this->assign('taskList', $taskList);
        
        // 有权限查看的城市区域和小区
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
        $this->assign('getLocation', $getLocation);
        
        // 通过任务条件
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = 0, $row = 2
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 10
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->auditor(1, $task_id, $city_id, '', '', false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
//             p($listData);
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
        
        /* $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
        
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq); */
        
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
        
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
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
            $listData = $this->room->auditor(1, '', '', $area_id, '', false, '', $status);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
        
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
        
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', '', '', $xq_id, false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
        
        // 按房号或卡号搜索
        if (input('?get.num')){
            $num = input('get.num');
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, $num, $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
        
//         $listData = $this->room->auditor(1, '', '', '', '', false, '', $status);
        $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
//                 p($listData);
        $this->assign('count', $listData['count']); // 总条数
        $this->assign('pageNum', $listData['pageNum']); // 总页数
        $this->assign('listData', $listData['list']); // 首次数据
        
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        //         p($type);
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        
        // 侧边栏
        $model=model('Fun');
        $res = $this->getFun();
        $this->assign("res",$res);
        
        return $this->fetch();
        
    }
    
    /**
     * 已通过审核列表
     *
     */
    public function pass()
    {
        $status = 1; // 状态1，已通过审核
    
        // 获取任务列表
        $taskList = $this->task->getTaskList($this->uid);
        $this->assign('taskList', $taskList);
        
        // 有权限查看的城市区域和小区
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
        $this->assign('getLocation', $getLocation);
    
        // 通过任务条件
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = 0, $row = 2
        // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 10
        if (input('?post.task_id')){
            $task_id = input('post.task_id/d');
            $listData = $this->room->auditor(1, $task_id, $city_id, '', '', false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            //             p($listData);
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        /* $allCity = $this->xzqy->getAllCity(); // 所有城市
        $allArea = $this->xzqy->getAllArea(); // 所有区域
        $allXq = $this->xq->getAllXq(); // 所有小区
    
        $this->assign('allCity', $allCity);
        $this->assign('allArea', $allArea);
        $this->assign('allXq', $allXq); */
    
        // 通过城市id查区域
        if (input('?post.city_id')){
            $city_id = input('post.city_id/d');
            $getArea = $this->xzqy->getAreaByPid($city_id);
    
            // 点击城市后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
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
            $listData = $this->room->auditor(1, '', '', $area_id, '', false, '', $status);
            $myData['xq'] = $getXq; // 取回小区数据
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
        // 通过小区查列表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
    
            // 点击小区后，触发该条去更新页面的总条数和总页数，然后静态页触发layer重新获取列表数据
            $listData = $this->room->auditor(1, '', '', '', $xq_id, false, '', $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData); // 只需用到总条数和总页数，所以，别返回那么多数据
        }
    
        // 按房号或卡号搜索
        if (input('?get.num')){
            $num = input('get.num');
            $listData = $this->room->auditor(1, '', $city_id, '', '', false, $num, $status);
            $myData['count'] = $listData['count']; // 总条数
            $myData['pageNum'] = $listData['pageNum']; // 总页数
            return json_encode($myData);
        }
    
//         $listData = $this->room->auditor(1, '', '', '', '', false, '', $status);
        $listData = $this->room->auditor(1, '', $city_id, '', '', false, '', $status);
        //                 p($listData);
        $this->assign('count', $listData['count']); // 总条数
        $this->assign('pageNum', $listData['pageNum']); // 总页数
        $this->assign('listData', $listData['list']); // 首次数据
    
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        //         p($type);
        $this->assign('type', $type);
        $this->assign('brand', $brand);
    
        // 侧边栏
        $model=model('Fun');
        $res = $this->getFun();
        $this->assign("res",$res);
    
        return $this->fetch();
    }
    
    // 分页
    public function toPage()
    {
        // 有权限查看的城市区域和小区 - 分页数据应该与上面相同
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
        
        // 有状态码情况
        if (input('?post.status')){
            $curr = input('post.page/d'); // 第几页
            $status = input('post.status'); // 审核状态
            if (input('?post.num')){ // 搜索功能逻辑上优先级最高
                $num = input('post.num');
                $listData = $this->room->auditor($curr, '', $city_id, '', '', false, $num, $status);
                return json_encode($listData['list']);
            }
            if (input('?post.task_id')){ // 任务优先级其次
                $task_id = input('post.task_id');
                $listData = $this->room->auditor($curr, $task_id, $city_id, '', '', false, '', $status);
                return json_encode($listData['list']);
            }
            if (input('?post.city_id')){ // 貌似走不到这个分支了，每个人只对应一个城市，只会涉及到选区域以及之下的东西了
                $city_id = input('post.city_id');
                $listData = $this->room->auditor($curr, '', $city_id, '', '', false, '', $status);
                return json_encode($listData['list']);
            }
    
            if (input('?post.area_id')){
                $area_id = input('post.area_id');
                $listData = $this->room->auditor($curr, '', '', $area_id, '', false, '', $status);
                return json_encode($listData['list']);
            }
    
            if (input('?post.xq_id')){
                $xq_id = input('post.xq_id/d');
                $listData = $this->room->auditor($curr, '', '', '', $xq_id, false, '', $status);
                return json_encode($listData['list']);
            }
    
            if (input('?post.page')){
                $curr = input('post.page/d');
                $listData = $this->room->auditor($curr, '', $city_id, '', '', false, '', $status);
                return json_encode($listData['list']);
            }
        }
    
        // 无状态情况，即待检查列表
        if (input('?post.num')){ // 搜索功能逻辑上优先级最高
            $curr = input('post.page/d');
            $num = input('post.num');
            $listData = $this->room->notCheckList($curr, '', $city_id, '', '', '', $num);
            return json_encode($listData['list']);
        }
        if (input('?post.task_id')){ // 任务优先级其次
            $curr = input('post.page/d');
            $task_id = input('post.task_id');
            $listData = $this->room->notCheckList($curr, $task_id, $city_id);
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
            $listData = $this->room->notCheckList($curr, '', $city_id);
            return json_encode($listData['list']);
        }
    }
    
    // 导出数据为Excel-由于待检查列表的模板与检查执行者的模板一样，故此处只生成除待检查外的数据模板
    public function toExcel()
    {
        Loader::import('llf.PHPExcel.PHPExcel');
    
        // 实例化对象
        $obj_excel = new \PHPExcel(); // 新建Excel表
    
        // 得到列表
        $result = [];
        
        // 有权限查看的城市区域和小区 - 分页数据应该与上面相同
        $getLocation = $this->zzjg->getPlace($this->uid);
        $city_id = $getLocation['city'][0]['id']; // 当前操作者所属城市的id
    
        // 存在状态码的数据 0待审核 1 已通过审核 -1 未通过审核
        if (input('?get.status')){
            // $page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 1
            $status = input('get.status/d');
            if (input('?get.num') && !empty(input('get.num'))){ // 模糊搜索，逻辑上优于其它
                $num = input('get.num');
                $result = $this->room->auditor('', '', $city_id, '', '', true, $num, $status); // 参数true标识生成Excel数据
            } else if (input('?get.toTask') && !empty(input('get.toTask'))){ // 传任务id
                $task_id = input('get.toTask');
                $result = $this->room->auditor('', $task_id, $city_id, '', '', true, '', $status);
            } else if (input('?get.toXqId') && !empty(input('get.toXqId'))){ // 小区
                $xq_id = input('get.toXqId/d');
                $result = $this->room->auditor('', '', '', '', $xq_id, true, '', $status); // 参数true标识生成Excel数据
            } else if (input('?get.toAreaId') && !empty(input('get.toAreaId'))){ // 区域
                $area_id = input('get.toAreaId/d');
                $result = $this->room->auditor('', '', '', $area_id, '', true, '', $status); // 参数true标识生成Excel数据
            } else if (input('?get.toCityId') && !empty(input('get.toCityId'))){ // 城市
                $city_id = input('get.toCityId/d');
                $result = $this->room->auditor('', '', $city_id, '', '', true, '', $status); // 参数true标识生成Excel数据
            } else { // 全部
                $result = $this->room->auditor('', '', $city_id, '', '', true, '', $status); // 参数true标识生成Excel数据
            }
        } else {
    
            // 审核管理里压根走不到这个分支
            // 待检查列表数据
            if (input('?get.num') && !empty(input('get.num'))){ // 模糊搜索，逻辑上优于其它
                $num = input('get.num');
                $result = $this->room->notCheckList('', '', $city_id, '', '', true, $num); // 参数true标识生成Excel数据
            } else if (input('?get.toTask') && !empty(input('get.toTask'))){ // 传任务id
                $task_id = input('get.toTask');
                $result = $this->room->notCheckList('', $task_id, $city_id, '', '', true);
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
                $result = $this->room->notCheckList('', '', $city_id, '', '', true); // 参数true标识生成Excel数据
            }
        }
    
        // 设置excel的第一行的标题
        $obj_excel->getActiveSheet()->setCellValue('A1', '序号', true );
        $obj_excel->getActiveSheet()->setCellValue('B1', '地址', true );
        $obj_excel->getActiveSheet()->setCellValue('C1', '房号', true );
        $obj_excel->getActiveSheet()->setCellValue('D1', '用户编号', true );
        $obj_excel->getActiveSheet()->setCellValue('E1', '表底数', true );
        $obj_excel->getActiveSheet()->setCellValue('F1', '照片', true );
        $obj_excel->getActiveSheet()->setCellValue('G1', '姓名', true );
        $obj_excel->getActiveSheet()->setCellValue('H1', '电话', true );
        $obj_excel->getActiveSheet()->setCellValue('I1', '气表信息', true );
        $obj_excel->getActiveSheet()->setCellValue('J1', '检查人', true );
        $obj_excel->getActiveSheet()->setCellValue('K1', '检查时间', true );
        $obj_excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(12)->setBold(true)->setName('微软雅黑');
        $obj_excel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID); // 背景填充方式
        $obj_excel->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setRGB('17A3FF'); // 背景色
        $obj_excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $obj_excel->getActiveSheet()->getStyle('A1:K1')->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        
//         p($result);
        // 写入单元格
        foreach ($result as $k => $v){
            $num = $k + 2; // 比如'A'.$num即A2刚好是tbody的第一行
    
            $obj_excel->getActiveSheet()->setCellValue('A'.$num, $k + 1)->getColumnDimension('A')->setWidth(6); // 写入单元格，标明位置和值
            $obj_excel->getActiveSheet()->setCellValue('B'.$num, $v['areaName'] . $v['xqName'])->getColumnDimension('B')->setWidth(30);
            $obj_excel->getActiveSheet()->setCellValue('C'.$num, $v['dong'] . $v['unit'] . '单元' . $v['room'])->getColumnDimension('C')->setWidth(20);
            $obj_excel->getActiveSheet()->setCellValue('D'.$num, $v['cstcode'])->getColumnDimension('D')->setWidth(20);
            $obj_excel->getActiveSheet()->setCellValue('E'.$num, $v['basenumber'])->getColumnDimension('E')->setWidth(20);
            $obj_excel->getActiveSheet()->setCellValue('F'.$num, $v['imgNum'] . '张')->getColumnDimension('F')->setWidth(8);
            $obj_excel->getActiveSheet()->setCellValue('G'.$num, $v['cstname'])->getColumnDimension('G')->setWidth(10);
            $obj_excel->getActiveSheet()->setCellValue('H'.$num, $v['telphone'])->getColumnDimension('H')->setWidth(20);
            $obj_excel->getActiveSheet()->setCellValue('I'.$num, $v['qbInfo'])->getColumnDimension('I')->setWidth(20);
            $obj_excel->getActiveSheet()->setCellValue('J'.$num, $v['checkuser'])->getColumnDimension('J')->setWidth(10);
            $obj_excel->getActiveSheet()->setCellValue('K'.$num, $v['checktime'])->getColumnDimension('K')->setWidth(20);
        }
    
        // 创建表（默认sheet1）
        //         $obj_excel->createSheet(); // 默认有一个sheet，无需创建
        $obj_excel->getActiveSheet()->setTitle('燃气用户信息表'); // 设置sheet标题
        $obj_writer = \PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
    
        $file_name = date('Y-m-d-H-i-s',time()).'_燃气用户信息.xlsx'; // 导出的文件名
    
        // 没有以下内容，excel直接输出，有则提示下载
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename='.$file_name);
        header('Cache-Control: max-age=0');
    
        $obj_writer->save('php://output'); // 保存excel
        // $obj_writer->save(__PC__ . '/excel/' . $file_name); // 保存excel
    }
    
    // 照片查看
    public function photoView()
    {
        if (empty(input('get.check_id'))){
            $this->error('非法访问！');
        }
        $check_id = input('get.check_id/d');
        
/*         // 取数据
        $data = []; */
        $imgData = $this->photo->getImgUrl($check_id); // 获取图片地址
//         $roomInfo = $this->room->getCheckInfo($check_id); // 房间信息
        /* if (empty($imgData)){
            return $this->error('这条记录没有照片哦');
        } */
        /* $data['imgData'] = $imgData;
        $data['roomInfo'] = $roomInfo; */
        
        
        return json_encode($imgData);
//         $this->assign('imgData', $imgData);
        /* $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        $this->assign('roomInfo', $roomInfo);  */
//         p($roomInfo);
        
       /*  $this->assign('type', $type);
        $this->assign('brand', $brand); */
//         return $this->fetch();
    }
    
    // 执行审核
    public function toAudit()
    {
        if (empty(input('post.check_id'))){
            $this->error('非法访问！');
        }
        
        $check_id = input('post.check_id/d');
        $is_change = input('post.is_change/d'); // 房间信息改动标识
        $room_id = input('post.room_id');
        $pass = input('post.pass');
//         p($pass);
        // $check_id = '', $is_change = 0, $room_id = '', $pass = true
        $result = $this->check->doAudit($check_id, $is_change, $room_id, $pass); // 审核操作
        return json_encode($result);
    }
}