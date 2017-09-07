<?php
/**
 * 该模型对应检查记录yunaj_checkinfo表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class CheckInfo extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_checkinfo'; // 这个类文件名为Checkinfo就无需此步
    
    /**
     * 添加检查记录
     * @param $data 各种检查记录信息
     * return int save方法新增数据返回的是写入的记录数
     * 
     */
    public function addCheckInfo($data)
    {
        $this->allowField(true)->save($data); // 添加数据到记录表，过滤post数组中的非数据表字段数据
        $check_id = $this->id;
        return $check_id;
    }
    
    /**
     * 更新检查记录
     * @param mixed $data 各种检查记录信息
     * @param int $logID 该条记录的id值
     * return int 影响条数
     *
     */
    public function updateCheckInfo($data, $logID)
    {
        return $this->allowField(true)->save($data,['id' => $logID]);
    }
    
    /**
     * 判断检查记录的审核状态
     * @param int $checkerID 检查者id
     * @param int $cstcode 客户房间编号
     * return array 未通过审核的记录
     * status 审核状态码 0未审核 -1不通过 1通过，此处修复一个逻辑错误，无需传入状态，只有两种情况未不通过
     * 
     */
    public function getStatus($checkerID, $cstcode)
    {
        $where = "`checkuserid` = '$checkerID' AND `cstcode` = '$cstcode' AND (`status` = '0' OR `status` = '-1')"; // 条件
        return db('checkinfo')->where($where)->find();
    }
    
    /**
     * 获取检查记录
     * @param int $cstcode 客户房间编号
     * return array 房间历史记录
     * 
     */
    public function getCheckLog($cstcode)
    {
        $data = db()->query("SELECT b.name, a.checktime, a.status, a.id, a.checkuserid FROM yunaj_checkinfo a JOIN yunaj_user b ON b.id = a.checkuserid WHERE a.cstcode = '$cstcode'"); // $cstcode的引号不能少，因为编号有可能是个字符串
        $log = []; // 解决前端报未定义错误
        foreach ($data as $v){
            $havePro = db('checkproblem')->where(['check_id' => $v['id'], 'answer' => 0])->find(); // 判断今次检查有无安全隐患
            if (!$havePro){
                $v['havePro'] = '无';
            } else {
                $v['havePro'] = '有';
            }
            if ($v['status'] === 1){ // 审核状态
                $v['statusCN'] = '已审核';
            } else {
                $v['statusCN'] = '待审核';
            }            
            $v['checktime'] = date('Y-m-d H:i:s', $v['checktime']); // 格式化时间
            $log[] = $v; // 该房间历史检查记录
        }
        return $log;
    }
    
    /**
     * 获取我的检查记录
     * @param int $checkuserid 检查者id
     * @param int $aid 区域id
     * @param int $xid 小区id
     * @param string $wmy 周月年
     * @param int $startTime 开始时间
     * @param int $endTime 结束时间
     * @param int $row 每页显示条数
     * return array 根据条件查询检查者的记录
     * 
     */
    public function getMyLog($checkuserid, $aid = '', $xid = '', $wmy = '', $startTime = '', $endTime = '', $page = 1, $row = 2)
    {
        // 通过区域筛选
        if (!empty($aid)){
            // $myLogData = db()->query("SELECT r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id FROM yunaj_checkinfo c JOIN yunaj_room r ON c.cstcode = r.cstcode JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_build b ON b.id = r.bld_id JOIN yunaj_xzqy x ON p.xzqy_id = x.id WHERE c.checkuserid = $checkuserid AND x.id = $aid");
            $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'x.id' => $aid])->page($page, $row)->select();

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
            return $log;
        }
        
        // 通过小区筛选
        if (!empty($xid)){
            // $myLogData = db()->query("SELECT r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id FROM yunaj_checkinfo c JOIN yunaj_room r ON c.cstcode = r.cstcode JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_build b ON b.id = r.bld_id JOIN yunaj_xzqy x ON p.xzqy_id = x.id WHERE c.checkuserid = $checkuserid AND p.id = $xid");
            $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid, 'p.id' => $xid])->page($page, $row)->select();
            
            // 原因同上
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
            return $log;
        }
        
        // 本周月年
        if (!empty($wmy)){
            if ($wmy === 'w'){ // 周
                $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'w')->page($page, $row)->select();
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
                return $log;
            } else if ($wmy === 'm'){ // 月
                $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'm')->page($page, $row)->select();
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
                return $log;
            } else if ($wmy === 'y'){ // 年
                $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'y')->page($page, $row)->select();
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
                return $log;
            }
        }
        
        // 自定义时间段筛选
        if (!empty($startTime) && !empty($endTime)){
            $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->join('yunaj_xzqy x', 'p.xzqy_id = x.id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->whereTime('checktime', 'between', [$startTime, $endTime])->page($page, $row)->select();
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
            return $log;
        }
        
        // 当前检查者的所有记录
        // $myLogData = db()->query("SELECT r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status FROM yunaj_checkinfo c JOIN yunaj_room r ON c.cstcode = r.cstcode JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_build b ON b.id = r.bld_id WHERE c.checkuserid = $checkuserid");
        $myLogData = db('checkinfo')->alias('c')->join('yunaj_room r', 'c.cstcode = r.cstcode')->join('yunaj_project p', 'p.id = r.proj_id')->join('yunaj_build b', 'b.id = r.bld_id')->field('r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id')->where(['c.checkuserid' => $checkuserid])->page($page, $row)->select();
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
//         p($countNum);
        return $log;
//         p($myLogData);
        /* $myLogDataList = $myLogData->toArray()['data']; // 列表
        $pages = $myLogData->render();
        p($pages); */
    }
    
    /**
     * 异步查询我的检查记录
     * @param int $num 用户编号或房号
     * @param int $checkuserid 检查者id
     * return array 检查记录
     * 
     */
    public function getLog($checkuserid, $num)
    {
        $myLogData = db()->query("SELECT r.cstcode, r.unit, r.room, p.name, b.code, c.checktime, c.status, c.id check_id FROM yunaj_checkinfo c JOIN yunaj_room r ON c.cstcode = r.cstcode JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_build b ON b.id = r.bld_id WHERE c.checkuserid = $checkuserid AND (r.room LIKE '%$num%' OR r.cstcode LIKE '%$num%') LIMIT 20"); // 坑爹，之前OR条件少加了个括号  // 限制最多取20条
        
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
        return $log;
    }
    
    /**
     * 获取我的报表
     * @param int $checkuserid 检查者id
     * @param int $aid 区域id
     * @param int $xid 小区id
     * @param string $wmy 周月年
     * @param int $startTime 开始时间
     * @param int $endTime 结束时间
     * return array 根据条件生成我的报表
     * 
     */
    public function getMyReport($checkuserid, $aid = '', $xid = '', $wmy = '', $startTime = '', $endTime = '')
    {
        $myReportData = [];
        
        // 通过区域生成我的报表
        if (!empty($aid) && empty($wmy) && empty($startTime) && empty($endTime)){ // 注意区分自定义时间段加区域的情况，以及周月年加区域的情况
            /* $from = 'JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id';
            $where = "x.id = $aid"; // 区域id条件
            $sql = "SELECT COUNT(c.id) haveCheckedNum, SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum, SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0 END) passNum, SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0 END) notPassNum FROM yunaj_checkinfo c $from WHERE c.checkuserid = $checkuserid AND $where LIMIT 1";

            $myReportData = db()->query($sql);
            $myReportData[0]['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->count('a.id'); // 有安全隐患总数，仅统计总数时field非必需
            $myReportData = $this->getScale($myReportData); // 计算比例并赋值给$myReportData
            
            return $myReportData[0]; */
            // sql拼接大法！
            $sql = "SELECT *,
                    	ROUND(notVerifyNum/haveCheckedNum*100, 2) notVerifyNumScale,
                    	ROUND(passNum/haveCheckedNum*100, 2) passNumScale,
                    	ROUND(notPassNum/haveCheckedNum*100, 2) notPassNumScale
                    FROM (
                    	SELECT COUNT(c.id) haveCheckedNum, ";
            $sql .= "SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum,
                    		SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0	END) passNum,
                    		SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0	END) notPassNum,
                    		SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro ";
            $sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
                $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
            $sql .= "WHERE c.checkuserid = $checkuserid AND x.id = $aid ";
            $sql .= "LIMIT 1
                    ) f";
            $myReportData = db()->query($sql);
            
            return $myReportData[0];
        }
        
        // 通过小区生成我的报表
        if (!empty($xid) && empty($wmy) && empty($startTime) && empty($endTime)){ // 注意区分自定义时间段加小区的情况，以及周月年加小区的情况
            /* $from = 'JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id';
            $where = "p.id = $xid"; // 小区id条件
            $sql = "SELECT COUNT(c.id) haveCheckedNum, SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum, SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0 END) passNum, SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0 END) notPassNum FROM yunaj_checkinfo c $from WHERE c.checkuserid = $checkuserid AND $where LIMIT 1";
            
            $myReportData = db()->query($sql);
            $myReportData[0]['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->count('a.id'); // 有安全隐患总数，仅统计总数时field非必需
            $myReportData = $this->getScale($myReportData); // 计算比例并赋值给$myReportData

            return $myReportData[0]; */
            // sql拼接大法！
            $sql = "SELECT *,
                    	ROUND(notVerifyNum/haveCheckedNum*100, 2) notVerifyNumScale,
                    	ROUND(passNum/haveCheckedNum*100, 2) passNumScale,
                    	ROUND(notPassNum/haveCheckedNum*100, 2) notPassNumScale
                    FROM (
                    	SELECT COUNT(c.id) haveCheckedNum, ";
            $sql .= "SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum,
                    		SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0	END) passNum,
                    		SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0	END) notPassNum,
                    		SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro ";
            $sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
            $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
            $sql .= "WHERE c.checkuserid = $checkuserid AND p.id = $xid ";
            $sql .= "LIMIT 1
                    ) f";
            $myReportData = db()->query($sql);
            
            return $myReportData[0];
        }
        
        // 通过周月年生成我的报表
        if (!empty($wmy)){
            
            // sql拼接大法！
            $sql = "SELECT *,
                    	ROUND(notVerifyNum/haveCheckedNum*100, 2) notVerifyNumScale,
                    	ROUND(passNum/haveCheckedNum*100, 2) passNumScale,
                    	ROUND(notPassNum/haveCheckedNum*100, 2) notPassNumScale
                    FROM (
                    	SELECT COUNT(c.id) haveCheckedNum, ";
            if ($wmy === 'w'){ // 本周
                /*
                $myReportData['haveCheckedNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid])->whereTime('checktime', 'w')->count(); // 已检查总数
                $myReportData['notVerifyNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 0])->whereTime('checktime', 'w')->count(); // 未审核总数
                $myReportData['passNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 1])->whereTime('checktime', 'w')->count(); // 已通过审核总数
                $myReportData['notPassNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => -1])->whereTime('checktime', 'w')->count(); // 未通过审核总数
                $myReportData['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->whereTime('checktime', 'w')->count('a.id'); // 有安全隐患总数
                */
                // $from = 'JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id';
                /* $from = '';
                $where = 1; // 未指定地点，1始终成立
                $sum = "COUNT(c.id) haveCheckedNum, SUM(CASE WHEN c.status = 0 AND WEEK('c.checktime') = WEEK(NOW()) THEN 1 ELSE 0 END) notVerifyNum, SUM(CASE WHEN c.status = 1 AND WEEK('c.checktime') = WEEK(NOW()) THEN 1 ELSE 0 END) passNum, SUM(CASE WHEN c.status = -1 AND WEEK('c.checktime') = WEEK(NOW()) THEN 1 ELSE 0 END) notPassNum"; // 本周数据
                $sql = "SELECT $sum FROM yunaj_checkinfo c $from WHERE c.checkuserid = $checkuserid AND $where LIMIT 1";
                $myReportData = db()->query($sql);
                $myReportData[0]['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->count('a.id'); // 有安全隐患总数，仅统计总数时field非必需 */
                $week = "AND WEEK(NOW())= WEEK(FROM_UNIXTIME(c.checktime, '%Y-%m-%d %H:%i:%s'))";
                $sql .= "SUM(CASE WHEN (c.status = 0 $week) THEN 1 ELSE 0 END) notVerifyNum,
                    		SUM(CASE WHEN (c.status = 1 $week) THEN 1 ELSE 0	END) passNum,
                    		SUM(CASE WHEN (c.status = -1 $week) THEN 1 ELSE 0	END) notPassNum,
                    		SUM(CASE WHEN (d.check_id IS NOT NULL) THEN 1 ELSE 0	END) havePro "; // bug
                $sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
                if (!empty($aid) || !empty($xid)){ // 区域或小区条件
                    $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
                }
                $sql .= "WHERE c.checkuserid = $checkuserid ";
                if (!empty($aid)){ // 区域条件
                    $sql .= "AND x.id = $aid "; // 注意各种空格
                }
                if (!empty($xid)){ // 小区条件
                    $sql .= "AND p.id = $xid ";
                }
                $sql .= "LIMIT 1
                    ) f";
            } else if ($wmy === 'm') { // 本月
                /* $myReportData['haveCheckedNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid])->whereTime('checktime', 'm')->count(); // 已检查总数
                $myReportData['notVerifyNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 0])->whereTime('checktime', 'm')->count(); // 未审核总数
                $myReportData['passNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 1])->whereTime('checktime', 'm')->count(); // 已通过审核总数
                $myReportData['notPassNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => -1])->whereTime('checktime', 'm')->count(); // 未通过审核总数
                $myReportData['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->whereTime('checktime', 'm')->count('a.id'); // 有安全隐患总数 */
                $month = "AND MONTH(FROM_UNIXTIME(c.checktime, '%Y-%m-%d %H:%i:%s')) = MONTH(NOW())";
                $sql .= "SUM(CASE WHEN c.status = 0 $month THEN 1 ELSE 0 END) notVerifyNum,
                SUM(CASE WHEN c.status = 1 $month THEN 1 ELSE 0	END) passNum,
                SUM(CASE WHEN c.status = -1 $month THEN 1 ELSE 0	END) notPassNum,
                SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro "; // bug
                $sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
                if (!empty($aid) || !empty($xid)){ // 区域或小区条件
                    $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
                }
                $sql .= "WHERE c.checkuserid = $checkuserid ";
                if (!empty($aid)){ // 区域条件
                    $sql .= "AND x.id = $aid "; // 注意各种空格
                }
                if (!empty($xid)){ // 小区条件
                    $sql .= "AND p.id = $xid ";
                }
                $sql .= "LIMIT 1
                    ) f";
            } else if ($wmy === 'y') { // 今年
                /* $myReportData['haveCheckedNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid])->whereTime('checktime', 'y')->count(); // 已检查总数
                $myReportData['notVerifyNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 0])->whereTime('checktime', 'y')->count(); // 未审核总数
                $myReportData['passNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => 1])->whereTime('checktime', 'y')->count(); // 已通过审核总数
                $myReportData['notPassNum'] = db('checkinfo')->where(['checkuserid' => $checkuserid, 'status' => -1])->whereTime('checktime', 'y')->count(); // 未通过审核总数
                $myReportData['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->whereTime('checktime', 'y')->count('a.id'); // 有安全隐患总数 */
                $year = "AND YEAR(FROM_UNIXTIME(c.checktime, '%Y-%m-%d %H:%i:%s')) = YEAR(NOW())";
                $sql .= "SUM(CASE WHEN c.status = 0 $year THEN 1 ELSE 0 END) notVerifyNum,
                SUM(CASE WHEN c.status = 1 $year THEN 1 ELSE 0	END) passNum,
                SUM(CASE WHEN c.status = -1 $year THEN 1 ELSE 0	END) notPassNum,
                SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro "; // bug
                $sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
                if (!empty($aid) || !empty($xid)){ // 区域或小区条件
                    $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
                }
                $sql .= "WHERE c.checkuserid = $checkuserid ";
                if (!empty($aid)){ // 区域条件
                    $sql .= "AND x.id = $aid "; // 注意各种空格
                }
                if (!empty($xid)){ // 小区条件
                    $sql .= "AND p.id = $xid ";
                }
                $sql .= "LIMIT 1
                    ) f";
            }
            
            // 计算比例
            /* $myReportData = $this->getScale($myReportData); // 计算比例并赋值给$myReportData
            
            return $myReportData[0]; */
            $myReportData = db()->query($sql);
            
            return $myReportData[0];
        }
        
        // 自定义时间段筛选
        if (!empty($startTime) && !empty($endTime)){
            /* $sql = "SELECT COUNT(c.id) haveCheckedNum, SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum, SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0 END) passNum, SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0 END) notPassNum FROM yunaj_checkinfo c WHERE c.checkuserid = $checkuserid AND checktime BETWEEN $startTime AND $endTime LIMIT 1";
            $myReportData = db()->query($sql);
            $myReportData[0]['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->count('a.id'); // 有安全隐患总数，仅统计总数时field非必需
            $myReportData = $this->getScale($myReportData); // 计算比例并赋值给$myReportData */
            
            // sql拼接大法！
            $sql = "SELECT *,
                    	ROUND(notVerifyNum/haveCheckedNum*100, 2) notVerifyNumScale,
                    	ROUND(passNum/haveCheckedNum*100, 2) passNumScale,
                    	ROUND(notPassNum/haveCheckedNum*100, 2) notPassNumScale
                    FROM (
                    	SELECT COUNT(c.id) haveCheckedNum, ";
                        $sql .= "SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum,
                    		SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0	END) passNum,
                    		SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0	END) notPassNum,
                    		SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro ";
                    	$sql .= "FROM yunaj_checkinfo c
                    	LEFT JOIN (
                    		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                    	) d ON c.id = d.check_id ";
                    	if (!empty($aid) || !empty($xid)){ // 区域或小区条件
                    	    $sql .= "JOIN yunaj_room r ON r.id = c.room_id JOIN yunaj_project p ON p.id = r.proj_id JOIN yunaj_xzqy x ON x.id = p.xzqy_id "; // 关联各种地址表，注意尾部空格
                    	}
                    	$sql .= "WHERE c.checkuserid = $checkuserid AND checktime BETWEEN $startTime AND $endTime ";
                    	if (!empty($aid)){ // 区域条件
                    	    $sql .= "AND x.id = $aid "; // 注意各种空格
                    	}
                    	if (!empty($xid)){ // 小区条件
                    	    $sql .= "AND p.id = $xid ";
                    	}
                    	$sql .= "LIMIT 1
                    ) f";
            $myReportData = db()->query($sql);

            return $myReportData[0];
        }

        // 不加限制的所有记录报表
        // $sql = "SELECT COUNT(c.id) haveCheckedNum, SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum, SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0 END) passNum, SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0 END) notPassNum FROM yunaj_checkinfo c WHERE c.checkuserid = $checkuserid LIMIT 1";
        /* $sql = "SELECT COUNT(c.id) haveCheckedNum, 
                SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum,
                SUM(CASE WHEN c. STATUS = 1 THEN 1 ELSE 0	END) passNum,
                SUM(CASE WHEN c. STATUS = -1 THEN 1 ELSE 0	END) notPassNum,
                SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro
                FROM yunaj_checkinfo c
                LEFT JOIN (
                	SELECT check_id, COUNT(*) numAll FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                ) d ON c.id = d.check_id
                WHERE c.checkuserid = 7 LIMIT 1"; */
        $sql = "SELECT *,
                	ROUND(notVerifyNum/haveCheckedNum*100, 2) notVerifyNumScale,
                	ROUND(passNum/haveCheckedNum*100, 2) passNumScale,
                	ROUND(notPassNum/haveCheckedNum*100, 2) notPassNumScale
                FROM (
                	SELECT COUNT(c.id) haveCheckedNum,
                		SUM(CASE WHEN c.status = 0 THEN 1 ELSE 0 END) notVerifyNum,
                		SUM(CASE WHEN c.status = 1 THEN 1 ELSE 0	END) passNum,
                		SUM(CASE WHEN c.status = -1 THEN 1 ELSE 0	END) notPassNum,
                		SUM(CASE WHEN d.check_id IS NOT NULL THEN 1 ELSE 0	END) havePro
                	FROM yunaj_checkinfo c
                	LEFT JOIN (
                		SELECT check_id, COUNT(*) allNum FROM yunaj_checkproblem p WHERE p.answer = 0 GROUP BY check_id
                	) d ON c.id = d.check_id
                	WHERE c.checkuserid = $checkuserid LIMIT 1
                ) f";
        $myReportData = db()->query($sql);
//         p($sql);
        // $myReportData[0]['havePro'] = db('checkinfo')->alias('a')->join('yunaj_checkproblem b','a.id = b.check_id')->group('b.answer, b.check_id')->where(['a.checkuserid' => $checkuserid, 'b.answer' => 0])->count('a.id'); // 有安全隐患总数，仅统计总数时field非必需
        // $myReportData = $this->getScale($myReportData); // 计算比例并赋值给$myReportData
// p($myReportData);
        return $myReportData[0];
    }
    
    // 计算比例
    /* public function getScale($data)
    {
        if ($data[0]['haveCheckedNum'] !== 0){ // 分母不为0
            $data[0]['notVerifyNumScale'] = sprintf('%01.1f', ($data[0]['notVerifyNum']/$data[0]['haveCheckedNum'])*100).'%'; // 未审核所占比例
            $data[0]['passNumScale'] = sprintf('%01.1f', ($data[0]['passNum']/$data[0]['haveCheckedNum'])*100).'%'; // 已通过所占比例
            $data[0]['notPassNumScale'] = sprintf('%01.1f', ($data[0]['notPassNum']/$data[0]['haveCheckedNum'])*100).'%'; // 未通过所占比例
        } else {
            $data[0]['notVerifyNumScale'] = '无数据';
            $data[0]['passNumScale'] = '无数据';
            $data[0]['notPassNumScale'] = '无数据';
        }
        
        return $data;
    } */
}