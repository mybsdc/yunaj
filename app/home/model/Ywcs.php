<?php
/**
 * 该模型对应yunaj_csdetail表
 * 
 */

namespace app\home\model;

use think\Model;

class Ywcs extends Model
{
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