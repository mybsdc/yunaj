<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"app/home\view\index\tnav.html";i:1498449249;}*/ ?>
<div style="position: fixed;bottom: 0;height: 80px;width:100%;">
    <ul class="wizard-steps" style="margin-left: -95px">
        <?php if(is_array($res) || $res instanceof \think\Collection || $res instanceof \think\Paginator): if( count($res)==0 ) : echo "" ;else: foreach($res as $key=>$vo): if(count($res) == 1): ?>
                    <style>
                        .wizard-steps li:before{
                            border:0;
                        }
                    </style>
                    <li data-target="#step1" class="active">
                        <span class="step" style="border-radius: 10px;width: 100px;line-height: 40px;border: 2px solid #ced1d6"><?php echo $vo['name']; ?></span>
                    </li>
                <?php else: ?>
                    <li data-target="#step1" class="active" >
                        <span class="step" style="border-radius: 10px;width: 100px;line-height: 40px;border: 2px solid #ced1d6"><?php echo $vo['name']; ?></span>
                    </li>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </ul>

</div>