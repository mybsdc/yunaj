<?php
/**
 * 房间历史记录控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;
use think\db\Query;

class CheckLog extends Base
{
    // 历史记录展示
    public function index()
    {
        if (!input('?get.cstcode')){
            return $this->error('非法访问！');
        }
    }
}