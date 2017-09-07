<?php
/**
 * 房间可视化列表展示页面控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;

class Room extends Base
{
    // 房间可视化列表展示页面
    public function index()
    {
        if (!input('?get.proj_id') || !input('?get.bld_id') || !input('?get.unit')){
            return $this->error('非法访问！');
        }
        
        $room = model('Room'); // 实例化Room模型
        
        // 传入参数
        $proj_id = input('get.proj_id/d');
        $bld_id = input('get.bld_id/d');
        $unit = input('get.unit/d');
        
        // 小区栋单元名
        $name = $room->getName($proj_id, $bld_id, $unit);
        
        $roomList = $room->getRoomList($proj_id, $bld_id, $unit); // 所有楼层房间

        $this->assign('roomList', $roomList);
        $this->assign('name', $name);
        return $this->fetch();
    }
}