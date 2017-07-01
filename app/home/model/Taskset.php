<?php
/**
 * 该模型对应yunaj_taskset表
 * @author mybsdc
 *
 */
namespace app\home\model;

use think\Model;

class Taskset extends Model
{
    /**
     * 查询所有任务列表
     * @return array
     * 
     */
    public function getTaskList()
    {
        return db('taskset')->select();
    }
}