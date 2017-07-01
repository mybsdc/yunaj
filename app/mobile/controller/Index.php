<?php
/**
 * 区域楼栋单元选择页面控制器
 * 
 */

namespace app\mobile\controller;

use think\Controller;

class Index extends Base
{
    // 首页  - 区域楼栋选择页面
    public function index()
    {
        $xzqy = model('Xzqy'); // 实例化Xzqy模型
        $xq = model('Project'); // 实例化Project模型
        $room = model('Room'); // 实例化Room模型
        $zzjg = model('Zzjg'); // 实例化Zzjg模型
        
        /* // 所有城市区域
        $xzqyData = $xzqy->getAllXzqy();
        
        // 所有小区
        $xqData = $xq->getAllXq(); */
        
        // 通过城市查区域
        if (input('?post.xzqy_id')){
            $xzqy_id = input('post.xzqy_id/d'); // /d强制转为整型
            $data = $xzqy->cityFindArea($xzqy_id);
            echo json_encode($data);exit;
        }
        
        // 通过区域查小区
        if (input('?post.area_id')){
            $area_id = input('post.area_id/d');
            $data = $xq->areaFindXq($area_id);
            echo json_encode($data);exit;
        }
        
        // 通过小区查栋单元
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
            $data = $room->getXqDongDy($xq_id);
            echo json_encode($data);exit;
        }
        
        // 当前用户有检查权限的城市区域小区
        $myData = $zzjg->getMyData(session('checkuserid')); // 传入user_id
        
        $this->assign('myData', $myData);
//         $this->assign('xqData', $xqData);
        return $this->fetch(); // return
    }
}
