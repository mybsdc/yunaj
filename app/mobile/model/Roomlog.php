<?php
/**
 * 该模型对应yunaj_roomlog表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class Roomlog extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_roomlog'; // 实际上遵循规范会自动对应，无需此步
    
    /**
     * 备份房间历史信息
     * @param mixed $data 房间信息
     * return int 影响条数
     * 
     */
    public function backupRoom($data)
    {
        $is_new = db('roomlog')->where(['room_id' => $data['room_id'], 'is_new' => 1])->find()['id'];
        if ($is_new){
            $this->where(['id' => $is_new])->update(['is_new' => 0]); // 每个房间只能有一条数据is_new字段值为1
        }
        
        return $this->allowField(true)->save($data);
    }
}