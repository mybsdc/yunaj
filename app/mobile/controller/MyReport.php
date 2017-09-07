<?php
/**
 * 我的报表控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;

class MyReport extends Base
{
    // 我的报表页
    public function index()
    {
        $xzqy = model('Xzqy'); // 实例化Xzqy模型
        $xq = model('Project'); // 实例化Project模型
        $room = model('Room'); // 实例化Room模型
        $check = model('CheckInfo'); // 检查记录表模型
        $zzjg = model('Zzjg'); // 实例化Zzjg模型
        
        // 通过城市查区域
        if (input('?post.xzqy_id')){
            $xzqy_id = input('post.xzqy_id/d'); // /d强制转为整型
            $data = $xzqy->cityFindArea($xzqy_id);
            echo json_encode($data);exit;
        }
        
        $checkuserid = session('checkuserid'); // 用于检查记录报表的识别码
        
        // 通过区域查小区，通过区域生成检查报表
        if (input('?post.area_id')){
            $area_id = input('post.area_id/d');
            $data['xq'] = $xq->areaFindXq($area_id); // 异步查小区
            $data['report'] = $check->getMyReport($checkuserid, $area_id); // 异步生成我的报表，通过区域筛选
            echo json_encode($data);exit;
        }
        
        // 通过小区生成检查报表
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
            $data = $check->getMyReport($checkuserid, '', $xq_id); // 异步生成我的报表，通过小区筛选
            echo json_encode($data);exit;
        }
        
        // 通过周月年生成检查报表
        if (input('?get.wmy')){
            // $checkuserid, $aid = '', $xid = '', $wmy = '', $startTime = '', $endTime = ''
            $wmy = input('get.wmy/s'); // s转字符串
            
            if (isset($_GET['areaID']) && !empty($_GET['areaID'])){ // 存在区域条件
                $aid = input('get.areaID/d');
            } else {
                $aid = '';
            }
            if (isset($_GET['xqID']) && !empty($_GET['xqID'])){ // 存在小区条件
                $xid = input('get.xqID/d');
            } else {
                $xid = '';
            }
            $data = $check->getMyReport($checkuserid, $aid, $xid, $wmy); // 异步查我的记录，通过周月年筛选
            echo json_encode($data);exit;
        }
        
        // 自定义时间段生成检查报表
        if (input('?get.startTime') && input('?get.endTime')){
            
            // 转时间戳
            $startTime = strtotime(input('get.startTime'));
            $endTime = strtotime(input('get.endTime'));
            
            if ($startTime && $endTime){
                
                // 存在小区条件，逻辑上先于区域
                if (isset($_GET['xqID']) && !empty($_GET['xqID'])){
                    $xid = input('get.xqID/d'); // 用户传的数据全不可信，转整型保平安
                    $data = $check->getMyReport($checkuserid, '', $xid, '', $startTime, $endTime); // 自定义时间段与小区筛选
                    echo json_encode($data);exit;
                }
                
                // 存在区域条件
                if (isset($_GET['areaID']) && !empty($_GET['areaID'])){
                    $aid = input('get.areaID/d');
                    $data = $check->getMyReport($checkuserid, $aid, '', '', $startTime, $endTime); // 自定义时间段与区域筛选
                    echo json_encode($data);exit;
                }
                
                // 毛都没选，就点自定义时间段
                $data = $check->getMyReport($checkuserid, '', '', '', $startTime, $endTime); // 异步查我的记录，通过自定义时间段筛选
                echo json_encode($data);exit;
            }
        }
        
        $myReportData = $check->getMyReport($checkuserid); // 传入检查者id，获取报表
// p($log);

        // 当前用户有检查权限的城市区域小区
        $myData = $zzjg->getMyData($checkuserid); // 传入user_id
        
        $this->assign('myData', $myData);
        $this->assign('myReportData', $myReportData);
        return $this->fetch();
    }
}