<?php
/**
 * 该模型对应yunaj_checkproblem表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;

class Checkproblem extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_checkproblem';
    
    /**
     * 写入问题记录详情
     * @param array $pro 问题记录数据
     * return array
     * 
     */
    public function inputProLog($pro)
    {
        return $this->allowField(true)->isUpdate(false)->saveAll($pro); // 已过滤非数据表字段
    }
    
    /**
     * 更新问题记录详情
     * @param array $pro 需要更新的问题记录数据
     * @param string 
     * return array
     * 
     */
    public function updateProLog($pro)
    {
        foreach($pro as $v){
            $this->where(['check_id' => $v['check_id'], 'question' => $v['question']])->update($v);
        }
        return true;
    }
    
    /**
     * 穿透查询问题记录详情
     * @param int $check_id 检查记录id
     * @param int $status 审核状态
     * return array 问题记录详情
     * 
     */
    public function toGetPro($check_id, $status)
    {
        // return $this->where(['check_id' => $check_id])->select(); // 返回对象
        $data = db('checkproblem')->where(['check_id' => $check_id])->select(); // 返回数组
        $pro = [];
        foreach ($data as $v){
            $pro[$v['id']]['question'] = $v['question']; // $v['id']废物利用，防止[]自增
            $a = explode('|', $v['answername']); // 转数组，使用“|”分隔
            $pro[$v['id']]['yes'] = $a[0];
            $pro[$v['id']]['no'] = $a[1];
            $pro[$v['id']]['remark'] = $v['remark'];
            $pro[$v['id']]['id'] = $v['id'];
            $pro[$v['id']]['check_id'] = $check_id;
            // $pro[$v['id']]['status'] = $status;
            $pro[$v['id']]['answer'] = $v['answer'];
        }
        return $pro;
    }
    
    /**
     * 穿透更新问题记录详情
     * @param array $data 问题详情
     * return int 影响行数
     * 
     */
    public function resetPro($data)
    {
        return $this->saveAll($data); // 必须$this才能成功调用saveAll方法
    }
}