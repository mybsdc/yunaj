<?php
/**
 * 该模型对应yunaj_room表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;
use think\db\Query;

class Room extends Model
{
    /**
     * 获取房间基本信息
     * @param int $cstcode 用户编号
     * @return array
     *
     */
    public function getRoomInfo($cstcode)
    {
        return db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->field('r.id, x.name areaName, r.basenumber, s.name cityName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where(['r.cstcode' => $cstcode])
            ->find();
    }
    
    /**
     * 获取某条检查记录基本信息
     * @param int $id 检查记录id
     * @return array
     * 这里只需传入记录id，无需传入状态，状态在外层逻辑中已控制
     *
     */
    public function getCheckInfo($id)
    {
        return db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->join('yunaj_checkinfo a', 'a.cstcode = r.cstcode')
            ->join('yunaj_user u', 'u.id = a.checkuserid')
            ->field('a.checktime, r.is_change, a.room_id, u.name checker, x.name areaName, r.basenumber, s.name cityName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where(['a.id' => $id])
            ->find();
    }
    
    /**
     * 未检查列表以及通过状态获取其他列表
     * @param int $page 第几页
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * @param int $status 状态码 0 待审核 1 通过审核 -1 未通过审核
     * @return array
     *
     */
    public function notCheckList($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '')
    {
        // 每页条数
        $row = config('row');
        
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组
        $whereForTask = []; // 指定任务id，默认无此条件获取所有任务的数据
        $startTime = db('taskset')->min('bgndate'); // 所有任务中最小开始时间
        $endTime = db('taskset')->max('enddate'); // 所有任务中最大结束时间
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            $whereForTask = ['t.id' => $task_id];
            $startTime = db('taskset')->where(['id' => $task_id])->value('bgndate'); // 任务开始时间 => 指定任务id的情况
            $endTime = db('taskset')->where(['id' => $task_id])->value('enddate'); // 任务结束时间
        }
        
        // 获取参数类型
        $uid = session('uid');
//         $uid = 8;
        $task_type = db('taskset')->alias('t')
            ->join('yunaj_task2ywmx f', 't.id = f.taskid')
            ->join('yunaj_task2czr u', 't.id = u.taskid')
            ->field('f.type, f.ywid')
            ->where(['u.czrid' => $uid])
            ->where(['t.status' => '1'])
            ->where($whereForTask)
            ->select();
// p($task_type);
        // 通过类型转栋id
        foreach ($task_type as $v){
            /* if ($v['type'] === 3){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 1){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                ->join('yunaj_project p', 'p.xzqy_id = x.id')
                ->join('yunaj_build b', 'b.proj_id = p.id')
                ->field('b.id')
                ->where(['x.id' => $v['ywid']])
                ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            } */
            if ($v['type'] === 1){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 3){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                    ->join('yunaj_project p', 'p.xzqy_id = x.id')
                    ->join('yunaj_build b', 'b.proj_id = p.id')
                    ->field('b.id')
                    ->where(['x.id' => $v['ywid']])
                    ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
            $startTime = 0; // 解决无任务情况下的报错
            $endTime = 1;
        }
        $pageStart = ($page - 1) * $row; // 分页开始处
//         p($pageStart);
        $sql = "SELECT
        	r.id,
        	area. NAME areaName,
        	p.name xqName,
        	b.name dong,
        	r.unit,
        	r.room,
        	r.cstcode,
        	r.cstname,
        	r.telphone,
        	r.type,
        	r.brand,
        	r.direction,
        	brand.name brandName,
        	type.name typeName,
        	info.id check_id
        FROM
        	yunaj_room r
        JOIN yunaj_project p ON r.proj_id = p.id
        JOIN yunaj_build b ON r.bld_id = b.id
        JOIN yunaj_xzqy area ON p.xzqy_id = area.id
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_checkinfo info ON info.room_id = r.id
        WHERE r.bld_id IN ($dong_id)";
        if ($status !== ''){ // 传入检查状态，这里有个坑，PHP中值为0等同于empty，所以这里不要用empty做判断
            $sql .= " AND info.status = '$status' AND info.checktime BETWEEN $startTime AND $endTime AND info.checkuserid = '$uid'"; // 已限定在任务时间区间内，checkuserid限定只能看到自己的检查记录
        } else { // 待检查
            $sql .= " AND (info.id IS NULL OR info.checktime NOT BETWEEN $startTime AND $endTime)"; // 同上，已限定时间
//             p($sql);
        }
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        if ($status !== ''){ // 有检查状态的，数据按时间倒序排列
            $sql .= " ORDER BY info.checktime DESC";
        }
        if ($toExcel){ // 导出Excel情况，无需分页
            return db()->query($sql);
        } else {
            $sql .= " LIMIT $pageStart, $row";
        }
        $data['list'] = db()->query($sql);
//         p($sql);
        
        // 总条数
        $sql = "SELECT
        COUNT(*) countNum
        FROM
        yunaj_room r
        JOIN yunaj_project p ON r.proj_id = p.id
        JOIN yunaj_build b ON r.bld_id = b.id
        JOIN yunaj_xzqy area ON p.xzqy_id = area.id
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_checkinfo info ON info.room_id = r.id
        WHERE r.bld_id IN ($dong_id)";
        if ($status !== ''){ // 传入检查状态，这里有个坑，PHP中值为0等同于empty，所以这里不要用empty做判断
            $sql .= " AND info.status = '$status' AND info.checktime BETWEEN $startTime AND $endTime AND info.checkuserid = '$uid'"; // 考虑到可能同一任务多个人的情况，每个人只能看到自己的非待检查记录
        } else { // 待检查
            $sql .= " AND (info.id IS NULL OR info.checktime NOT BETWEEN $startTime AND $endTime)"; // 同上，已限定时间
        }
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $data['count'] = db()->query($sql)[0]['countNum'];
        $data['pageNum'] = ceil($data['count'] / $row); // 总页数
//         p($data);
        return $data;
    }
    
    /**
     * 无图片待审核列表
     * @param int $page 第几页
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * @param int $status 状态码 0 待审核 1 通过审核 -1 未通过审核
     * @return array
     *
     */
    public function notImg($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = 0)
    {
        // 每页条数
        $row = config('row');
    
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组
        $whereForTask = []; // 指定任务id，默认无此条件获取所有任务的数据
        $startTime = db('taskset')->min('bgndate'); // 所有任务中最小开始时间
        $endTime = db('taskset')->max('enddate'); // 所有任务中最大结束时间
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            $whereForTask = ['t.id' => $task_id];
            $startTime = db('taskset')->where(['id' => $task_id])->value('bgndate'); // 任务开始时间 => 指定任务id的情况
            $endTime = db('taskset')->where(['id' => $task_id])->value('enddate'); // 任务结束时间
        }
    
        // 获取参数类型
        $uid = session('uid');
        //         $uid = 8;
        $task_type = db('taskset')->alias('t')
        ->join('yunaj_task2ywmx f', 't.id = f.taskid')
        ->join('yunaj_task2czr u', 't.id = u.taskid')
        ->field('f.type, f.ywid')
        ->where(['u.czrid' => $uid])
        ->where(['t.status' => '1'])
        ->where($whereForTask)
        ->select();
        // p($task_type);
        // 通过类型转栋id
        foreach ($task_type as $v){
            if ($v['type'] === 1){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 3){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                ->join('yunaj_project p', 'p.xzqy_id = x.id')
                ->join('yunaj_build b', 'b.proj_id = p.id')
                ->field('b.id')
                ->where(['x.id' => $v['ywid']])
                ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
            $startTime = 0; // 解决无任务情况下的报错
            $endTime = 1;
        }
        $pageStart = ($page - 1) * $row; // 分页开始处
        //         p($pageStart);
        $sql = "SELECT
        r.id,
        area. NAME areaName,
        p.name xqName,
        b.name dong,
        r.unit,
        r.room,
        r.cstcode,
        r.cstname,
        r.telphone,
        r.type,
        r.brand,
        r.direction,
        brand.name brandName,
        type.name typeName,
        info.id check_id
        FROM
        yunaj_room r
        JOIN yunaj_project p ON r.proj_id = p.id
        JOIN yunaj_build b ON r.bld_id = b.id
        JOIN yunaj_xzqy area ON p.xzqy_id = area.id
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_checkinfo info ON info.room_id = r.id
        LEFT JOIN yunaj_checkphoto photo ON photo.check_id = info.id
        WHERE r.bld_id IN ($dong_id) AND photo.id IS NULL";
        if ($status !== ''){ // 传入检查状态，这里有个坑，PHP中值为0等同于empty，所以这里不要用empty做判断
            $sql .= " AND info.status = '$status' AND info.checktime BETWEEN $startTime AND $endTime AND info.checkuserid = '$uid'"; // 每个人只能看到自己的非待检查记录
        } else { // 待检查
            $sql .= " AND (info.id IS NULL OR info.checktime NOT BETWEEN $startTime AND $endTime)"; // 同上，已限定时间
            //             p($sql);
        }
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        if ($status !== ''){ // 有检查状态的，数据按时间倒序排列
            $sql .= " ORDER BY info.checktime DESC";
        }
        if ($toExcel){ // 导出Excel情况，无需分页
            return db()->query($sql);
        } else {
            $sql .= " LIMIT $pageStart, $row";
        }
        $data['list'] = db()->query($sql);
//                 p($sql);
    
        // 总条数
        $sql = "SELECT
        COUNT(*) countNum
        FROM
        yunaj_room r
        JOIN yunaj_project p ON r.proj_id = p.id
        JOIN yunaj_build b ON r.bld_id = b.id
        JOIN yunaj_xzqy area ON p.xzqy_id = area.id
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_checkinfo info ON info.room_id = r.id
        LEFT JOIN yunaj_checkphoto photo ON photo.check_id = info.id
        WHERE r.bld_id IN ($dong_id) AND photo.id IS NULL";
        if ($status !== ''){ // 传入检查状态，这里有个坑，PHP中值为0等同于empty，所以这里不要用empty做判断
            $sql .= " AND info.status = '$status' AND info.checktime BETWEEN $startTime AND $endTime AND info.checkuserid = '$uid'"; // 已限定在任务时间区间内
        } else { // 待检查
            $sql .= " AND (info.id IS NULL OR info.checktime NOT BETWEEN $startTime AND $endTime)"; // 同上，已限定时间
        }
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $data['count'] = db()->query($sql)[0]['countNum'];
        $data['pageNum'] = ceil($data['count'] / $row); // 总页数
        //         p($data);
        return $data;
    }
    
    /**
     * 获取检查审核管理页面数据，共三种状态：待审核，已通过审核，未通过审核
     * @param int $page 第几页
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * @param int $status 状态码 0 待审核 1 通过审核 -1 未通过审核
     * @return array
     *
     */
    public function auditor($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = 0)
    {
        // 每页条数
        $row = config('row');
        
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组
        $whereForTask = []; // 指定任务id，默认无此条件获取所有任务的数据
        $startTime = db('taskset')->min('bgndate'); // 所有任务中最小开始时间
        $endTime = db('taskset')->max('enddate'); // 所有任务中最大结束时间
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            $whereForTask = ['t.id' => $task_id];
            $startTime = db('taskset')->where(['id' => $task_id])->value('bgndate'); // 任务开始时间 => 指定任务id的情况
            $endTime = db('taskset')->where(['id' => $task_id])->value('enddate'); // 任务结束时间
        }
    
        // 获取参数类型
        $uid = session('uid');
//         $uid = 8;
        $task_type = db('taskset')->alias('t')
            ->join('yunaj_task2ywmx f', 't.id = f.taskid')
            ->join('yunaj_task2czr u', 't.id = u.taskid')
            ->field('f.type, f.ywid')
            ->where(['u.czrid' => $uid])
            ->where(['t.status' => '1'])
            ->where($whereForTask)
            ->select();
    
        // 通过类型转栋id
        foreach ($task_type as $v){
            if ($v['type'] === 1){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 3){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                ->join('yunaj_project p', 'p.xzqy_id = x.id')
                ->join('yunaj_build b', 'b.proj_id = p.id')
                ->field('b.id')
                ->where(['x.id' => $v['ywid']])
                ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
            $startTime = 0; // 解决无任务情况下的报错
            $endTime = 1;
        }
        $data = [];
        $pageStart = ($page - 1) * $row; // 分页开始处
        //         p($pageStart);
//         $status = 1;
//         $city_id = 1;
//         $area_id = 5;
//         $xq_id = 1;
//         $toSearch = 2206;
//         $toExcel = true;
        $sql = "SELECT
            city.name cityName,
        	area.name areaName,
        	p.name xqName,
        	b.name dong,
        	r.unit,
        	r.room,
        	r.cstcode,
        	r.basenumber,
        	(CASE WHEN photo.imgNum IS NOT NULL THEN photo.imgNum ELSE 0 END) imgNum,
        	r.cstname,
        	r.telphone,
        	CONCAT_WS('-', type.name, brand.name, r.direction) qbInfo,
        	u.name checkuser,
        	FROM_UNIXTIME(c.checktime, '%Y-%m-%d %H:%i') checktime,
        	c.id check_id,
        	r.id room_id,
        	r.is_change,
        	r.type,
        	r.brand,
        	r.direction,
        	FROM_UNIXTIME(c.audittime, '%Y-%m-%d') audittime
        FROM
        	yunaj_xzqy area
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        JOIN yunaj_project p ON p.xzqy_id = area.id
        JOIN yunaj_build b ON b.proj_id = p.id
        JOIN yunaj_room r ON r.bld_id = b.id
        LEFT JOIN yunaj_checkinfo c ON c.room_id = r.id
        LEFT JOIN (
        	SELECT
        		check_id,
        		COUNT(*) imgNum
        	FROM
        		yunaj_checkphoto photo
        	GROUP BY
        		check_id
        ) photo ON photo.check_id = c.id
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        JOIN yunaj_user u ON c.checkuserid = u.id
        WHERE
        	r.bld_id IN ($dong_id) AND c.status = '$status' AND c.checktime BETWEEN $startTime AND $endTime"; // 这里必定带状态，无需考虑待检查列表，尼玛数据都不一样，这里的status默认等于0，待审核
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
//         p($status);
        if ($status != 0){ // 其他审核状态的按审核时间倒序 => ps: 这里不要用“===”，因为从前台传过来的分页数据请求是字符串的0，你妹的
            $sql .= " ORDER BY c.audittime DESC";
        } else {
            $sql .= " ORDER BY c.checktime DESC"; // 待审核的按检查时间倒序
        }
        if ($toExcel){ // 导出Excel情况，无需分页
            return db()->query($sql);
        } else {
            $sql .= " LIMIT $pageStart, $row";
        }
        $data['list'] = db()->query($sql);
//         p($sql);
        // 总条数
        $sql = "SELECT
            COUNT(*) countNum
        FROM
            yunaj_xzqy area
            JOIN yunaj_xzqy city ON city.id = area.parent_id
            JOIN yunaj_project p ON p.xzqy_id = area.id
            JOIN yunaj_build b ON b.proj_id = p.id
            JOIN yunaj_room r ON r.bld_id = b.id
            LEFT JOIN yunaj_checkinfo c ON c.room_id = r.id
            LEFT JOIN (
            SELECT
            check_id,
            COUNT(*) imgNum
            FROM
            yunaj_checkphoto photo
            GROUP BY
            check_id
            ) photo ON photo.check_id = c.id
            LEFT JOIN yunaj_csdetail type ON type.id = r.type
            LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
            JOIN yunaj_user u ON c.checkuserid = u.id
        WHERE
            r.bld_id IN ($dong_id) AND c.status = '$status' AND c.checktime BETWEEN $startTime AND $endTime"; // 这里必定带状态，无需考虑待检查列表，尼玛数据都不一样，这里的status默认等于0，待审核
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $data['count'] = db()->query($sql)[0]['countNum'];
        $data['pageNum'] = ceil($data['count'] / $row); // 总页数
//         p($data);
        return $data;
    }
    
    /**
     * 获取所有数据 - 台账 - 以检查记录为显示维度
     * @param int $page 第几页
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * @return array
     * 
     */
    public function getAllData($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '')
    {
        // 每页条数
        $row = config('row');
        
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组
        $whereForTask = []; // 指定任务id，默认无此条件获取所有任务的数据
        $startTime = db('taskset')->min('bgndate'); // 所有任务中最小开始时间
        $endTime = db('taskset')->max('enddate'); // 所有任务中最大结束时间
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            $whereForTask = ['t.id' => $task_id];
            $startTime = db('taskset')->where(['id' => $task_id])->value('bgndate'); // 任务开始时间 => 指定任务id的情况
            $endTime = db('taskset')->where(['id' => $task_id])->value('enddate'); // 任务结束时间
        }
        
        // 获取参数类型
        $uid = session('uid');
//         $uid = 8;
        $task_type = db('taskset')->alias('t')
        ->join('yunaj_task2ywmx f', 't.id = f.taskid')
        ->join('yunaj_task2czr u', 't.id = u.taskid')
        ->field('f.type, f.ywid')
        ->where(['u.czrid' => $uid])
        ->where(['t.status' => '1'])
        ->where($whereForTask)
        ->select();
        
        // 通过类型转栋id
        foreach ($task_type as $v){
            if ($v['type'] === 1){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 3){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                ->join('yunaj_project p', 'p.xzqy_id = x.id')
                ->join('yunaj_build b', 'b.proj_id = p.id')
                ->field('b.id')
                ->where(['x.id' => $v['ywid']])
                ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
            $startTime = 0; // 解决无任务情况下的报错
            $endTime = 1;
        }
        $data = [];
        $pageStart = ($page - 1) * $row; // 分页开始处
        $sql = "SELECT
        	city. NAME cityName,
        	area. NAME areaName,
        	p. NAME xqName,
        	b. NAME dong,
        	r.unit,
        	r.room,
        	r.cstcode,
        	r.basenumber,
        	(
        		CASE
        		WHEN photo.imgNum IS NOT NULL THEN
        			photo.imgNum
        		ELSE
        			0
        		END
        	) imgNum,
        	r.cstname,
        	r.telphone,
        	CONCAT_WS(
        		'-',
        		type. NAME,
        		brand. NAME,
        		r.direction
        	) qbInfo,
        	u. NAME checkuser,
        	FROM_UNIXTIME(
        		c.checktime,
        		'%Y-%m-%d %H:%i'
        	) checktime,
        	c.id check_id,
        	r.id room_id,
        	r.is_change,
        	r.type,
        	r.brand,
        	r.direction,
        	FROM_UNIXTIME(c.audittime, '%Y-%m-%d') audittime,
        	(CASE WHEN c.status = 0 THEN '待审核' WHEN c.status = -1 THEN '未通过' ELSE '已通过' END) status,
        	c.status statusCode
        FROM
        	yunaj_xzqy area
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        JOIN yunaj_project p ON p.xzqy_id = area.id
        JOIN yunaj_build b ON b.proj_id = p.id
        JOIN yunaj_room r ON r.bld_id = b.id
        LEFT JOIN yunaj_checkinfo c ON c.room_id = r.id
        LEFT JOIN (
        	SELECT
        		check_id,
        		COUNT(*) imgNum
        	FROM
        		yunaj_checkphoto photo
        	GROUP BY
        		check_id
        ) photo ON photo.check_id = c.id
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        JOIN yunaj_user u ON c.checkuserid = u.id
        WHERE
        	r.bld_id IN ($dong_id) AND c.checktime BETWEEN $startTime AND $endTime";
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $sql .= " ORDER BY c.checktime DESC";
        if ($toExcel){ // 导出Excel情况，无需分页
            return db()->query($sql);
        } else {
            $sql .= " LIMIT $pageStart, $row";
        }
        $data['list'] = db()->query($sql);
        
        // 总条数
        $sql = "SELECT
            COUNT(*) countNum
        FROM
        	yunaj_xzqy area
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        JOIN yunaj_project p ON p.xzqy_id = area.id
        JOIN yunaj_build b ON b.proj_id = p.id
        JOIN yunaj_room r ON r.bld_id = b.id
        LEFT JOIN yunaj_checkinfo c ON c.room_id = r.id
        LEFT JOIN (
        	SELECT
        		check_id,
        		COUNT(*) imgNum
        	FROM
        		yunaj_checkphoto photo
        	GROUP BY
        		check_id
        ) photo ON photo.check_id = c.id
        LEFT JOIN yunaj_csdetail type ON type.id = r.type
        LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
        JOIN yunaj_user u ON c.checkuserid = u.id
        WHERE
        	r.bld_id IN ($dong_id) AND c.checktime BETWEEN $startTime AND $endTime";
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $data['count'] = db()->query($sql)[0]['countNum'];
        $data['pageNum'] = ceil($data['count'] / $row); // 总页数
//                 p($data);
        return $data;
    }
    
    /**
     * 获取所有数据 - 台账 - 以房间为显示维度
     * @param int $page 第几页
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * return array
     *
     */
    public function dataAsRoom($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '')
    {
        // 每页条数
        $row = config('row');
        
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组
        $whereForTask = []; // 指定任务id，默认无此条件获取所有任务的数据
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            
            // 按房间维度不需要任务开始和结束时间，有任务id指定房间所属楼栋就ok
            $whereForTask = ['t.id' => $task_id];
        }

        // 获取参数类型
        $uid = session('uid');
//         $uid = 8;
        $task_type = db('taskset')->alias('t')
        ->join('yunaj_task2ywmx f', 't.id = f.taskid')
        ->join('yunaj_task2czr u', 't.id = u.taskid')
        ->field('f.type, f.ywid')
        ->where(['u.czrid' => $uid])
        ->where(['t.status' => '1'])
        ->where($whereForTask)
        ->select();
    
        // 通过类型转栋id
        foreach ($task_type as $v){
            if ($v['type'] === 1){ // 这个情况ywid就是栋id
                $dong[] = $v['ywid'];
            } else if ($v['type'] === 2){ // 这个情况ywid就是小区id
                $temp = db('build')->where(['proj_id' => $v['ywid']])->field('id')->select(); // 通过小区获取所有栋id
                foreach ($temp as $v2){
                    $dong[] = $v2['id'];
                }
            } else if ($v['type'] === 3){ // 这个情况ywid就是区域id
                $temp2 = db('xzqy')->alias('x')
                ->join('yunaj_project p', 'p.xzqy_id = x.id')
                ->join('yunaj_build b', 'b.proj_id = p.id')
                ->field('b.id')
                ->where(['x.id' => $v['ywid']])
                ->select();
                foreach ($temp2 as $v3){
                    $dong[] = $v3['id'];
                }
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
            $startTime = 0; // 解决无任务情况下的报错
            $endTime = 1;
        }
        $data = [];
        $pageStart = ($page - 1) * $row; // 分页开始处
        $sql = "SELECT
        	area. NAME areaName,
        	p. NAME xqName,
        	b. NAME dong,
        	r.unit,
        	r.room,
        	r.cstcode,
        	r.basenumber,
        	r.cstname,
        	r.telphone,
        	type. NAME typeName,
        	brand. NAME brandName,
        	r.direction,
        	(
        		CASE
        		WHEN c.logNum IS NULL THEN
        			0
        		ELSE
        			c.logNum
        		END
        	) logNum
        FROM
        	yunaj_xzqy area
        	JOIN yunaj_xzqy city ON city.id = area.parent_id
            JOIN yunaj_project p ON p.xzqy_id = area.id
            JOIN yunaj_build b ON b.proj_id = p.id
            JOIN yunaj_room r ON r.bld_id = b.id
            LEFT JOIN yunaj_csdetail type ON type.id = r.type
            LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
            LEFT JOIN (
            	SELECT
            		COUNT(*) logNum,
            		c.room_id
            	FROM
            		yunaj_checkinfo c
            	GROUP BY
            		c.room_id
            ) c ON c.room_id = r.id
        WHERE
        r.bld_id IN ($dong_id)";
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        if ($toExcel){ // 导出Excel情况，无需分页
            return db()->query($sql);
        } else {
            $sql .= " LIMIT $pageStart, $row";
        }
        $data['list'] = db()->query($sql);
    
        // 总条数
        $sql = "SELECT
            COUNT(*) countNum
        FROM
        	yunaj_xzqy area
        	JOIN yunaj_xzqy city ON city.id = area.parent_id
            JOIN yunaj_project p ON p.xzqy_id = area.id
            JOIN yunaj_build b ON b.proj_id = p.id
            JOIN yunaj_room r ON r.bld_id = b.id
            LEFT JOIN yunaj_csdetail type ON type.id = r.type
            LEFT JOIN yunaj_csdetail brand ON brand.id = r.brand
            LEFT JOIN (
            	SELECT
            		COUNT(*) logNum,
            		c.room_id
            	FROM
            		yunaj_checkinfo c
            	GROUP BY
            		c.room_id
            ) c ON c.room_id = r.id
        WHERE
            r.bld_id IN ($dong_id)";
        if (!empty($city_id)){ // 通过城市条件
            $sql .= " AND city.id = '$city_id'";
        }
        if (!empty($area_id)){ // 通过区域条件
            $sql .= " AND area.id = '$area_id'";
        }
        if (!empty($xq_id)){ // 通过小区条件
            $sql .= " AND p.id = '$xq_id'";
        }
        if (!empty($toSearch)){ // 通过房号或卡号搜索
            $sql .= " AND (r.room LIKE '%$toSearch%' OR r.cstcode LIKE '%$toSearch%')";
        }
        $data['count'] = db()->query($sql)[0]['countNum'];
        $data['pageNum'] = ceil($data['count'] / $row); // 总页数
//         p($sql);
//                         p($data);
        return $data;
    }
    
    /**
     * 更新房间信息
     * @param int $cstcode 房间编号
     * @param array $data 房间各种数据
     * return int 影响条数，这里没返回对象也是没谁了
     * 
     */
    public function updateRoomInfo($cstcode, $data)
    {
        return $this->allowField(true)->save($data, ['cstcode' => $cstcode]); // 暂时只允许修改表底数，其他信息也可以放开的
    }
}