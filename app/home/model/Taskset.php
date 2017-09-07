<?php
/**
 * 该模型对应yunaj_taskset表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;
use think\db\Query;

class Taskset extends Model
{
    /**
     * 查询所有任务列表
     * @param int $uid 执行人id
     * return array
     * 
     */
    public function getTaskList($uid = 0)
    {
        // return db('taskset')->select();
        /* $sql = "SELECT
        	t.id,
        	t.name
        FROM
        	yunaj_taskset t
        JOIN yunaj_task2czr u ON u.taskid = t.id
        WHERE
        	u.czrid = $uid"; */
        return db('taskset')->alias('t')->join('yunaj_task2czr u', 'u.taskid = t.id')->field('t.id, t.name')->where(['u.czrid' => $uid, 't.status' => '1'])->select();
    }
}