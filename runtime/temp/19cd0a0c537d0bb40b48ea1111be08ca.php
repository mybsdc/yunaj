<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:36:"app/mobile\view\my_report\index.html";i:1497869768;s:32:"app/mobile\view\common\base.html";i:1497450644;s:34:"app/mobile\view\common\bottom.html";i:1497489320;}*/ ?>
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
    <title>我的报表</title>
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
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/my_log.css" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/my_report.css" />
<!-- 时间日期 ps: 此插件的js必须置于头部方能正常调用，且jquery必须在它们之前，mobiscroll_date.js必须在mobiscroll.js之前 -->
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/mobiscroll.css" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/mobiscroll_date.css" />
<script type="text/javascript" src="__MOBILE__/js/mobiscroll_date.js" charset="gb2312"></script>
<script type="text/javascript" src="__MOBILE__/js/mobiscroll.js"></script>
<!-- end 时间日期 -->

    <!-- end 当前页单独样式 -->
    
</head>

<body>
    <!-- 遮罩 -->
    <div class="mask"></div>
    <!-- end 遮罩 -->
    <div id="big-box">
    <!-- 主体内容 -->
    
<div class="top" style="background-color: #fff;">
    <!-- 返回 -->
    <div class="back">
        <i class="ion-ios-arrow-back"></i>
        <span>返回</span>
    </div>
    <div class="report-title">我的报表</div>
</div>
<div class="clear"></div>
<div style="width: 100%; height: 8px; background-color: #fff;"></div>
<!-- 房源选择 -->
<div class="room" style="z-index: 2222;">
    <div class="room-select">
        <!-- 位置三级联动 -->
        <div class="selecter" style="top: 47px;">
            <section>
                <div class="form-group" id="city" style="width: 10%;">
                    <div class="kwselected kouweiwx"><span id="toMyCity">选城市</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
                </div>
                <div class="form-group" id="area" style="width: 10%;">
                    <div class="kwselectedpx kouweiwxpx"><span id="getAreaID" class="">选区域</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
                </div>
                <div class="form-group" style="width: 31%;" id="xq">
                    <div class="kwselectedqsj kouweiwxqsj"><span id="getXqID" class="">选小区</span>&nbsp;<i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
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
        <!-- 按时间筛选 -->
        <div id="log-time"><span>选时间</span><i class="ion-ios-arrow-down" style="color: #fff; font-size: 12px;"></i></div>
        <!-- 所有时间 -->
        <div class="time-all">
            <div class="head-title">请选择时间</div>
            <span class="close-btn">×</span>
            <ul class="select-main" id="is_xq">
                <li class="w">本周</li>
                <li class="m">本月</li>
                <li class="y">今年</li>
                <li class="z" id="diy">自定义</li>
            </ul>
        </div>
        <!-- 选择时间范围 -->
        <div id="time-to-time" style="box-shadow: none;">
            <div class="head-title">请选择时间范围</div>
            <span class="close-btn">×</span>
            <ul class="select-main">
                <li id="chooseTime">
                    从
                    <input type="text" id="startTime" name="startTime" class="startTime" />
                    至
                    <input type="text" id="endTime" name="endTime" class="endTime" />
                    <span id="time-btn">确定</span>
                </li>
            </ul>
        </div>
        <script type="text/javascript">
            // 提交自定义时间段
            $('#time-btn').click(function(){
                var getStartTime = $('#startTime').val();
                var getEndTime = $('#endTime').val();
                if (getStartTime == '') {
                    layer.open({
                        content: '您还没有选择开始时间',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                    return false;
                }
                if (getEndTime == '') {
                    layer.open({
                        content: '您还没有选择结束时间',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                    return false;
                }
                if (getStartTime == getEndTime) {
                    layer.open({
                        content: '开始日期与结束日期不能是同一天哦',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                    return false;
                }
                var st = new Date(getStartTime);
                var et = new Date(getEndTime);
                if(st.getTime() > et.getTime()){
                    layer.open({
                        content: '开始日期不能大于结束日期哦',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                    return false;
                }
                close();
                var areaID = $('#getAreaID').attr('class');
                var xqID = $('#getXqID').attr('class');
                $.get("<?php echo url('my_report/index'); ?>", {startTime: getStartTime, endTime: getEndTime, areaID: areaID, xqID: xqID}, function(data){
                    let dataObj = eval(data); // json转对象
                    $('#haveCheckedNum').html(dataObj.haveCheckedNum); // 已检查总数
                    $('#notVerifyNum').html(dataObj.notVerifyNum); // 未审核总数
                    $('#passNum').html(dataObj.passNum); // 已通过总数
                    $('#notPassNum').html(dataObj.notPassNum); // 未通过总数
                    $('#havePro').html(dataObj.havePro); // 有安全隐患总数
                    $('#notVerifyNumScale').html(dataObj.notVerifyNumScale); // 未审核比例
                    $('#passNumScale').html(dataObj.passNumScale); // 通过比例
                    $('#notPassNumScale').html(dataObj.notPassNumScale); // 未通过比例
                }, 'json'); // 必须指定json，否则前台无法识别
            });
        </script>
    </div>
</div>
<!-- 我的报表 -->
<ul id="my_report">
    <li style="color: #78c940;">
        <!-- 图标 -->
        <div class="report-icon">
            <i class="ion-record"></i>
        </div>
        <!-- 计数与状态 -->
        <div class="r-info">
            <span class="r-num" id="haveCheckedNum"><?php echo $myReportData['haveCheckedNum']; ?></span>
            <span class="r-status">已检查</span>
        </div>
    </li>
    <li style="color: #d195ed;">
        <!-- 图标 -->
        <div class="report-icon">
            <i class="ion-record"></i>
        </div>
        <!-- 计数与状态 -->
        <div class="r-info">
            <span class="r-num" id="notVerifyNum"><?php echo $myReportData['notVerifyNum']; ?></span>
            <span class="r-status">未审核</span>
        </div>
        <!-- 比例 -->
        <div class="scale">占已检查比例&nbsp;<span id="notVerifyNumScale"><?php echo $myReportData['notVerifyNumScale']; ?></span>%</div>
    </li>
    <li style="color: #029be9;">
        <!-- 图标 -->
        <div class="report-icon">
            <i class="ion-record"></i>
        </div>
        <!-- 计数与状态 -->
        <div class="r-info">
            <span class="r-num" id="passNum"><?php echo $myReportData['passNum']; ?></span>
            <span class="r-status">已通过审核</span>
        </div>
        <!-- 比例 -->
        <div class="scale">占已检查比例&nbsp;<span id="passNumScale"><?php echo $myReportData['passNumScale']; ?></span>%</div>
    </li>
    <li style="color: #fad473;">
        <!-- 图标 -->
        <div class="report-icon">
            <i class="ion-record"></i>
        </div>
        <!-- 计数与状态 -->
        <div class="r-info">
            <span class="r-num" id="notPassNum"><?php echo $myReportData['notPassNum']; ?></span>
            <span class="r-status">未通过审核</span>
        </div>
        <!-- 比例 -->
        <div class="scale">占已检查比例&nbsp;<span id="notPassNumScale"><?php echo $myReportData['notPassNumScale']; ?></span>%</div>
    </li>
    <li style="color: #da5e52;">
        <!-- 图标 -->
        <div class="report-icon">
            <i class="ion-record"></i>
        </div>
        <!-- 计数与状态 -->
        <div class="r-info">
            <span class="r-num" id="havePro"><?php echo $myReportData['havePro']; ?></span>
            <span class="r-status">有安全隐患</span>
        </div>
    </li>
</ul>
<div style="width: 100%; height: 12px; background-color: #fff;"></div>
<!-- end 我的报表 -->

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
    // 返回
    $('.back').click(function(){
        window.history.go(-1);
    });
</script>
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
        $('#toMyCity').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 城市id
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('my_report/index'); ?>",
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
        $('#getAreaID').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 区域id
        $('#getAreaID').attr('class', id); // 储存区域id值，备用时间选择
        $.ajax({
            type: "POST",
            url: "<?php echo url('my_report/index'); ?>",
            data: "area_id=" + id,
            dataType: 'json',
            success: function(data) {

                // 通过区域id取小区数据
                var html = '';
                for (var i = 0; i < data['xq'].length; i++) {
                    html += ' <li class="' + data['xq'][i].id + '">' + data['xq'][i].name + '</li>';
                }
                if (html !== '') {
                    $('#is_xq').html(html); // 更新小区列表
                } else {
                    $('#is_xq').html('<p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px;">没找到目标小区，换个区域试试吧</p>');
                }

                // 通过区域id获取我的报表
                $('#haveCheckedNum').html(data['report'].haveCheckedNum); // 已检查总数
                $('#notVerifyNum').html(data['report'].notVerifyNum); // 未审核总数
                $('#passNum').html(data['report'].passNum); // 已通过总数
                $('#notPassNum').html(data['report'].notPassNum); // 未通过总数
                $('#havePro').html(data['report'].havePro); // 有安全隐患总数
                $('#notVerifyNumScale').html(data['report'].notVerifyNumScale); // 未审核比例
                $('#passNumScale').html(data['report'].passNumScale); // 通过比例
                $('#notPassNumScale').html(data['report'].notPassNumScale); // 未通过比例
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
            $('#getXqID').html(subFonts);
        } else {
            $('#getXqID').html($(this).html());
        }
        close();
        var id = $(this).attr('class'); // 小区id
        $('#getXqID').attr('class', id); // 储存小区id值，备用时间选择
        var html = '';
        $.ajax({
            type: "POST",
            url: "<?php echo url('my_report/index'); ?>",
            data: "xq_id=" + id,
            dataType: 'json',
            success: function(data) {

                // 通过小区id获取我的报表
                $('#haveCheckedNum').html(data.haveCheckedNum); // 已检查总数
                $('#notVerifyNum').html(data.notVerifyNum); // 未审核总数
                $('#passNum').html(data.passNum); // 已通过总数
                $('#notPassNum').html(data.notPassNum); // 未通过总数
                $('#havePro').html(data.havePro); // 有安全隐患总数
                $('#notVerifyNumScale').html(data.notVerifyNumScale); // 未审核比例
                $('#passNumScale').html(data.passNumScale); // 通过比例
                $('#notPassNumScale').html(data.notPassNumScale); // 未通过比例
            }
        });
        $('#is_xq li').unbind(); // 解决重复绑定点击事件问题
    });
});

// 选择时间
var time = $('#log-time');
time.click(function(){
    var timeAll = $('.time-all');
    timeAll.show();
    timeAll.animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    timeAll.find('li').click(function(){
        $('#myPages').hide(); // 粗暴处理，后期优化
        $('#log-time span').html($(this).html());
        close();

        if ($(this).attr('id') == 'diy') { // 自定义时间，此处只调用时间选择弹窗，提交事件由确定按钮触发
            var timeToTime = $('#time-to-time');
            timeToTime.show();
            timeToTime.animate({
                textIndent: 0
            }, {
                step: function(now, fx) {
                    $(this).css('transform', 'translateX(-50%) scale(1, 1)');
                    $(this).css('opacity', 1);
                }
            });
            $('.mask').show(); // 遮罩

            // 操作提示
            layer.open({
                content: '请点击方框选择时间范围',
                skin: 'msg',
                time: 2
            });
            return false;
        }

        // 周月年
        var wmy = $(this).attr('class');
        var areaID = $('#getAreaID').attr('class');
        var xqID = $('#getXqID').attr('class');
        $.get("<?php echo url('my_report/index'); ?>", {wmy: wmy, areaID: areaID, xqID: xqID}, function(data){
            let dataObj = eval(data); // json转对象
            $('#haveCheckedNum').html(dataObj.haveCheckedNum); // 已检查总数
            $('#notVerifyNum').html(dataObj.notVerifyNum); // 未审核总数
            $('#passNum').html(dataObj.passNum); // 已通过总数
            $('#notPassNum').html(dataObj.notPassNum); // 未通过总数
            $('#havePro').html(dataObj.havePro); // 有安全隐患总数
            $('#notVerifyNumScale').html(dataObj.notVerifyNumScale); // 未审核比例
            $('#passNumScale').html(dataObj.passNumScale); // 通过比例
            $('#notPassNumScale').html(dataObj.notPassNumScale); // 未通过比例
        }, 'json');
        timeAll.find('li').unbind(); // 解决重复绑定点击事件问题
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
    $('.time-all').css({
        'transform': 'translateX(-50%) scale(.8, .8)',
        'opacity': 0
    });
    $('#time-to-time').css({
        'transform': 'translateX(-50%) scale(.8, .8)',
        'opacity': 0
    });
    $('#time-to-time').hide();
    $('.time-all').hide();
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
<!-- 时间日期插件 -->
<script type="text/javascript">
$(function() {
    var currYear = (new Date()).getFullYear();
    var opt = {};
    opt.date = {
        preset: 'date'
    };
    opt.datetime = {
        preset: 'datetime'
    };
    opt.time = {
        preset: 'time'
    };
    opt.default = {
        theme: 'android-ics light', // 皮肤样式
        display: 'modal', // 显示方式 
        mode: 'scroller', // 日期选择模式
        dateFormat: 'yyyy-mm-dd',
        lang: 'zh',
        showNow: true,
        nowText: "今天",
        startYear: currYear - 50, // 开始年份
        endYear: currYear + 10 // 结束年份
    };

    // #startTime 指input控件 id   多个用逗号分隔
    $("#startTime, #endTime").mobiscroll($.extend(opt['date'], opt['default']));

    // 从
    var requestDate = $("#startTime").val();
    if (requestDate != "") {
        requestDate = new Date(requestDate);
        $("#startTime").scroller('setDate', requestDate, true);
    }

    // 至
    var endRequestDate = $("#endTime").val();
    if (endRequestDate != "") {
        endRequestDate = new Date(endRequestDate);
        $("#endTime").scroller('setDate', endRequestDate, true);
    }

});
</script>
<!-- end 时间日期插件 -->

    <!-- end 当前页单独js -->
</body>

</html>
