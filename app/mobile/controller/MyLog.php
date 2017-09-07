<?php
/**
 * 我的记录控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;
use think\db\Query;

class MyLog extends Base
{   
    // 我的记录
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
        
        $checkuserid = session('checkuserid'); // 用于检查记录查看的识别码
        
        $row = 2; // 每页行数
        
        // 通过区域查小区，通过区域筛选检查记录
        if (input('?post.area_id')){
            $area_id = input('post.area_id/d');
            $data['xq'] = $xq->areaFindXq($area_id); // 异步查小区
            
            // 分页
            $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $area_id])->count(); // 总条数
            $countNum = ceil($count/$row); // 总页数
//             $this->assign('countNum', $countNum);
            $data['log'] = $countNum;
            
            // $data['log'] = $check->getMyLog($checkuserid, $area_id); // 异步查我的记录，通过区域筛选
            echo json_encode($data);exit;
        }
        if (input('?get.aa')){ // layer小朋友拿到总页数前来查区域检查数据
            $pageArea = input('get.aa');
            $aaid = input('get.aaid');
            $log = $check->getMyLog($checkuserid, $aaid, '', '', '', '', $pageArea, $row); // 返回分页条件查询数据
            echo json_encode($log);exit;
        }
        
        
        
        
        // 通过小区筛选检查记录
        if (input('?post.xq_id')){
            $xq_id = input('post.xq_id/d');
            $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $xq_id])->count(); // 总条数
            $countNum = ceil($count/$row); // 总页数
            //             $this->assign('countNum', $countNum);
            $data = $countNum; // 返回总页数
            // $data = $check->getMyLog($checkuserid, '', $xq_id); // 异步查我的记录，通过小区筛选
            echo json_encode($data);exit;
        }
        if (input('?get.xx')){ // layer通过返回总页数生成分页条，并动态取出数据
            $pageXq = input('get.xx');
            $xxid = input('get.xxid');
            $log = $check->getMyLog($checkuserid, '', $xxid, '', '', '', $pageXq, $row); // 返回分页条件查询数据
            echo json_encode($log);exit;
        }
        
        // 周月年筛选检查记录
        if (input('?get.theTime')){
            $theTime = input('get.theTime');
            if ($theTime == 'w'){ // 周
                if (input('get.myXq') != '') { // 存在小区条件，逻辑上先于区域
                    $myXid = input('get.myXq');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $myXid])->whereTime('checktime', 'w')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                if (input('get.myArea') != ''){ // 存在区域条件
                    $myAid = input('get.myArea');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $myAid])->whereTime('checktime', 'w')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                
                // 除了周，球条件没有
                $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'w')->count();
                $countNum = ceil($count/$row); // 总页数
                $data = $countNum;
                echo json_encode($data);exit; // 返回总页数
                
            } else if ($theTime == 'm'){ // 月
                if (input('get.myXq') != '') { // 存在小区条件，逻辑上先于区域
                    $myXid = input('get.myXq');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $myXid])->whereTime('checktime', 'm')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                if (input('get.myArea') != ''){ // 存在区域条件
                    $myAid = input('get.myArea');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $myAid])->whereTime('checktime', 'm')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                
                // 除了月，球条件没有
                $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'm')->count();
                $countNum = ceil($count/$row); // 总页数
                $data = $countNum;
                echo json_encode($data);exit; // 返回总页数
            } else if ($theTime == 'y'){
                if (input('get.myXq') != '') { // 存在小区条件，逻辑上先于区域
                    $myXid = input('get.myXq');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $myXid])->whereTime('checktime', 'y')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                if (input('get.myArea') != ''){ // 存在区域条件
                    $myAid = input('get.myArea');
                    $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $myAid])->whereTime('checktime', 'y')->count();
                    $countNum = ceil($count/$row); // 总页数
                    echo json_encode($countNum);exit; // 返回总页数
                }
                
                // 除了年，球条件没有
                $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'y')->count();
                $countNum = ceil($count/$row); // 总页数
                $data = $countNum;
                echo json_encode($data);exit; // 返回总页数
            }
            
            
            
            echo json_encode($data);exit; // 返回总页数
            
            /* $data = $check->getMyLog($checkuserid, '', '', $theTime); // 异步查我的记录，通过周月年筛选
            echo json_encode($data);exit; */
        }
        if (input('?get.ww') && input('get.getAID') == '' && input('get.getXID') == ''){ // 无任何区域小区条件
            $wwid = input('get.wwid');
            $wpage = input('get.ww'); // 第几页
            $data = $check->getMyLog($checkuserid, '', '', $wwid, '', '', $wpage, $row); // 异步查我的记录，通过周月年筛选
            echo json_encode($data);exit;
        } else if (input('?get.ww') && input('get.getXID') != ''){ // 存在小区条件
            $wwid = input('get.wwid'); // 周月年
            $wpage = input('get.ww'); // 第几页
            $xqqId = input('get.getXID');
            
            $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $xqqId])->whereTime('checktime', $wwid)->page($wpage, $row)->select();
            
            // js处理状态与时间戳过于麻烦，直接php搞定
            $log = []; // 定义log防止空数据报错
            foreach ($myLogData as $v){ // 审核状态
                if ($v['status'] === 1){
                    $v['statusCN'] = '已通过';
                } else {
                    $v['statusCN'] = '待审核';
                }
                $v['checktime'] = date('Y-m-d H:i:s', $v['checktime']); // 格式化时间戳
                $log[] = $v;
            }
            
            
            
            // $data = $check->getMyLog($checkuserid, '', '', $wwid, '', '', $wpage, $row); // 异步查我的记录，通过周月年筛选
            echo json_encode($log);exit;
        } else if (input('?get.ww') && input('get.getAID') != ''){ // 存在区域条件
            $wwid = input('get.wwid'); // 周月年
            $wpage = input('get.ww'); // 第几页
            $aaaa = input('get.getAID'); // 区域id
            
            $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $aaaa])->whereTime('checktime', $wwid)->page($wpage, $row)->select();

            // js处理状态与时间戳过于麻烦，直接php搞定
            $log = []; // 定义log防止空数据报错
            foreach ($myLogData as $v){ // 审核状态
                if ($v['status'] === 1){
                    $v['statusCN'] = '已通过';
                } else {
                    $v['statusCN'] = '待审核';
                }
                $v['checktime'] = date('Y-m-d H:i:s', $v['checktime']); // 格式化时间戳
                $log[] = $v;
            }
            
            // $data = $check->getMyLog($checkuserid, '', '', $wwid, '', '', $wpage, $row); // 异步查我的记录，通过周月年筛选
            echo json_encode($log);exit;
        }
        
        // 自定义时间段筛选检查记录
        if (input('?get.startTime') && input('?get.endTime')){ // 先获取总页数
            
            // 转时间戳，实际上不用转，tp5会识别
            $startTime = strtotime(input('get.startTime'));
            $endTime = strtotime(input('get.endTime'));
            
            if (input('get.fx') != '') { // 存在小区条件
                $rxid = input('get.fx'); // 小区id
                $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $rxid])->whereTime('checktime', 'between', [$startTime, $endTime])->count();
                $countNum = ceil($count/$row); // 总页数
                //$data = $check->getMyLog($checkuserid, '', '', '', $startTime, $endTime); // 异步查我的记录，通过自定义时间段筛选
                echo json_encode($countNum);exit;
            } 
            if (input('get.fa') != '') { // 存在区域条件
                $raid = input('get.fa'); // 区域id
                $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $raid])->whereTime('checktime', 'between', [$startTime, $endTime])->count();
                $countNum = ceil($count/$row); // 总页数
                //$data = $check->getMyLog($checkuserid, '', '', '', $startTime, $endTime); // 异步查我的记录，通过自定义时间段筛选
                echo json_encode($countNum);exit;
            }
            
            
            
            
            
            $count = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'between', [$startTime, $endTime])->count();
            $countNum = ceil($count/$row); // 总页数
            //$data = $check->getMyLog($checkuserid, '', '', '', $startTime, $endTime); // 异步查我的记录，通过自定义时间段筛选
            echo json_encode($countNum);exit;
            
        }
        if (input('?get.diytime')){ // 已取到总页数，现在响应翻页事件取数据
            $diypage = input('get.diytime'); // 第几页
            $startT = input('get.fstime'); // 开始时间
            $endT = input('get.fetime'); // 结束时间
            
            // 直接取，简单粗暴
            if (input('get.ffx') != '') { // 小区条件
                $ffx = input('get.ffx');
                $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $ffx])->whereTime('checktime', 'between', [$startT, $endT])->page($diypage, $row)->select();
                $log = []; // 定义log防止空数据报错
                foreach ($myLogData as $v){ // 审核状态
                    if ($v['status'] === 1){
                        $v['statusCN'] = '已通过';
                    } else {
                        $v['statusCN'] = '待审核';
                    }
                    $v['checktime'] = date('Y-m-d H:i:s', $v['checktime']); // 格式化时间戳
                    $log[] = $v;
                }
                echo json_encode($log);exit;
            }
            if (input('get.ffa') != '') { // 区域条件
                $ffa = input('get.ffa');
                $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $ffa])->whereTime('checktime', 'between', [$startT, $endT])->page($diypage, $row)->select();
                $log = []; // 定义log防止空数据报错
                foreach ($myLogData as $v){ // 审核状态
                    if ($v['status'] === 1){
                        $v['statusCN'] = '已通过';
                    } else {
                        $v['statusCN'] = '待审核';
                    }
                    $v['checktime'] = date('Y-m-d H:i:s', $v['checktime']); // 格式化时间戳
                    $log[] = $v;
                }
                echo json_encode($log);exit;
            }
            
            // 仅选自定义时间，无区域小区条件
            $data = $check->getMyLog($checkuserid, '', '', '', $startT, $endT, $diypage, $row);
            echo json_encode($data);exit;
        }
        
        
        
        
        
        // 通过房号或用户编号 Ajax 异步查询
        if (input('?get.num')){
            $num = input('get.num/d');
            $data = $check->getLog($checkuserid, $num); // 查我的检查记录
            echo json_encode($data);exit;
        }
        
        // $checkuserid, $aid = '', $xid = '', $wmy = '', $startTime = '', $endTime = '', $page = 1, $row = 2
        // 当前用户的所有检查记录
        //$log = $check->getMyLog($checkuserid, '', '', '', '', '', $page, $row); // 仅传检查者id的情况
        // 分页
        $page = input('?get.page') ? input('get.page/d') : 1; // 第几页，强制转为整型
        $count = db('checkinfo')->where(['checkuserid' => $checkuserid])->count(); // 总条数
        $countNum = ceil($count/$row); // 总页数
        $this->assign('countNum', $countNum);
        if (input('?get.page')){
            $log = $check->getMyLog($checkuserid, '', '', '', '', '', $page, $row); // 返回分页条件查询数据
            return json_encode($log);
        }
        
// p($log);

        // 当前用户有检查权限的城市区域小区
        $myData = $zzjg->getMyData(session('checkuserid')); // 传入user_id
        
        $this->assign('myData', $myData);
//         $this->assign('log', $log);
        return $this->fetch();
    }
}