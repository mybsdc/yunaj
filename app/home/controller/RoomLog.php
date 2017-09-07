<?php
/**
 * 房间历史检查记录
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
        $this->check = model('Checkinfo');
        $this->cs = model('Ywcs'); // 业务参数模型
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
        $baseInfo = $this->check->getBaseInfo($cstcode); // 基础信息
        $this->assign('baseInfo', $baseInfo);
        
        // 获取总页数与总条数
        $toPage = $this->check->getRoomLog($cstcode, true);
        $this->assign('toPage', $toPage);
        
        // 分页取出数据
        if (input('?get.page')) {
            $page = input('get.page/d');
            $cstcode = input('get.cstcode');
            $listData = $this->check->getRoomLog($cstcode, false, $page);
//             p($listData);
            return json_encode($listData);
        }
        $type = $this->cs->getCs('气表类型'); // 气表类型
        $brand = $this->cs->getCs('品牌'); // 品牌
        //         p($type);
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        
        /* // 侧边栏
        $model=model('Fun');
        $res=$model->where("parent_id=0")->select();
        $this->assign("res",$res); */
        // 侧边栏
        $model=model('Fun');
        $res = $this->getFun();
        $this->assign("res",$res);
        
        return $this->fetch();
    }
}