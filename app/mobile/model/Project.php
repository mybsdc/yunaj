<?php
/**
 * 该模型对应yunaj_project表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class Project extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_project'; // 实际上遵循规范会自动对应，无需此步
    
    /**
     * 获取所有小区
     * 
     */
    public function getAllXq()
    {
        return db('project')->select();
    }
    
    /**
     * 通过区域查小区
     * @param int $area_id 区域id
     * 
     */
    public function areaFindXq($area_id)
    {
        return db('project')->where(['xzqy_id' => $area_id])->select();
    }
    
    /**
     * 新增小区
     * @param int $xzqy_id 区域id
     * @param string $proj_name 小区名
     * return int 新增主键id
     * 
     */
    public function addProj($xzqy_id, $proj_name)
    {
        // 拼接小区详细地址
        $addName = db()->query("SELECT b.name cityName, a.name areaName FROM yunaj_xzqy a JOIN yunaj_xzqy b ON a.parent_id = b.id WHERE a.id = $xzqy_id LIMIT 1")[0];
      
        // 小区字段值
        $data['xzqy_id'] = $xzqy_id;
        $data['name'] = $proj_name;
        $data['projaddress'] = $addName['cityName'].'-'.$addName['areaName'].'-'.$proj_name; // 详细地址
        
        // 插入
        return db('project')->insertGetId($data);
    }
    
    /**
     * 判断小区是否存在
     * @param string $proj_name 小区名
     * return array 没找到会返回空，相当于false
     * 
     */
    public function haveProj($proj_name)
    {
        return $have = $this->where(['name' => $proj_name])->find(); // 精确查找
    }
}