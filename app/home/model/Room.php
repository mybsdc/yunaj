<?php
/**
 * 该模型对应yunaj_room表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;

class Room extends Model
{
    /**
     * 未检查列表
     * @param int $page 第几页
     * @param int $row 每页显示行数
     * @param int $city_id 城市id
     * @param int $area_id 区域id
     * @param int $xq_id 小区id
     * @param int $task_id 任务id
     * @param bool $toExcel 是否生成Excel文件
     * @param string $toSearch 房号或卡号
     * @param int $status 状态码 0 待审核 1 通过审核 -1 未通过审核
     * return array
     * 
     */
    public function notCheckList($page = 1, $task_id = '', $city_id = '', $area_id = '', $xq_id = '', $toExcel = false, $toSearch = '', $status = '', $row = 1)
    {
        $where = []; // 条件
        $where2 = ''; // 任务条件
        $whereForTask = []; // 指定任务id或所有任务的数据
        $whereForSearch1 = []; // 搜索条件1
        $whereForSearch2 = []; // 搜索条件2
        $whereForStatus = []; // 状态条件，默认left查询
        $whereForSearch = []; // test 上面的搜索条件有个巨坑，OR两边本来是一个条件，硬生生被逼成两个，回去换原生
        
        // 获取任务对应的所有栋id
        $dong = []; // 储存栋id数组   
        if (!empty($task_id)){ // 指定任务id，不指定的话就获取所有任务数据
            $whereForTask = ['t.id' => $task_id];
        }
            
        // 获取参数类型
        $task_type = db('taskset')->alias('t')
            ->join('yunaj_task2ywmx f', 't.id = f.taskid')
            ->field('f.type, f.ywid')
            ->where($whereForTask)
            ->select();
// p($task_type);
        // 通过类型转栋id
        foreach ($task_type as $v){
            if ($v['type'] === 3){ // 这个情况ywid就是栋id
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
            }
        }
        $dong = array_unique($dong); // 数据去重
        $dong_id = implode(',', $dong); // 栋id集
        if (empty($dong_id)){ // 无任务的情况
            $dong_id = 0;
        }
//         p($dong_id);
        $where2 = "r.bld_id IN ($dong_id)"; // 拼接条件
        
        // 通过城市条件
        if (!empty($city_id)){
            $where = ['s.id' => $city_id]; // s是城市，x是区域
        }
        
        // 通过区域条件
        if (!empty($area_id)){
            $where = ['x.id' => $area_id]; // s是城市，x是区域
        }
        
        // 通过小区条件
        if (!empty($xq_id)){
            $where = ['p.id' => $xq_id];
        }
        
        // 通过房号或卡号搜索情况
        if (!empty($toSearch)){
            $whereForSearch1 = ['r.room'  =>  ['like', "%$toSearch%"]];
            $whereForSearch2 = ['r.cstcode'  =>  ['like', "%$toSearch%"]];
            $whereForSearch = "(`r`.`room` LIKE '%$toSearch%' OR `r`.`cstcode` LIKE '%$toSearch%')";
//             p($status);
        }
        
        $data = []; // 数据
        // 有状态传入，即根据审核情况取数据
//         $status = 0;
        if ($status !== ''){ // 这里有个坑，PHP中值为0等同于empty，所以这里不要用empty做判断
            $whereForStatus = ['n.status' => $status];
            if ($toExcel){ // 导出Excel情况，无需分页
                return db('room')->alias('r')
                ->join('yunaj_project p', 'r.proj_id = p.id')
                ->join('yunaj_build b', 'r.bld_id = b.id')
                ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
                ->join('yunaj_xzqy s', 's.id = x.parent_id')
                ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
                ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
                ->join('yunaj_checkinfo n', 'n.room_id = r.id')
                ->field('r.id, x.name areaName, n.status, n.id check_id, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
                ->where($where)
                ->where($where2)
                ->where($whereForStatus)
                ->where($whereForSearch)
                ->select();
            }
            $data['list'] = db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->join('yunaj_checkinfo n', 'n.room_id = r.id')
            ->field('r.id, x.name areaName, n.status, n.id check_id, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where($where)
            ->where($where2)
            ->where($whereForStatus)
            ->where($whereForSearch)
            ->page($page, $row)
            ->select();
            $data['count'] = db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->join('yunaj_checkinfo n', 'n.room_id = r.id')
            ->field('r.id, x.name areaName, n.status, n.id check_id, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where($where)
            ->where($where2)
            ->where($whereForStatus)
            ->where($whereForSearch)
            ->count();
            $data['pageNum'] = ceil($data['count']/$row); // 总页数
            
            //         p($data);
            return $data;
        }
        
        // 无状态码，即待检查列表
        if ($toExcel){ // 导出Excel情况，无需分页
            return db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->join($join)
            ->field('r.id, x.name areaName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where($where)
            ->where($where2)
            ->where($whereForSearch1)
            ->whereOr($whereForSearch2)
            ->select();
        }
        $data['list'] = db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->field('r.id, x.name areaName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where($where)
            ->where($where2)
            ->where($whereForSearch1)
            ->whereOr($whereForSearch2)
            ->page($page, $row)
            ->select();
        
       /*     
        $data['count'] = db('room')->alias('r')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->field('r.id, x.name areaName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where($where)
            ->where($where2)
            ->where($whereForSearch1)
            ->whereOr($whereForSearch2)
            ->where($whereForStatus)
            ->count();
        $data['pageNum'] = ceil($data['count']/$row); // 总页数 
        */
        
        p($data);
        return $data;
    }
    
    /**
     * 获取房间基本信息
     * @param int $cstcode 用户编号
     * return array
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
     * return array
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
            ->field('a.checktime, u.name checker, x.name areaName, r.basenumber, s.name cityName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, c.name brandName, m.name typeName')
            ->where(['a.id' => $id])
            ->find();
    }
}