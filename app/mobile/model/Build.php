<?php
/**
 * 该模型对应yunaj_build表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class Build extends Model
{
    /**
     * 添加栋信息
     * @param int $dong 栋
     * @param int $proj_id 小区id
     * return int 栋id
     * 
     */
    public function addDong($dong, $proj_id)
    {
        $data = ['proj_id' => $proj_id, 'name' => $dong.'栋', 'code' => $dong];
        return db('build')->insertGetId($data);
    }
    
    /**
     * 取得build的id
     * @param int $code 栋
     * @param int $proj_id 小区id
     * 
     */
    public function getBldId($code, $proj_id)
    {
        return db('build')->field('id')->where(['proj_id' => $proj_id, 'code' => $code])->find()['id'];
    }
}