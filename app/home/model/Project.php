<?php
/**
 * 该模型对应yunaj_project表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;

class Project extends Model
{
    /**
     * 获取所有小区
     * 
     */
    public function getAllXq()
    {
        return db('project')->select();
    }
    
    /**
     * 通过区域id查小区
     * @param int $area_id 区域id
     * return array
     * 
     */
    public function getXqByAid($area_id)
    {
        if (!$area_id){
            return '';
        }
        return db('project')->where(['xzqy_id' => $area_id])->select();
    }
}