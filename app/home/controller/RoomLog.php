<?php
/**
 * 检查记录查看控制器
 * 
 */

namespace app\home\controller;

class RoomLog extends Base
{
    /**
     * 实例化模型
     * 
     */
    public function _initialize()
    {
        parent::_initialize();
        /* $this->xzqy = model('Xzqy');
        $this->xq = model('Project');
        $this->room = model('Room'); */
        $this->roomlog = model('Checkinfo');
    }
    
    /**
     * 房间历史检查记录
     * 
     */
    public function index()
    {
        if (!isset($_GET['cstcode']) || empty(input('get.cstcode'))){
            $this->error('非法访问！');
        }
        
        // 获取房间历史检查记录
        $cstcode = input('get.cstcode');
        $logData = $this->roomlog->getRoomLog($cstcode);
        
        
        // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
}