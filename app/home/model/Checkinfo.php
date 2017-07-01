<?php
/**
 * 该模型对应yunaj_checkinfo表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;

class Checkinfo extends Model
{
    /**
     * 获取房间历史检查记录
     * @param string $cstcode 用户编号
     * @return array
     * 
     */
    public function getRoomLog($cstcode)
    {
        /* ->where($where)
        ->where($where2)
        ->where($whereForSearch1)
        ->whereOr($whereForSearch2)
        ->page($page, $row)
         */
        $data = [];
        $data['list'] = db('checkinfo')->alias('e')
            ->join('yunaj_room r', 'r.id = e.room_id')
            ->join('yunaj_project p', 'r.proj_id = p.id')
            ->join('yunaj_build b', 'r.bld_id = b.id')
            ->join('yunaj_xzqy x', 'p.xzqy_id = x.id')
            ->join('yunaj_xzqy s', 's.id = x.parent_id')
            ->join('yunaj_csdetail c', 'c.id = r.brand', 'left')
            ->join('yunaj_csdetail m', 'm.id = r.type', 'left')
            ->join('yunaj_user u', 'u.id = e.checkuserid', 'left')
            ->join('yunaj_user g', 'g.id = e.audituserid', 'left')
            ->join('yunaj_checkphoto t', 't.check_id = e.id', 'left')
            ->field('r.id, x.name areaName, p.name xqName, b.name dong, r.unit, r.room, r.cstcode, r.cstname, r.telphone, r.type, r.brand, r.direction, r.basenumber, c.name brandName, m.name typeName, e.status, e.audittime, e.checktime, u.name checkUserName, g.name auditUserName')        
            ->select();
//         p($data['list']);
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
     * 添加检查记录
     * @param $data 各种检查记录信息
     * return int save方法新增数据返回的是写入的记录数，但我这里返回自增id
     *
     */
    public function addCheckInfo($data)
    {
        $this->allowField(true)->save($data); // 添加数据到记录表，过滤post数组中的非数据表字段数据
        $check_id = $this->id;
        return $check_id;
    }
}