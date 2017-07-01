<?php
/**
 * 该模型对应yunaj_xzqy表
 * 
 */

namespace app\mobile\model;

use think\Model;

class Xzqy extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_xzqy'; // 实际上遵循规范会自动对应，无需此步

    /**
     * 获取所有城市区域
     * @param int $type 类型 0城市 1区\镇
     * 
     */
    public function getAllXzqy($type = '')
    {
        if (!empty($type)){
            return db('xzqy')->where(['type' => $type])->select();
        }
        return db('xzqy')->select();
    }
    
    /**
     * 通过城市查区域
     * @parm int $cityId 城市id
     */
    public function cityFindArea($cityId)
    {
        return db('xzqy')->where(['parent_id' => $cityId])->select();
    }
}