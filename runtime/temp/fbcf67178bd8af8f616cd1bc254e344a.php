<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:36:"app/mobile\view\user_info\index.html";i:1498126736;s:32:"app/mobile\view\common\base.html";i:1497450644;}*/ ?>
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
    <title>安全检查详情页</title>
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
    
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/user_info.css" />


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
        <i class="ion-ios-arrow-left"></i>
        <span>返回</span>
    </div>
    <h2>安全检查详情</h2>
</div>
<div class="clear"></div>
<!-- 选项按钮 -->
<div class="option-box">
    <div class="option isInfo current">入户登记信息</div>
    <div class="option isLog">历史记录</div>
</div>
<!-- 占位 -->
<div style="width: 100%; height: 68px;"></div>
<div class="info-box">
    <!-- 入户登记信息 -->
    <form action="<?php echo url('UserInfo/doInfo'); ?>" method="post" class="room-info" enctype="multipart/form-data" id="goToPost">
        <!-- 上滑隐藏 -->
        <div id="upside-hide">
            <div class="limit-width-box">
                <h2 class="add">详细地址：<span><span id="beforeInfo"><?php echo $roomInfo['area']; ?><?php echo $roomInfo['xq']; ?></span><span class="update-area"></span><span class="update-xq"></span><span class="update-dong"><?php echo $roomInfo['code']; ?></span>栋<span class="update-dy"><?php echo $roomInfo['unit']; ?></span>单元<span class="update-fh"><?php echo $roomInfo['room']; ?></span></span></h2>
                <!-- 地址更新 -->
                <div class="add-update">
                    <div class="arrow">
                        <i class="ion-ios-arrow-up"></i>
                    </div>
                    <div class="input-box">
                        <label>区域：</label>
                        <input type="text" name="area_name" value="<?php echo $roomInfo['area']; ?>" maxlength="10" readonly="true" id="area" />
                        <!-- 隐藏提交区域id -->
                        <input type="hidden" name="xzqy_id" value="<?php echo $roomInfo['xzqy_id']; ?>" id="xzqy_id" />
                    </div>
                    <div class="input-box">
                        <label>小区/街道：</label>
                        <input type="text" name="proj_name" value="<?php echo $roomInfo['xq']; ?>" maxlength="22" readonly="true" id="xq" />
                        <!-- 隐藏提交小区id -->
                        <input type="hidden" name="proj_id" value="<?php echo $roomInfo['xq_id']; ?>" id="proj_id" />
                    </div>
                    <!-- 所有区域 -->
                    <div class="area-all">
                        <div class="head-title">选区域</div>
                        <div class="key-search">
                            <input type="text" />
                        </div>
                        <span class="close-btn">×</span>
                        <ul class="select-main" id="is_area">
                            <?php if(is_array($area) || $area instanceof \think\Collection || $area instanceof \think\Paginator): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
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
                            <?php if(is_array($xq) || $xq instanceof \think\Collection || $xq instanceof \think\Paginator): $i = 0; $__LIST__ = $xq;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li class="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px;"><span id="not-find-fonts">没找到?</span><span id="not-find">新增小区</span><span id="not-find2" style="display: none; margin-top: -16px;">确定</span></p>
                    </div>
                    <script type="text/javascript">
                    // 新增小区
                    $('#not-find').click(function(){
                        $('#is_xq').hide();
                        $('#not-find-fonts').hide();
                        $('#not-find').hide();
                        $('#not-find2').show();
                        $('.xq-all .head-title').html('请输入小区名');                        
                    });
                    $('#not-find2').click(function(){ // 确定新增
                        if ($('.xq-all input').val() == '') {
                            layer.open({
                                content: '请输入小区名再点确认哦',
                                skin: 'msg',
                                time: 2 // 4秒后自动关闭
                            });
                            return false;
                        }
                        $('#xq').val($('.xq-all input').val()); // 小区值
                        close();
                        $('#is_xq').show();
                        $('#not-find-fonts').show();
                        $('#not-find').show();
                        $('#not-find2').hide();
                        $('.xq-all .head-title').html('选小区');
                        layer.open({
                            content: '成功新增小区',
                            skin: 'msg',
                            time: 2 // 4秒后自动关闭
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
                                $(".tips").hide();
                                return false;
                            }
                            var $isCN = true;
                            var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
                            if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
                                $isCN = false;
                            }
                            var $keyWords2 = '';
                            $(".tips").hide();
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
                                    $(".tips").hide();
                                    $showTips = false; // 隐藏未匹配提示
                                }
                            }
                            if ($showTips) {
                                $(".tips").show(); // 未匹配到内容提示
                            }
                        }

                        // 点击li
                        $('#is_area li').bind('click', function() {
                            $('#area').val($(this).html()); // 区域值
                            $('.update-area').html($(this).html()); // 动态更新顶部详细地址区域
                            $('#beforeInfo').hide(); // 隐藏原始地址信息

                            close();
                            var id = $(this).attr('class'); // 区域id
                            $('#xzqy_id').val(id); // 隐藏提交区域id值

                            var html = '';
                            $.ajax({
                                type: "POST",
                                url: "<?php echo url('index/index'); ?>", // 代码复用
                                data: "area_id=" + id,
                                dataType: 'json',
                                success: function(data) {
                                    for (var i = 0; i < data.length; i++) {
                                        html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                                    }
                                    if (html !== '') {
                                        $('#is_xq').html(html); // 更新小区列表
                                    } else {
                                        $('#is_xq').html('<p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px;">该区域暂无目标小区，请新增</p>');
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
                                $(".tips").hide();
                                return false;
                            }
                            var $isCN = true;
                            var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
                            if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
                                $isCN = false;
                            }
                            var $keyWords2 = '';
                            $(".tips").hide();
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
                                    $(".tips").hide();
                                    $showTips = false; // 隐藏未匹配提示
                                }
                            }
                            if ($showTips) {
                                $(".tips").show(); // 未匹配到内容提示
                            }
                        }

                        // 点击li
                        $('#is_xq li').bind('click', function() {
                            $('#xq').val($(this).html()); // 小区值
                            $('.update-xq').html($(this).html()); // 动态更新顶部详细地址小区
                            $('#beforeInfo').hide(); // 隐藏原始地址信息
                            close();
                            var id = $(this).attr('class'); // 小区id
                            $('#proj_id').val(id); // 隐藏提交小区id值
                            $('#is_xq li').unbind(); // 解决重复绑定点击事件问题
                        });
                    });

                    // 关闭弹窗
                    function close() {
                        $('.area-all').css({
                            'transform': 'translateX(-50%) scale(.8, .8)',
                            'opacity': 0
                        });
                        $('.xq-all').css({
                            'transform': 'translateX(-50%) scale(.8, .8)',
                            'opacity': 0
                        });
                        $('.area-all').hide();
                        $('.xq-all').hide();
                        $('.mask').hide();

                        // 恢复初始列表
                        $('#is_area').find('li').show();
                        $('#is_xq').find('li').show();

                        $(".tips").hide(); // 隐藏未匹配提示
                    }
                    $('.close-btn').click(function() { // 关闭按钮
                        close();
                    });
                    $('.mask').click(function() { // 点击遮罩
                        close();
                    });
                    </script>
                    <div class="input-box dong-dy">
                        <label>楼栋：</label>
                        <input type="text" name="dong" value="<?php echo $roomInfo['code']; ?>" maxlength="3" id="update-dong" />
                        <!-- 隐藏提交bld_id -->
                        <input type="hidden" name="bld_id" value="<?php echo $roomInfo['bldID']; ?>" />
                        <label>单元：</label>
                        <input type="text" name="unit" value="<?php echo $roomInfo['unit']; ?>" maxlength="3" id="update-dy" />
                    </div>
                    <div class="input-box">
                        <label>房号：</label>
                        <input type="text" name="room" value="<?php echo $roomInfo['room']; ?>" maxlength="6" id="update-fh" />
                        <!-- 隐藏提交room_id -->
                        <input type="hidden" name="room_id" value="<?php echo $roomInfo['id']; ?>" />
                    </div>
                    <script type="text/javascript">
                        /**
                         * 动态修改栋单元房号
                         */
                        var dong = $('#update-dong'); // 栋
                        var dy = $('#update-dy'); // 单元
                        var fh = $('#update-fh'); // 房号
                        dong.bind('input propertychange', function() {
                            $('.update-dong').html(dong.val());
                        });
                        dy.bind('input propertychange', function() {
                            $('.update-dy').html(dy.val());
                        });
                        fh.bind('input propertychange', function() {
                            $('.update-fh').html(fh.val());
                        });
                    </script>
                </div>
                <div class="clear"></div>
                <!-- 用户信息更新 -->
                <div class="user-info-box">
                    <div class="user-num">
                        <label>用户编号：</label>
                        <input type="text" name="cstcode" value="<?php echo input('get.cstcode'); ?>" style="width: 69px; border-bottom: none;" readonly="true" class="cstcode-input" />
                    </div>
                    <div class="base-num-box">
                        <label>表底数：</label>
                        <input type="text" name="basenumber" maxlength="20" value="<?php echo $roomInfo['basenumber']; ?>" class="base-num" />
                    </div>
                </div>
                <div class="clear"></div>
                <div class="user-info-box">
                    <!-- <div class="select-box" style="margin-right: 3%;">
                        <label>气表类型：</label>
                        <select>
                            <option>测试1</option>
                            <option>测试2</option>
                            <option>测试3</option>
                        </select>
                    </div>
                    <div class="select-box" style="margin-right: 4%;">
                        <label>品牌：</label>
                        <select>
                            <option>测试1</option>
                            <option selected="selected">老虎牌</option>
                            <option>测试3</option>
                        </select>
                    </div> -->
                    <div class="select-box" style="margin-right: 3%;">
                        <label>气表类型：</label>
                        <select name="type">
                        <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option <?php if($roomInfo['type'] == $vo['id']): ?>selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="select-box" style="margin-right: 4%;">
                        <label>品牌：</label>
                        <select name="brand">
                        <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option <?php if($roomInfo['brand'] == $vo['id']): ?>selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="select-box">
                        <label>进气方向：</label>
                        <select id="path" name="direction">
                            <option value="上">上</option>
                            <option value="下">下</option>
                            <option value="左">左</option>
                            <option value="右">右</option>
                        </select>
                    </div>
                    <script type="text/javascript">
                    // 进气方向
                    $('#path option').each(function(i){
                         if ($(this).val() == '<?php echo $roomInfo['direction']; ?>') {
                            $(this).attr('selected', 'selected');
                            return false;
                         }
                     });
                    </script>
                </div>
                <div class="clear"></div>
                <div class="user-info-box">
                    <label>姓名：</label>
                    <input type="text" name="cstname" value="<?php echo $roomInfo['cstname']; ?>" class="input-name" maxlength="10" />
                </div>
                <div class="user-info-box">
                    <label>联系人电话：</label>
                    <input type="text" name="telphone" value="<?php echo $roomInfo['telphone']; ?>" class="input-tel" maxlength="60" />
                </div>
            </div>
            <div class="clear"></div>
            <div style="width: 100%; height: 12px; background-color: #dcdcdc;"></div>
            <!-- test -->
            <!-- <link rel="stylesheet" type="text/css" href="__MOBILE__/css/webuploader.css">
            <link rel="stylesheet" type="text/css" href="__MOBILE__/css/diyUpload.css">
            <div id="box">
                <div id="test" ></div>
            </div> -->
            <!-- end test -->
            <!-- test 2 -->
            <!-- <link rel="stylesheet" type="text/css" href="__MOBILE__/css/HHuploadify.css" />
            <div id="upload"></div> -->
            <!-- end test 2 -->
            <!-- test3 -->
            <link rel="stylesheet" type="text/css" href="__MOBILE__/js/test/tinyImgUpload.css">
            <script type="text/javascript" src="__MOBILE__/js/test/tinyImgUpload.js"></script>
            <!-- end test3 -->
            <div class="photo">
                <div class="upload">
                    <h4>照片</h4>
                    <!-- <label for="j-file2" class="mbUploadify" id="j-dropArea">
                        <div class="upload-icon">
                            <i class="ion-ios-camera-outline"></i>
                            <input type="file" name="image[]" id="file-5" class="file"  multiple> 
                        </div>
                    </label> -->
                    <!-- 判断是否穿透查询 -->
                    <?php if(!empty($imgUrl)): ?>
                        <div id="get-view">
                            <?php if(is_array($imgUrl) || $imgUrl instanceof \think\Collection || $imgUrl instanceof \think\Paginator): $i = 0; $__LIST__ = $imgUrl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <div class="view-img">
                                    <img src="<?php echo $vo['url']; ?>">
                                    <a href="javascript:;" class="del-img ion-android-cancel"></a>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    <?php endif; ?>
                    <script type="text/javascript">
                        $('.del-img').click(function(){ // 删除已上传的图片

                            // 先定义变量，否则后面无法找到$(this)
                            var imgDiv = $(this).parent(); // 定位父节点，即图片盒子
                            var nowImgUrl = $(this).siblings().attr('src'); // siblings找到同级元素

                            // 询问框
                            layer.open({
                                content: '删除后无法恢复，要继续么？', btn: ['继续', '算了'], yes: function(index){
                                    $.get("<?php echo url('user_info/deleteImg'); ?>", {nowImgUrl: nowImgUrl}, function(data){
                                        if (data == 1) {
                                            layer.open({
                                                content: '图片删除成功',
                                                skin: 'msg',
                                                time: 2 // 2秒后自动关闭
                                            });
                                            imgDiv.remove(); // 移除图片DOM节点
                                        } else {
                                            layer.open({
                                                content: data,
                                                skin: 'msg',
                                                time: 2 // 2秒后自动关闭
                                            });
                                        }
                                    }, 'text'); // 返回文本，1成功 0失败
                                    layer.close(index);
                                }
                            });
                        });
                    </script>
                    <div id="upload">
                    </div>
                    <div class="go-submit" style="display: none;">开始上传图片</div>
                </div>
                <div id="submitIMG"></div>
            </div>
            <div class="clear"></div>
            <script type="text/javascript">
            document.documentElement.style.fontSize = document.documentElement.clientWidth*0.1+'px';
            var options = {
                path: '<?php echo url('user_info/doImg'); ?>',
                onSuccess: function (res) { // 根据xhr返回状态码判断成功与否
                    layer.open({
                        content: '图片已上传成功',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                    let dataObj = eval(res); // json转对象
                    for (var i = 0; i < dataObj.length; i++) { // 原生最快
                        document.getElementById('submitIMG').innerHTML += '<input type="hidden" name="image[]" value="' + dataObj[i].url + '" />';
                    }
                    document.getElementsByClassName('go-submit')[0].style.display = 'none';
                    var removeBtn = document.getElementsByClassName('img-remove');
                    for (var i = 0; i < removeBtn.length; i++) { // 隐藏所有红x
                        removeBtn[i].style.display = 'none';
                    }
                    document.getElementsByClassName('select-btn')[0].style.display = 'none';
                },
                onFailure: function (res) {
                    // console.log(res);
                    alert('出错了');
                }
            }
            var upload = tinyImgUpload('#upload', options);
            var goSubmit = document.getElementsByClassName('go-submit')[0];
            // document.getElementById('upload').onclick = function(){
            //     goSubmit.style.display = 'block';
            // }
            goSubmit.onclick = function (e) {
                var imgNum = $('#img-container img').size(); // 图片数量
                var viewImgNum = $('#get-view img').size(); // 已上传图片数量
                var allImgNum = imgNum + viewImgNum; // 总图片数量
                if (imgNum === 0) {
                    layer.open({
                        content: '请先点击上方相机图标选择图片',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                } else if (allImgNum > 8) {
                    layer.open({
                        content: '图片不能超过8张',
                        skin: 'msg',
                        time: 2 // 2秒后自动关闭
                    });
                } else {
                    upload();
                }
                return false; // 阻止触发整张表单的post事件
            }
            document.getElementsByClassName('select-btn')[0].onclick = function(){
                goSubmit.style.display = 'block';
            }
            </script>
            <div class="upside-fonts"><i class="ion-chevron-up"></i>上滑填写安全检查</div>
        </div>
        <!-- 安全检查信息填写 -->
        <div id="is-input-info">
            <h2 class="title-box">检查内容</h2>
            <ul>
            <!-- 判断是否穿透查询 -->
            <?php if(!empty($toGetPro)): ?>
            <!-- 标记穿透查询问题记录详情的修改 -->
            <input type="hidden" name="resetPro" value="1" />
            <!-- 穿透查询新增图片条件 -->
            <input type="hidden" name="check_id" value="<?php echo input('get.check_id'); ?>">
            <?php if(is_array($toGetPro) || $toGetPro instanceof \think\Collection || $toGetPro instanceof \think\Paginator): $i = 0; $__LIST__ = $toGetPro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <div class="problem">
                        <?php echo $vo['question']; ?>：
                    </div>
                    <!-- 隐藏提交问题 -->
                    <input type="hidden" name="<?php echo $vo['id']; ?>[question]" value="<?php echo $vo['question']; ?>" />
                    <div class="answer">
                        <label class="yes<?php echo $vo['id']; ?>">
                            <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="1" class="answer-option" <?php if($vo['answer'] == '1'): ?>checked="checked"<?php endif; ?> />
                            <span><?php echo $vo['yes']; ?><i <?php if($vo['answer'] == '1'): ?>class="ion-ios-checkmark-outline"<?php else: ?>class="ion-ios-circle-outline"<?php endif; ?> data="1"></i></span>
                        </label>
                        <label class="no<?php echo $vo['id']; ?>">
                            <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="0" class="answer-option" <?php if($vo['answer'] == '0'): ?>checked="checked"<?php endif; ?> />
                            <span><?php echo $vo['no']; ?><i <?php if($vo['answer'] == '0'): ?>class="ion-ios-checkmark-outline"<?php else: ?>class="ion-ios-circle-outline"<?php endif; ?> data="0"></i></span>
                        </label>
                        <i class="ion-ios-compose-outline edit" id="edit<?php echo $vo['id']; ?>"></i>
                    </div>
                    <div class="clear"></div>
                    <input type="text" name="<?php echo $vo['id']; ?>[remark]" value="<?php echo $vo['remark']; ?>" class="idea" id="idea<?php echo $vo['id']; ?>" placeholder="请填写处理意见" />
                </li>

                <script type="text/javascript">
                    // 编辑
                    $('#edit<?php echo $vo['id']; ?>').click(function(){
                        $('#idea<?php echo $vo['id']; ?>').fadeToggle('fast'); // 淡入淡出
                    }); 

                    // 穿透查询已审核的记录不允许点击答案，但可打开点击编辑框
                    <?php if(isset($logStatus) && $logStatus !== 1 && $_GET['checkuserid'] == session('checkuserid')): ?>

                        // 选答案
                        $('.yes<?php echo $vo['id']; ?>').click(function(){ // 此处仅改变图标，checked依赖于默认的单选框事件
                            $('.yes<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-checkmark-outline'); // 打勾
                            $('.no<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-circle-outline'); // 去钩
                        });
                        $('.no<?php echo $vo['id']; ?>').click(function(){
                            $('.no<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-checkmark-outline');
                            $('.yes<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-circle-outline');
                            $('#idea<?php echo $vo['id']; ?>').fadeTo('fast', 1); // 自动打开编辑框
                            $('.all-yes-btn i').attr('class', 'ion-ios-circle-outline'); // 去掉全部无问题的钩
                        });
                    <?php endif; ?>
                </script>
            <?php endforeach; endif; else: echo "" ;endif; else: if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <div class="problem">
                        <?php echo $vo[0]; ?>：
                    </div>
                    <!-- 隐藏提交问题 -->
                    <input type="hidden" name="<?php echo $vo['id']; ?>[question]" value="<?php echo $vo[0]; ?>" />
                    <!-- 隐藏提交答案名，以“|”分隔 -->
                    <input type="hidden" name="<?php echo $vo['id']; ?>[answername]" value="<?php echo $vo[1]; ?>|<?php echo $vo[2]; ?>" />
                    <div class="answer">
                        <label class="yes<?php echo $vo['id']; ?>">
                            <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="1" class="answer-option" />
                            <span><?php echo $vo[1]; ?><i class="ion-ios-circle-outline" data="1"></i></span>
                        </label>
                        <label class="no<?php echo $vo['id']; ?>">
                            <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="0" class="answer-option" />
                            <span><?php echo $vo[2]; ?><i class="ion-ios-circle-outline" data="0"></i></span>
                        </label>
                        <i class="ion-ios-compose-outline edit" id="edit<?php echo $vo['id']; ?>"></i>
                    </div>
                    <div class="clear"></div>
                    <input type="text" name="<?php echo $vo['id']; ?>[remark]" value="" class="idea" id="idea<?php echo $vo['id']; ?>" placeholder="请填写处理意见" />
                </li>
                <script type="text/javascript">
                    // 编辑
                    $('#edit<?php echo $vo['id']; ?>').click(function(){
                        $('#idea<?php echo $vo['id']; ?>').fadeToggle('fast'); // 淡入淡出
                    }); 

                    // 选答案
                    $('.yes<?php echo $vo['id']; ?>').click(function(){
                        $('.yes<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-checkmark-outline'); // 打勾
                        $('.no<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-circle-outline'); // 去钩
                    });
                    $('.no<?php echo $vo['id']; ?>').click(function(){
                        $('.no<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-checkmark-outline');
                        $('.yes<?php echo $vo['id']; ?> i').attr('class', 'ion-ios-circle-outline');
                        $('#idea<?php echo $vo['id']; ?>').fadeTo('fast', 1); // 自动打开编辑框
                        $('.all-yes-btn i').attr('class', 'ion-ios-circle-outline'); // 去掉全部无问题的钩
                    });
                </script>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </ul>
            <div class="all-yes">
                <!-- 非穿透查询默认显示全部无问题按钮 -->
                <?php if(!isset($_GET['from']) || $_GET['from'] != 'myLog'): ?>
                <div class="all-yes-btn">全部无问题<i class="ion-ios-circle-outline"></i></div>
                <!-- 判断审核通过与否 -->
                <?php elseif(isset($logStatus) && $logStatus !== 1 && $_GET['checkuserid'] == session('checkuserid')): ?>
                <div class="all-yes-btn">全部无问题<i class="ion-ios-circle-outline"></i></div>
                <?php endif; ?>
            </div>
            <!-- 下滑隐藏 -->
            <div class="slide-down">
                <!-- 隐藏提交状态：0待审核 -->
                <input type="hidden" name="status" value="0" />
                <!-- 隐藏提交检查人id - 没必要，后台从session中取 -->
                <!-- <input type="hidden" name="checkuserid" value="1" /> -->
                <!-- 不是穿透查询情况默认显示提交按钮 -->
                <?php if(!isset($_GET['from']) || $_GET['from'] != 'myLog'): ?>
                <input type="button" value="提交" class="goToSubmit" />
                <!-- 判断审核通过与否 -->
                <!-- 0相当于空，故此处用isset判断 -->
                <?php 
                // 此处session默认未start，使用助手函数自动start，否则得单独开启session
                elseif(isset($logStatus) && $logStatus !== 1 && $_GET['checkuserid'] == session('checkuserid')):
                 ?>
                <input type="button" value="提交" class="goToSubmit" />
                <?php endif; ?>
                <p class="slide-down-fonts"><i class="ion-chevron-down"></i>下滑查看入户登记</p>
            </div>
            <script type="text/javascript">
                $('.goToSubmit').click(function(){ // 点击提交
                    // $('#goToPost').submit(); // 触发表单提交
                    // alert(22)
                    $('.goToSubmit').attr('value', '正在提交');
                    var jumpTime = 2000; // 跳转时间
                    $.post("<?php echo url('UserInfo/doInfo'); ?>", $('#goToPost').serialize(), function(data){ // 异步post，方便加tips
                        if (data === 1) {
                            layer.open({
                                content: '恭喜，提交成功',
                                style: 'background-color:#fff; color:#000; border:none; font-size: 16px;', //自定风格
                                shadeClose: false // 不允许点击遮罩
                                // time: 3
                            });
                            setTimeout(function() {
                                window.history.go(-1);
                            }, jumpTime);
                        } else {
                            layer.open({
                                content: '出了一点小状况，请稍后重试',
                                style: 'background-color:#fff; color:#000; border:none; font-size: 16px;', //自定风格
                                shadeClose: false // 不允许点击遮罩
                                // time: 3
                            });
                            setTimeout(function() {
                                window.history.go(-1);
                            }, jumpTime);
                            $('.goToSubmit').attr('value', '提交');
                        }
                    }, 'json');
                    return false; // 阻止事件穿透
                });
            </script>
        </div>
    </form>
    <!-- 历史记录 -->
    <ul id="log"></ul>
</div>

    <!-- end 主体内容 -->
    <!-- 底部 -->
    
    </div>
    <!-- 当前页单独js -->
    
<script type="text/javascript">

// 返回
$('.back').click(function(){
    window.history.go(-1);
});

// 选项
$('.option-box .option').click(function() {
    $('.option-box .option').removeClass('current');
    $(this).addClass('current');
});
$('.isInfo').click(function() { // 入户登记信息
    $('#is-input-info').hide();
    $('#upside-hide').show();
    $('#log').hide();
    $('.isInfo').html('入户登记信息');
});
$('.isLog').click(function() { // 点击历史记录
    $('#is-input-info').hide();
    $('#upside-hide').hide();
    $('#log').show();

    // 历史记录数据
    $.get("<?php echo url('UserInfo/history'); ?>", {cstcode: <?php echo input('get.cstcode'); ?>}, function(data){
        var html = '';
        var f = 1; // 隔行换色
        let dataObj = eval(data); // json转对象
        for (var i = 0; i < dataObj.length; i++) {
            if (f % 2 !== 0) { // 判断奇偶行
                html += '<li style="background-color: #d8d8d8;">';
            } else {
                html += '<li>';
            }
            // &check_id=217&status=0&from=myLog
            html += '<a href="<?php echo url('mobile/user_info/index'); ?>?cstcode=<?php echo input('get.cstcode'); ?>&check_id=' + dataObj[i].id + '&status=' + dataObj[i].status + '&checkuserid=' + dataObj[i].checkuserid + '&from=myLog" class="log-limit">';
                html += '<span class="log-left">';
                    html += '<span>检查人：'+dataObj[i].name+'</span>';
                html += '<span>状&nbsp;&nbsp;&nbsp;态：'+dataObj[i].statusCN+'</span>';
                html += '</span>';
                html += '<span class="log-right">';
                    html += '<span>检查时间：'+dataObj[i].checktime+'</span>';
                html += '<span>安全隐患：'+dataObj[i].havePro+'</span>';
                html += '</span>';
            html += '</a>';
            html += '</li>';
            f++;
        }
        $('#log').html(html);
    }, 'json'); 
});

// 上滑填写安全检查
$('.upside-fonts').click(function() {
    $('#is-input-info').show();
    $('#upside-hide').hide();
    $('.isInfo').html('安全检查信息');
});

// 下滑查看入户登记
$('.slide-down').click(function() {
    $('#is-input-info').hide();
    $('#upside-hide').show();
    $('.isInfo').html('入户登记信息');
});

// 点击答案
/*$('.answer label i').click(function() {
    $(this).removeClass('ion-ios-circle-outline');
    $(this).addClass('ion-ios-checkmark-outline');
});*/

// 全部无问题
$('.all-yes-btn').click(function() {

    // 全无问题Btn
    // if ($('.all-yes-btn i').attr('class') == 'ion-ios-circle-outline') {
        $('.all-yes-btn i').attr('class', 'ion-ios-checkmark-outline');
    // } else {
        // $('.all-yes-btn i').attr('class', 'ion-ios-circle-outline');
    // }

    // 所有通过项样式
    $('.answer label i').each(function(i){
        if($(this).attr('data') == 1){ // 通过选项
            $(this).attr('class', 'ion-ios-checkmark-outline');
        } else { // 不通过选项
            $(this).attr('class', 'ion-ios-circle-outline');
        }
     });

    // 选中所有通过项
    $('.answer .answer-option').each(function(i){
        if ($(this).val() == 1) { // 1通过
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeAttr('checked');
        }
    });
});

//loading层
// layer.open({type: 2});
</script>

<!-- 图片上传 -->
<script type="text/javascript" src="__MOBILE__/js/mbUploadify.js"></script>
<script type="text/javascript">
/*   var klk; 
    var i=0;
var upload2 = new mbUploadify(document.querySelector('form'), {

    dropElement: document.getElementById('j-dropArea'),
    load: function(e){

        document.getElementById('preview2').innerHTML += '<img src="'+ e.target.result +'" dataid='+i+' >';
        i++;
        $('#preview2 img').click(function(){
            var dataid=$(this).attr("dataid");
            $('input[dataid=dataid]').remove();
            $(this).remove();
            alert(dataid);
            // klk[pp].Delete();
            // alert(klk);
                // alert(klk.length);
        });
    }
});*/
</script>
<!-- test -->
<!-- <script type="text/javascript" src="__MOBILE__/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="__MOBILE__/js/diyUpload.js"></script> -->
<script type="text/javascript">
/*    $('#test').diyUpload({
    url: "<?php echo url('UserInfo/doInfo'); ?>",
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );    
    }
});*/

</script>
<!-- end test -->

<!-- test 2 -->
<script type="text/javascript" src="__MOBILE__/js/HHuploadify.js"></script>
<script>
    /*$('#upload').HHuploadify({
        fileTypeExts:'*.jpg;*.png;*.gif',
        auto: false,//是否开启自动上传
        uploader: "<?php echo url('UserInfo/doImg'); ?>", // 必须的，必须指定用来处理上传逻辑的后端处理URL
        fileObjName:'image' //在后端接受文件的参数名称，如PHP中的$_FILES['file']
    });*/
</script>
<!-- end test 2 -->

<!-- test3 -->
<!-- 图片上传引用 -->
<!-- <link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/bootstrap.min.js" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/fileinput.min.css" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/fileinput.min.js" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/sortable.min.js" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/theme.min.css" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/theme.min.js" />
<link rel="stylesheet" type="text/css" href="__MOBILE__/js/forUpload/zh.js" /> -->

<!-- end 图片上传引用 -->
<!-- <script type="text/javascript">


    $("#file-5").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        language: 'zh',
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 8,
        allowedFileTypes: ['image'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });


</script> -->
<!-- end test3 -->


    <!-- end 当前页单独js -->
</body>

</html>
