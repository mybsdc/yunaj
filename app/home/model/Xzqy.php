<?php
/**
 * 该模型对应yunaj_xzqy表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;

class Xzqy extends Model
{
    /**
     * 判断当前用户有检查权限的城市区域小区
     * @param int $user_id 用户id
     * return array
     *
     */
    public function getMyData($user_id)
    {
        // 组织架构的id与parent_id
        $idData = db('role2user')->alias('r2u')->join('yunaj_role r','r2u.role_id = r.id')->join('yunaj_zzjg z', 'r.zzjg_id = z.id')->field('z.id, z.parent_id')->where(['r2u.user_id' => $user_id])->find();
        if ($idData['parent_id'] === 0){ // 公司，这种情况几乎不会发生
            $myCity = db('city2zzjg')->alias('c')->join('yunaj_xzqy x', 'x.id = c.xzqy_id')->field('x.id, x.name')->where(['c.zzjg_id' => $idData['id']])->select();
        } else { // 部门
            $zzjg_id = db('zzjg')->field('id')->where(['id' => $idData['parent_id']])->find();
            $myCity = db('city2zzjg')->alias('c')->join('yunaj_xzqy x', 'x.id = c.xzqy_id')->field('x.id, x.name')->where(['c.zzjg_id' => $zzjg_id['id']])->select();
        }
    
        // 拼装数组
        $myData = [];
        foreach ($myCity as $v){
            $myData['city'][] = $v;
            $areaData = db('xzqy')->field('id, name')->where(['parent_id' => $v['id']])->select();
            foreach ($areaData as $v2){
                $myData['area'][] = $v2;
                $xqData = db('project')->field('id, name')->where(['xzqy_id' => $v2['id']])->select();
                foreach ($xqData as $v3){
                    $myData['xq'][] = $v3;
                }
            }
        }
        return $myData; // 有检查权限的所有城市区域小区
    }
    
    /**
     * 获取所有城市
     * 
     */
    public function getAllCity()
    {
        return db('xzqy')->field('id, name, parent_id')->where(['type' => 0])->select();
    }
    
    /**
     * 获取所有区域
     *
     */
    public function getAllArea()
    {
        return db('xzqy')->field('id, name, parent_id')->where(['type' => 1])->select();
    }
    
    /**
     * 通过城市id查区域
     * @param int $pid 父id
     * @return array
     * 
     */
    public function getAreaByPid($pid)
    {
        if (!$pid){
            return '';
        }
        return db('xzqy')->where(['parent_id' => $pid])->select();
    }
}