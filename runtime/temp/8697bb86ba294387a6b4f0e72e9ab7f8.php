<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:31:"app/mobile\view\room\index.html";i:1498123732;s:32:"app/mobile\view\common\base.html";i:1497450644;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <meta name="MobileOptimized" content="320" />
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="author" content="johnye" />
    <meta name="shenma-site-verification" content="f28da5e2e3fb6e2afd372a3eedfda998" />
    <meta name="baidu-site-verification" content="eafwEzRbnz" />
    <!-- 标题 -->
    <title>房间可视化列表展示页面</title>
    <!-- end 标题 -->
    <meta name="description" content="燃气录入系统，由燃气安全检查员使用">
    <meta name="keywords" content="燃气检查">
    <!-- 公共样式js -->
    <link rel="stylesheet" type="text/css" href="__MOBILE__/css/public.css" />
    <link rel="stylesheet" type="text/css" href="__MOBILE__/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="__MOBILE__/css/ionicons.min.css" />
    <script type="text/javascript" src="__MOBILE__/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="__MOBILE__/js/layer.js"></script>
    <!-- 下拉框模糊匹配 -->
    <script type="text/javascript" src="__MOBILE__/js/hz2py.js"></script>
    <script type="text/javascript" src="__MOBILE__/js/filter.js"></script>
    <!-- end 下拉框模糊匹配 -->
    <!-- end 公共样式js -->
    <!-- 当前页单独样式 -->
    
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/view.css" />

    <!-- end 当前页单独样式 -->
    
</head>

<body>
    <!-- 遮罩 -->
    <div class="mask"></div>
    <!-- end 遮罩 -->
    <div id="big-box">
    <!-- 主体内容 -->
    
<div class="top">
    <!-- 返回 -->
    <div class="back">
        <i class="ion-ios-arrow-back"></i>
        <span>返回</span>
    </div>
    <!-- 搜索框 -->
    <form action="<?php echo url('user_info/index'); ?>" method="get" class="view-search-box">
        <input type="text" name="cstcode" placeholder="输入用户卡号快速进入" class="search-room" />
        <input type="submit" value="确定" class="to-submit" />
    </form>
    <script type="text/javascript">
    $('.search-room').click(function() {
        $('.to-submit').fadeIn(600); // 淡入
    });

    $('.view-search-box').submit(function() { // 阻止直接提交事件
        var cstcode = $('.search-room').val();
        if (cstcode == '') {
            layer.open({
                content: '请输入用户卡号再点确认',
                skin: 'msg',
                time: 2 // 2秒后自动关闭
            });
            return false;
        }
        $.get("<?php echo url('UserInfo/haveRoom'); ?>", {cstcode: cstcode}, function(data){
            if (data == 0) { // 房号不存在
                layer.open({
                    content: '您输入的卡号不存在，要新增吗？',
                    btn: ['新增', '算了'],
                    yes: function(index){
                        setTimeout(function() {
                            window.location.href = "<?php echo url('mobile/user_info/index'); ?>?cstcode=" + cstcode + "";
                        }, 10);
                        layer.close(index);
                    }
                });
            } else {
                window.location.href = "<?php echo url('mobile/user_info/index'); ?>?cstcode=" + cstcode + "";
            }
        });
        return false;
    });
    </script>
</div>
<div class="clear"></div>
<div style="width: 100%; height: 8px;"></div>
<!-- 位置信息 -->
<div class="location-info">
    <?php echo $name['proj']; ?><span><?php echo $name['bld']; ?></span>栋<span><?php echo $name['unit']; ?></span>单元
</div>
<!-- 检查筛选 -->
<div class="option-box">
    <div class="option current" id="all">
        全部
    </div>
    <span class="cut"></span>
    <div class="option" id="not-check">
        <i class="ion-ios-circle-outline"></i>
        <span style="vertical-align: 0;">未检查</span>
    </div>
    <span class="cut"></span>
    <div class="option" id="checked">
        <i class="ion-record" style="color: #11c063;"></i>
        <span>已检查</span>
    </div>
    <span class="cut" style="margin-right: 1%;"></span>
    <div class="option" style="min-width: 31%;" id="not-pass">
        <i class="ion-record" style="color: #f5444a;"></i>
        <span>有安全隐患</span>
    </div>
</div>
<!-- 可视化楼层视图 -->
<ul class="view-list clear">
<?php if(is_array($roomList) || $roomList instanceof \think\Collection || $roomList instanceof \think\Paginator): $i = 0; $__LIST__ = $roomList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <li>
        <div class="floor"><?php echo $key; ?>层</div>
        <div class="is_room">
        <?php if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo url('UserInfo/index'); ?>?cstcode=<?php echo $vo2['cstcode']; ?>"><?php echo $vo2['room']; ?></a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </li>
<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

    <!-- end 主体内容 -->
    <!-- 底部 -->
    
    </div>
    <!-- 当前页单独js -->
    
<script type="text/javascript">

    // 返回
    $('.back').click(function(){
        window.history.go(-1);
    });

    /**
     * 根据检查状态切换
     */

     // 样式
    $('.option-box .option').click(function(){
        $('.option-box .option').removeClass('current');
        $(this).addClass('current');
    });

    // 数据
    $('#all').click(function(){
        var status = 2; // 状态代码：0未审核 1已通过 -1未通过 2所有
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('room/index'); ?>",
            data: "status=" + status,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                    html += '<li>';
                        html += '<div class="floor">12层</div>';
                        html += '<div class="is_room">';
                            html += '<a href="#">1201</a>';
                            html += '<a href="#" class="green">1202</a>';
                            html += '<a href="#" class="green">1203</a>';
                            html += '<a href="#" class="green">1204</a>';
                        html += '</div>';
                    html += '</li>';
                }                
            }
        });
    });

</script>

    <!-- end 当前页单独js -->
</body>

</html>
