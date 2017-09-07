<?php
/**
 * 该模型对应yunaj_csdetail表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class Ywcs extends Model
{
    /**
     * 获取业务参数详情
     * @param $type 类型 1公司(城市)型参数、2区域性参数、3集团级参数
     * @param $zzjg_id 组织架构id
     * 
     */
    public function getCsInfo($type, $zzjg_id)
    {
        $ywcsData = db('ywcs')->where(['type' => $type, 'zzjg_id' => $zzjg_id])->order('id desc')->select();
        foreach ($ywcsData as $k => $v){
            $cs = db('csdetail')->where(['ywcs_id' => $v['id']])->select();
            $csInfo[$v['name']] = $cs;
        }
        return $csInfo;
    }
    
    /**
     * 获取气表类型、品牌下拉框数据或者检查问题列表
     * @param string $type 气表类型、品牌或者检查问题
     * return array
     * 
     */
    public function getCs($type)
    {
        $cs = db()->query("SELECT b.name, b.id FROM yunaj_ywcs a JOIN yunaj_csdetail b ON a.id = b.ywcs_id WHERE a.name = '$type'");
        if ($type == '检查问题'){
            foreach ($cs as $k => $v){
                $temp = explode('|', $v['name']); // 以英文状态下的“|”分隔
                $temp['id'] = $v['id'];
                $problem[] = $temp;
            }
            return $problem;
        } else {
            return $cs;
        }
    }
}