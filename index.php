<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件  
define('APP_PATH', 'app/'); // 定义项目路径,和之前3.2版本没有区别  
define('APP_AUTO_BUILD',true); // 开启自动生成  
define('APP_DEBUG', true);// 开启调试模式  
define('MODULE','module'); 

// 加载框架引导文件  
require 'thinkphp/start.php';