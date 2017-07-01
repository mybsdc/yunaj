<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件 by mybsdc
/**
 * 处理Curl
 * @param $url
 * @param int $type 0 get 1 post
 * @param array $data 只有post数据会用到这个参数
 * 
 */
function doCurl($url, $type = 0, $data = [])
{
    $ch = curl_init(); // 初始化
    
    // 设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 如果成功只返回结果，不输出内容
    curl_setopt($ch, CURLOPT_HEADER, 0); // 0不输出header头部
    
    if ($type == 1){ // post，如果是get方式直接从参数中读值，无需此句
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    
    // 执行并获取内容
    $output = curl_exec($ch);
    
    // 释放Curl句柄
    curl_close($ch);
    return $output;
}