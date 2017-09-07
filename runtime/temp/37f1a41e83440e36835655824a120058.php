<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:32:"app/mobile\view\index\index.html";i:1498123738;s:32:"app/mobile\view\common\base.html";i:1497450644;s:34:"app/mobile\view\common\bottom.html";i:1497489320;}*/ ?>
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
    <title>区域楼栋选择页面</title>
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
    
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/index.css" /> 
    <!-- end 当前页单独样式 -->
    
</head>

<body>
    <!-- 遮罩 -->
    <div class="mask"></div>
    <!-- end 遮罩 -->
    <div id="big-box">
    <!-- 主体内容 -->
    
<!-- 搜索框 -->
<form action="<?php echo url('user_info/index'); ?>" method="get" class="search-box">
    <input type="text" name="cstcode" placeholder="输入用户卡号快速进入" class="search-room" />
    <input type="submit" value="确定" class="to-submit" />
</form>
<script type="text/javascript">
$('.search-room').click(function() {
    $('.to-submit').fadeIn(600); // 淡入
});

$('.search-box').submit(function() { // 阻止直接提交
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
<!-- 房源选择 -->
<div class="room">
    <div class="room-select">
        <!-- 位置三级联动 -->
        <div class="selecter">
            <section>
                <div class="form-group" id="city">
                    <div class="kwselected kouweiwx"><span id="toMyCity">选城市</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
                </div>
                <div class="form-group" id="area">
                    <div class="kwselectedpx kouweiwxpx"><span>选区域</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
                </div>
                <div class="form-group" style="width:31%;" id="xq">
                    <div class="kwselectedqsj kouweiwxqsj"><span>选小区</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
                </div>
            </section>
        </div>
        <!-- 所有城市 -->
        <div class="city-all">
            <div class="head-title">选城市</div>
            <div class="key-search">
                <input type="text" />
            </div>
            <span class="close-btn">×</span>
            <ul class="select-main" id="is_city">
                <?php if(is_array($myData['city']) || $myData['city'] instanceof \think\Collection || $myData['city'] instanceof \think\Paginator): $i = 0; $__LIST__ = $myData['city'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <?php 
            	$cityNum = count($myData['city']); // 判断是否一个城市
             ?>
            <script type="text/javascript">
            	var cityNum = <?php echo $cityNum; ?>;
            	if (cityNum == 1) { // 直接显示城市名
            		$('#toMyCity').html("<?php echo $myData['city'][0]['name']; ?>");
            	}
            </script>
            <p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px; display: none;" class="tips">没找到</p>
        </div>
        <!-- 所有区域 -->
        <div class="area-all">
            <div class="head-title">选区域</div>
            <div class="key-search">
                <input type="text" />
            </div>
            <span class="close-btn">×</span>
            <ul class="select-main" id="is_area">
                <?php if(is_array($myData['area']) || $myData['area'] instanceof \think\Collection || $myData['area'] instanceof \think\Paginator): $i = 0; $__LIST__ = $myData['area'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px; display: none;" class="tips">没找到</p>
        </div>
        <!-- 所有小区 -->
        <div class="xq-all">
            <div class="head-title">选小区</div>
            <div class="key-search">
                <input type="text" />
            </div>
            <span class="close-btn">×</span>
            <ul class="select-main" id="is_xq">
                <?php if(is_array($myData['xq']) || $myData['xq'] instanceof \think\Collection || $myData['xq'] instanceof \think\Paginator): $i = 0; $__LIST__ = $myData['xq'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px; display: none;" class="tips">没找到</p>
        </div>
        <!-- end 位置三级联动 -->
        <div class="gps">
            <i class="ion-ios-location-outline gps-icon"></i>
            <span>自动</span>
            <span>定位</span>
        </div>
    </div>
</div>
<!-- 房源列表 -->
<ul class="room-list clear" id="room-list">
    <li style="font-family: '微软雅黑'; font-size: 12px; color: #666; text-align: center; line-height: 52px;">请选择小区位置或在上方输入用户卡号快速进入···</li>
</ul>

    <!-- end 主体内容 -->
    <!-- 底部 -->
    
        <div class="bottom">
    <div class="bottom-bar">
        <!-- 三个按钮 -->
        <a href="<?php echo url('mobile/index/index'); ?>" class='b-btn' now="Index">
            <i class="icon ion-android-checkmark-circle"></i>
            <span class="text">安全检查</span>
        </a>
        <a href="<?php echo url('mobile/my_log/index'); ?>" class="b-btn" now="MyLog">
            <i class="icon ion-clipboard"></i>
            <span class="text">我的记录</span>
        </a>
        <a href="<?php echo url('mobile/my_report/index'); ?>" class="b-btn" now="MyReport">
            <i class="icon ion-android-home"></i>
            <span class="text">我的报表</span>
        </a>
    </div>
</div>
<script type="text/javascript">
var controller = '<?php echo request()->controller(); ?>'; // 坑，忘加单引号
$('.bottom-bar').find('.b-btn').each(function(i){
    if($(this).attr('now') == controller){ // 判断当前选中样式，自定义now属性
        $(this).addClass('on');
    } else {
        $(this).removeClass('on');
    }
 });
</script>

    
    </div>
    <!-- 当前页单独js -->
    
<script type="text/javascript">

// 选择城市
$('#city').click(function() {

    toRun('is_city'); // 初始化匹配功能，传入ul的id
    $('.city-all input').removeAttr('value'); // 清空输入框值

    // 所有城市
    $('.city-all').show();
    $('.city-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html(''); // 清空楼栋信息列表，仅当选择小区时显示
    $('#area span').html('选区域'); // 下二级改为待选状态
    $('#xq span').html('选小区');

    $('.city-all input').bind('input propertychange', function() { // 监听搜索框
        searchCity();
    });

    function searchCity() {
        var $oLi = $('#is_city').find('li'); // 所有内容对象
        var $keyWords = $('.city-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_city li').click(function() {
        $('#city span').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 城市id
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('index/index'); ?>",
            data: "xzqy_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                }
                $('#is_area').html(html); // 更新区域列表
            }
        });
        $('#is_city li').unbind(); // 解决重复绑定点击事件问题
    });
});


// 选择区域
$('#area').click(function() {

    toRun('is_area'); // 初始化匹配功能，传入ul的id
    $('.area-all input').removeAttr('value'); // 清空输入框值

    $('.area-all').show();
    $('.area-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html('');
    $('#xq span').html('选小区');

    $('.area-all input').bind('input propertychange', function() { // 监听搜索框
        searchArea();
    });

    function searchArea() {
        var $oLi = $('#is_area').find('li'); // 所有内容对象
        var $keyWords = $('.area-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_area li').click(function() {
        $('#area span').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 区域id
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('index/index'); ?>",
            data: "area_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                }
                if (html !== '') {
                    $('#is_xq').html(html); // 更新小区列表
                } else {
                    $('#is_xq').html('<p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px;">该区域下没小区，换个区域试试吧</p>');
                }

            }
        });
        $('#is_area li').unbind(); // 解决重复绑定点击事件问题
    });
});

// 选择小区
$('#xq').click(function() {

    toRun('is_xq'); // 初始化匹配功能，传入ul的id
    $('.xq-all input').removeAttr('value'); // 清空输入框值

    // 所有小区
    $('.xq-all').show();
    $('.xq-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html(''); // 清空楼栋信息列表，仅当选择小区时显示
    $('#xq span').html('选小区');

    $('.xq-all input').bind('input propertychange', function() { // 监听搜索框
        searchXq();
    });

    function searchXq() {
        var $oLi = $('#is_xq').find('li'); // 所有内容对象
        var $keyWords = $('.xq-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_xq li').click(function() {
    	if ($(this).html().length > 4) { // 下拉框选中值
            var subFonts = $(this).html().substr(0, 4) + '···';
            $('#xq span').html(subFonts);
        } else {
            $('#xq span').html($(this).html());
        }
        close();
        var id = $(this).attr('class'); // 小区id
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('index/index'); ?>",
            data: "xq_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<li>';
                    html += '<a href="<?php echo url('room/index'); ?>?proj_id=' + id + '&bld_id=' + data[i].id + '&unit=' + data[i].unit + '">'; // 跳转房间可视化列表页
                    html += '<span class="position">' + data[i].name + data[i].unit + '单元</span>';
                    html += '<span class="result">';
                    html += '<span class="yes-c">已查23</span>';
                    html += '<span class="no-c">未查<span style="color: #fb4b40;">22</span></span>';
                    html += '</span>';
                    html += '</a>';
                    html += '</li>';
                }
                $('#room-list').html(html); // 更新栋单元数据
            }
        });
        $('#is_xq li').unbind(); // 解决重复绑定点击事件问题
    });
});
</script>
<script type="text/javascript">
// 关闭弹窗
function close() {
    $('.city-all').css({
        'transform': 'translateX(-50%) scale(.8, .8)',
        'opacity': 0
    });
    $('.area-all').css({
        'transform': 'translateX(-50%) scale(.8, .8)',
        'opacity': 0
    });
    $('.xq-all').css({
        'transform': 'translateX(-50%) scale(.8, .8)',
        'opacity': 0
    });
    $('.city-all').hide();
    $('.area-all').hide();
    $('.xq-all').hide();
    $('.mask').hide();

    // 恢复初始列表
    $('#is_city').find('li').show();
    $('#is_area').find('li').show();
    $('#is_xq').find('li').show();

    $('.tips').hide(); // 隐藏未匹配提示
}
$('.close-btn').click(function() { // 关闭按钮
    close();
});
$('.mask').click(function() { // 点击遮罩
    close();
});
</script>

    <!-- end 当前页单独js -->
</body>

</html>
