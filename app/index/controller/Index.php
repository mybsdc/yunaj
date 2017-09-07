<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">由于云安检属于公司内部项目，本站仅作演示之用</span></p><span style="font-size:22px;"><a href="http://yunaj.ml/index.php/home/index/index" target="qiniu">云安检电脑端</a></span><br /><span style="font-size:22px;"><a href="http://yunaj.ml/index.php/mobile/index/index" target="qiniu">云安检手机端</a></span><br /><span>手机端电脑端的演示账户信息均为：<br />账号：admin<br />密码：123456</span></div>';
	}
}
