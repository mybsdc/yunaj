<?php
/**
 * 该模型对应yunaj_checkinfo表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;
use think\db\Query;

class Checkinfo extends Model
{
    /**
     * 获取房间基本信息
     * @param string $cstcode 用户编号
     * @return array
     * 
     */
    public function getBaseInfo($cstcode)
    {
        $sql = "SELECT
        	city. NAME cityName,
        	area. NAME areaName,
        	p. NAME xqName,
        	b. NAME dong,
        	r.unit,
        	r.room,
        	r.cstname,
        	r.telphone,
        	r.cstcode,
        	r.basenumber,
        	type. NAME typeName,
        	brand. NAME brandName,
        	r.direction,
        	r.type,
        	r.brand
        FROM
        	yunaj_room r
        JOIN yunaj_project p ON p.id = r.proj_id
        JOIN yunaj_xzqy area ON p.xzqy_id = area.id
        JOIN yunaj_xzqy city ON city.id = area.parent_id
        JOIN yunaj_build b ON b.id = r.bld_id
        LEFT JOIN yunaj_csdetail type ON r.type = type.id
        LEFT JOIN yunaj_csdetail brand ON r.brand = brand.id
        WHERE
        	r.cstcode = $cstcode
        LIMIT 1";
        return db()->query($sql);
    }
    
    /**
     * 获取房间历史检查记录
     * @param string $cstcode 用户编号
     * @param bool $getCount 判断是否只获取总页数与总条数
     * @param int $page 第几页
     * @return array
     * 
     */
    public function getRoomLog($cstcode, $getCount = false, $page = 1)
    {
        // 每页条数
        $row = config('row');
        
        // 只获取总页数与总条数
        $toPage = [];
        if ($getCount){
            $sql = "SELECT
                COUNT(*) countNum
            FROM
                yunaj_checkinfo c
                LEFT JOIN (
                SELECT
                check_id,
                COUNT(*) imgNum
                FROM
                yunaj_checkphoto photo
                GROUP BY
                check_id
                ) photo ON photo.check_id = c.id
                LEFT JOIN (
                SELECT
                check_id,
                GROUP_CONCAT(
                question,
                '：',
                SUBSTRING_INDEX(
                (
                CASE
                WHEN pro.answer = 0 THEN
                answername
                END
                ),
                '|',
                -1
                ) SEPARATOR ','
                ) proInfo
                FROM
                yunaj_checkproblem pro
                GROUP BY
                check_id
                ) pro ON pro.check_id = c.id
                LEFT JOIN yunaj_user u ON u.id = c.checkuserid
                LEFT JOIN yunaj_user uu ON uu.id = c.audituserid
            WHERE
                c.cstcode = $cstcode";
            $toPage['count'] = db()->query($sql)[0]['countNum'];
            $toPage['pageNum'] = ceil($toPage['count'] / $row);
            return $toPage;
        }
        
        $pageStart = ($page - 1) * $row; // 分页开始处
        $sql = "SELECT
        	u. NAME checkuser,
        	uu. NAME audituser,
        	FROM_UNIXTIME(
        		c.checktime,
        		'%Y-%m-%d %H:%i'
        	) checktime,
        	FROM_UNIXTIME(
        		c.audittime,
        		'%Y-%m-%d %H:%i'
        	) audittime,
        	(
        		CASE
        		WHEN c. STATUS = 1 THEN
        			'已通过'
        		WHEN c. STATUS = 0 THEN
        			'待审核'
        		ELSE
        			'未通过'
        		END
        	) status,
        	(CASE WHEN photo.imgNum IS NULL THEN 0 ELSE photo.imgNum END) imgNum,
        	pro.proInfo,
        	c.id check_id
        FROM
        	yunaj_checkinfo c
        LEFT JOIN (
        	SELECT
        		check_id,
        		COUNT(*) imgNum
        	FROM
        		yunaj_checkphoto photo
        	GROUP BY
        		check_id
        ) photo ON photo.check_id = c.id
        LEFT JOIN (
        	SELECT
        		check_id,
        		GROUP_CONCAT(
        			question,
        			'：',
        			SUBSTRING_INDEX(
        				(
        					CASE
        					WHEN pro.answer = 0 THEN
        						answername
        					END
        				),
        				'|',
        				-1
        			) SEPARATOR '，'
        		) proInfo
        	FROM
        		yunaj_checkproblem pro
        	GROUP BY
        		check_id
        ) pro ON pro.check_id = c.id
        LEFT JOIN yunaj_user u ON u.id = c.checkuserid
        LEFT JOIN yunaj_user uu ON uu.id = c.audituserid
        WHERE
        	c.cstcode = $cstcode LIMIT $pageStart, $row";
        return db()->query($sql);
    }
    
    /**
     * 判断检查记录的审核状态
     * @param int $checkerID 检查者id
     * @param int $cstcode 客户房间编号
     * return array 未通过审核的记录
     * status 审核状态码 0未审核 -1不通过 1通过，此处修复一个逻辑错误，无需传入状态，只有两种情况为不通过
     *
     */
    public function getStatus($checkerID, $cstcode)
    {
        $where = "`checkuserid` = '$checkerID' AND `cstcode` = '$cstcode' AND (`status` = '0' OR `status` = '-1')"; // 条件
        return db('checkinfo')->where($where)->value('id'); // 直接查id字段
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
        // return $this->allowField(['checktime', 'status'])->save($data, ['id' => $logID]);
        return $this->allowField(true)->save($data, ['id' => $logID]);
    }
    
    /**
     * 添加检查记录
     * @param array $data 各种检查记录信息
     * return int save方法新增数据返回的是写入的记录数，但我这里返回自增id
     *
     */
    public function addCheckInfo($data)
    {
        $this->allowField(true)->save($data); // 添加数据到记录表，过滤post数组中的非数据表字段数据
        $check_id = $this->id;
        return $check_id;
    }
    
    /**
     * 删除检查记录
     * @param int $check_id 检查记录id
     * return bool
     * 此方法先删除照片记录以及照片文件，再删除检查问题详情信息，然后删除检查记录信息
     * 
     */
    public function deleteLog($check_id)
    {
        $img = db('checkphoto');
        $imgInfo = $img->where(['check_id' => $check_id])->field('url')->select();
        $img->where(['check_id' => $check_id])->delete(); // 删除照片记录
        foreach ($imgInfo as $v){
            // $img->where(['url' => $v['url']])->delete(); // url是唯一的，删除照片记录
            $url = substr($v['url'], 1); // 去除首个“/”，表示与index.php同级目录unlink，若要删上级目录下内容，就../
            if (file_exists($url)){ // 判断是否存在
                unlink($url); // 删除图片文件
            }
        }
        db('checkproblem')->where(['check_id' => $check_id])->delete(); // 删除检查问题详情
        $result = $this->where(['id' => $check_id])->delete(); // 删除检查记录
        if ($result){ // 影响条数
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 执行审核操作
     * @param int $check_id 检查记录id
     * @param int $is_change 房间信息是否改动标识
     * @param int $room_id 房间id，用于更新房间信息历史记录表条件，外加is_new = 1条件
     * @param bool $pass 通过与否 1通过，0不通过
     * return int 影响条数
     * tp5的机制有所改变，更新操作只要执行并且成功就返回影响条数，无论更新后的数据和更新前的数据是否等同于未变
     * 
     */
    public function doAudit($check_id = '', $is_change = 0, $room_id = '', $pass = 1)
    {
        if (empty($check_id) || empty($room_id)){
            return '非法操作！';
        }
        $uid = session('uid'); // 审核人id
//         $uid = 8;
        $audittime = time(); // 审核时间
        if ($pass){ // 审核通过
            $result = $this->save(['status' => 1, 'audituserid' => $uid, 'audittime' => $audittime], ['id' => $check_id]);
            if ($is_change !== 0){ // 房间信息改动，同时通过审核
                db('roomlog')->where(['room_id' => $room_id, 'is_new' => 1])->update(['audituserid' => $uid, 'audittime' => $audittime]); // 封装的update和save的语法还尼玛不一样
                db('room')->where(['id'=> $room_id])->setField('is_change', 0); // 恢复房间状态为未修改
            }
            return $result;
        } else { // 审核不通过
            return $this->save(['status' => '-1', 'audituserid' => $uid, 'audittime' => $audittime], ['id' => $check_id]); // 这里有个坑，在传条件时，有符号必须加引号括起来，否则无法识别，实际上原生sql也差不多，只是纯数字无需引起来
        }
    }
}