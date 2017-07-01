<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:35:"app/home\view\do_check\editlog.html";i:1498818381;s:30:"app/home\view\common\base.html";i:1498787932;}*/ ?>
﻿<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="utf-8" />

		<title>燃气入户安全检查管理系统</title>



		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<script >
            var tNav="<?php echo url('home/Index/tNav'); ?>";
        </script>

		<!-- basic styles -->

		<link href="__PC__/assets/css/bootstrap.min.css" rel="stylesheet" />

		<link rel="stylesheet" href="__PC__/assets/css/font-awesome.min.css"/>
		<link href="__PC__/assets/easyui/jquery-easyui-1.4.5/themes/bootstrap/easyui.css" rel="stylesheet" type="text/css"/>
		<link href="__PC__/assets/easyui/jquery-easyui-1.4.5/themes/icon.css" rel="stylesheet" type="text/css"/>
		<link href="__PC__/assets/easyui/CustomizedStyle.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="__PC__/assets/css/font-awesome.min.css" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="__PC__/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<!-- page specific plugin styles -->
		<!-- ace styles -->
		<link rel="stylesheet" href="__PC__/assets/css/ace.min.css" />

		<link rel="stylesheet" href="__PC__/assets/css/ace-rtl.min.css" />

		<link rel="stylesheet" href="__PC__/assets/css/ace-skins.min.css" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="__PC__/assets/css/ace-ie.min.css" />
		  <link rel="stylesheet" href="__PC__/assets/css/myCss/re.css" />
		<![endif]-->
		<!-- inline styles related to this page -->
		<!-- ace settings handler -->
		<script src="__PC__/assets/js/ace-extra.min.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>

		<script src="__PC__/assets/js/html5shiv.js"></script>

		<script src="__PC__/assets/js/respond.min.js"></script>
		<script >
			var tNav="<?php echo url('home/Index/tNav'); ?>"
		</script>

		<![endif]-->
		<style>
			.progressBar {
				display: block;
				width: 32px;
				height: 32px;
				position: fixed;
				top: 50%;
				left: 50%;
				position: absolute;
				z-index: 2001;
			}
		</style>

	</head>



	<body>
	<div id="hids" style="width: 100%;height: 100%;position:absolute;display:none;background-color: rgba(0,0,0,0.5)"></div>
	<div id="hids1" style="width: 100%;height: 100%;position:absolute;display:none;background-color: rgba(255,255,255,0);z-index: 1000"></div>
	<div id="progressBar" class="progressBar" style="display: none; ">
		<img src="__PC__/assets/css/images/loading.gif" >
	</div>
	<div class="navbar navbar-default" id="navbar">

			<script type="text/javascript">

				try{ace.settings.check('navbar' , 'fixed')}catch(e){}

			</script>



			<div class="navbar-container" id="navbar-container">

				<div class="navbar-header pull-left">

					<a href="#" class="navbar-brand">

						<small>

							<i class="icon-lemon"></i>

							燃气入户安全检查管理系统

						</small>

					</a><!-- /.brand -->

				</div><!-- /.navbar-header -->



				<div class="navbar-header pull-right" role="navigation">

					<ul class="nav ace-nav">




						<li class="light-blue">

							<a data-toggle="dropdown" href="#" class="dropdown-toggle">

								<img class="nav-user-photo" src="__PC__/assets/avatars/avatar2.png" alt="Jason's Photo" />

								<span class="user-info" id="users" >
									<small>当前用户：</small>
									<span></span>
								</span>
								<i class="icon-caret-down"></i>
							</a>
							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>

									<a href="#" id="updatePwd"  data-toggle="modal" data-target="#myModalPwd">
										<i class="icon-pencil"></i>
										修改密码
									</a>

								</li>
								<li>

									<a href="#" id="sesOut">

										<i class="icon-off"></i>

										退出

									</a>

								</li>

							</ul>

						</li>

					</ul><!-- /.ace-nav -->

				</div><!-- /.navbar-header -->

			</div><!-- /.container -->

		</div>



		<div class="main-container" id="main-container">

			<script type="text/javascript">

				try{ace.settings.check('main-container' , 'fixed')}catch(e){}

			</script>



			<div class="main-container-inner">

				<a class="menu-toggler" id="menu-toggler" href="#">

					<span class="menu-text"></span>

				</a>



				<div class="sidebar" id="sidebar">

					<script type="text/javascript">

						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}

					</script>



					<div class="sidebar-shortcuts" id="sidebar-shortcuts">

						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">

							<button class="btn btn-success">

								<i class="icon-signal"></i>

							</button>



							<button class="btn btn-info">

								<i class="icon-pencil"></i>

							</button>



							<button class="btn btn-warning">

								<i class="icon-group"></i>

							</button>



							<button class="btn btn-danger">

								<i class="icon-cogs"></i>

							</button>

						</div>



						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">

							<span class="btn btn-success"></span>



							<span class="btn btn-info"></span>



							<span class="btn btn-warning"></span>



							<span class="btn btn-danger"></span>

						</div>

					</div><!-- #sidebar-shortcuts -->



					<ul class="nav nav-list" id="re-list">

						

						
    <?php if(is_array($res) || $res instanceof \think\Collection || $res instanceof \think\Paginator): if( count($res)==0 ) : echo "" ;else: foreach($res as $key=>$vo): switch($vo['id']): case "1": ?>
                <li f_id="<?php echo $vo['id']; ?>">
                    <a href="#">
                        <i class="icon-edit"></i>
                        <span class="menu-text"> <?php echo $vo['name']; ?> </span>
                    </a>

                </li>
            <?php break; case "2": ?>
                <li f_id="<?php echo $vo['id']; ?>">
                    <a href="#" >
                        <i class=" icon-barcode"></i>
                        <span class="menu-text">  <?php echo $vo['name']; ?> </span>
                    </a>
                </li>
            <?php break; case "3": ?>
                <li f_id="<?php echo $vo['id']; ?>">
                    <a href="#">
                        <i class=" icon-credit-card"></i>
                        <span class="menu-text">  <?php echo $vo['name']; ?> </span>
                    </a>
                </li>
            <?php break; case "4": ?>
            <li f_id="<?php echo $vo['id']; ?>">
                <a href="#">
                    <i class="icon-cogs"></i>
                    <span class="menu-text">  <?php echo $vo['name']; ?> </span>
                </a>
            </li>
            <?php break; case "5": ?>
                <li f_id="<?php echo $vo['id']; ?>">
                    <a href="#" >
                        <i class="icon-desktop"></i>
                        <span class="menu-text">  <?php echo $vo['name']; ?> </span>
                    </a>
                </li>
            <?php break; case "6": ?>
                <li f_id="<?php echo $vo['id']; ?>">
                    <a href="#" >
                        <i class="icon-book"></i>
                        <span class="menu-text">  <?php echo $vo['name']; ?> </span>
                    </a>
                </li>
            <?php break; default: ?>default
        <?php endswitch; endforeach; endif; else: echo "" ;endif; ?>


					</ul><!-- /.nav-list -->



					<div class="sidebar-collapse" id="sidebar-collapse">

						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>

					</div>



					<script type="text/javascript">

						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}

					</script>

				</div>



				<div class="main-content">

					<div class="breadcrumbs" id="breadcrumbs">

						<script type="text/javascript">

							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}

						</script>



						<ul class="breadcrumb">

							<li>

								<i class="icon-home home-icon"></i>

								<a href="#">首页</a>

							</li>

						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">

						<div class="row" >

							<div class="col-xs-12"  >
								
<!-- 字体图标 -->
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/ionicons.min.css" />
<!-- end 字体图标 -->

<!-- layer -->

<link rel="stylesheet" type="text/css" href="__PC__/layui/css/layui.css" />
<script type="text/javascript" src="__PC__/layui/lay/dest/layui.all.js"></script>
<!-- <script type="text/javascript" src="__PC__/layui/layui.js"></script> -->
<!-- <script type="text/javascript">
    layui.config({
        base: '__PC__/layui/lay/modules/' // 模块目录
    }).use('laypage'); // 加载入口
</script> -->
<style type="text/css">
/*#layui-laypage-0 {
	float: right;
	width: auto;
}*/
.row {
	margin: 0;
}
.layui-laypage-curr, .layui-laypage-em {
	background-color: #6faed9!important;
}
</style>
<style type="text/css">
    #problem{
        width: 100%;
        height: auto;
    }
    #problem li {
        float: left;
        width: 40%;
        line-height: 40px;
        position: relative;
    }
    .problem {
        float: left;
    }
    .answer {
        float: right;
        width: 124px;
    }
    .answer label {
        width: 60px;
        text-align: right;
        cursor: pointer;
    }
    .answer i, .all-yes-btn i {
        font-size: 22px;
        color: #17a3ff; /* 图标颜色 */
        cursor: pointer;
    }
    .yes {
        /*margin-right: 4%;*/
    }
    .answer-option {
        display: none;
    }
    .edit {
        position: absolute;
        right: -24px;
        top: 0;
    }
    .idea {
        /* 填写处理意见 */
        width: 100%;
        height: 60px;
        border: 1px solid #0096f7;
        padding-left: 4%;
        display: none;
    }
    /*图片预览*/

/*.view-img {
    position: relative;
    float: left;
    margin-right: 0.1875rem;
    margin-bottom: 0.1875rem;
    width: 30%;
    height: auto;
    box-sizing: border-box;
}*/

.view-img img {
    width: 100%;
    height: 100%;
}

/*#get-view {
    padding-left: 6.9999%;
}*/

/*.del-img {
    position: absolute;
    right: -0.1875rem;
    top: -0.1875rem;
    display: block;
    width: 0.375rem;
    height: 0.375rem;
    border-radius: 50%;
    color: #f7333d;
    text-align: center;
    text-decoration: none;
    font-size: 0.4rem;
    overflow: hidden;
    background-clip: padding-box;
    background: #fff;
}*/


/*end 图片预览*/
</style>
<!-- end layer -->
<table style="width: 100%; height: 86px;">
    <tr style="line-height: 42px;">
        <td colspan="2">详细地址：<?php echo $roomInfo['cityName']; ?><?php echo $roomInfo['areaName']; ?><?php echo $roomInfo['xqName']; ?><?php echo $roomInfo['dong']; ?><?php echo $roomInfo['unit']; ?>单元<?php echo $roomInfo['room']; ?></td>
        <td style="width: 30%;">检查人：<?php echo $roomInfo['checker']; ?></td>
        <td style="width: 30%;">检查时间：<?php echo date("Y-m-d H:i:s", $roomInfo['checktime']); ?></td>
    </tr>
    <tr style="line-height: 42px;">
        <td style="width: 25%;">姓名：<?php echo $roomInfo['cstname']; ?></td>
        <td style="width: 25%;">电话：<?php echo $roomInfo['telphone']; ?></td>
        <td style="width: 25%;">用户编号：<?php echo $roomInfo['cstcode']; ?></td>
        <td style="width: 25%;">表底数：<?php echo $roomInfo['basenumber']; ?></td>
    </tr>
</table>
<div style="width: 100%; height: 1px; background-color: #ccc;"></div>
<div class="col-sm-12" style="line-height: 70px; height: 70px;">
    <div class="col-sm-8">
        <label style="margin-right: 4%;">
            <span>气表类型：</span>
            <select style="border: 1px solid #307ecc; border-radius: 6px;" name="type">
                <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option <?php if($roomInfo['type'] == $vo['id']): ?>selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </label>
        <label style="margin-right: 4%;">
            <span>品牌：</span>
            <select style="border: 1px solid #307ecc; border-radius: 6px;" name="brand">
                <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option <?php if($roomInfo['brand'] == $vo['id']): ?>selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </label>
        <label>
            <span>进气方向：</span>
            <select style="border: 1px solid #307ecc; border-radius: 6px;" name="direction" id="path">
                <option value="上">上</option>
                <option value="下">下</option>
                <option value="左">左</option>
                <option value="右">右</option>
            </select>
        </label>
        <script type="text/javascript" src="__MOBILE__/js/jquery-1.8.3.min.js"></script>
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
</div>
<!-- 上传照片引用 -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="__PC__/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="__PC__/fileinput/theme.css" media="all" rel="stylesheet" type="text/css"/>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="__PC__/fileinput/sortable.js" type="text/javascript"></script>
<script src="__PC__/fileinput/fileinput.js" type="text/javascript"></script>
<script src="__PC__/fileinput/zh.js" type="text/javascript"></script>
<script src="__PC__/fileinput/theme.js" type="text/javascript"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script> -->
<!-- end 上传照片引用 -->
<!-- form表单 -->
<form action="#" method="post" class="room-info" enctype="multipart/form-data" id="goToPost">
    <div>上传照片</div>
    <!-- <input id="file-5" class="file" type="file" multiple data-preview-file-type="any" data-upload-url="#">
    <script>
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
    <!-- test -->
    <!-- 引入图标库 -->
    <link rel="stylesheet" type="text/css" href="__MOBILE__/css/ionicons.min.css" />
    <!-- end 引入图标库 -->
    <link rel="stylesheet" type="text/css" href="__PC__/uploadImg/tinyImgUpload.css">
    <script type="text/javascript" src="__PC__/uploadImg/tinyImgUpload.js"></script>
    <!-- end test -->
    <div class="col-sm-12" style="border: 1px solid #17a3ff; padding: 2%;">
        <div id="get-view">
            <?php if(is_array($imgUrl) || $imgUrl instanceof \think\Collection || $imgUrl instanceof \think\Paginator): $i = 0; $__LIST__ = $imgUrl;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="view-img">
                    <img src="<?php echo $vo['url']; ?>">
                    <div href="javascript:;" class="del-img ion-android-cancel"></div>
                </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div id="upload"></div>
        <div class="btn btn-primary go-submit" style="display: none;">开始上传</div>
    </div>
    <div id="submitIMG"></div>
    <!-- 穿透编辑图片 -->
    <script type="text/javascript">
        $('.del-img').click(function(){ // 删除已上传的图片

            // 先定义变量，否则后面无法找到$(this)
            var imgDiv = $(this).parent(); // 定位父节点，即图片盒子
            var nowImgUrl = $(this).siblings().attr('src'); // siblings找到同级元素

            // 询问框
            swal({ 
                title: '删除后无法恢复，要继续么？', 
                text: '此操作不可逆', 
                type: 'warning',
                showCancelButton: true, 
                cancelButtonText: '算了',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '继续', 
                closeOnConfirm: false
            },
            function(){
                $.get("<?php echo url('home/do_check/deleteImg'); ?>", {nowImgUrl: nowImgUrl}, function(data){
                    if (data == 1) {
                        // swal('图片删除成功'); 
                        swal({ 
                            title: '图片删除成功', 
                            timer: 1000, 
                            showConfirmButton: false 
                        });
                        imgDiv.remove(); // 移除图片DOM节点
                    } else {
                        sweetAlert(data, '出了一点小状况，过一会再试吧', 'error');
                    }
                }, 'json'); // 1成功 0失败
                
            });
        });
    </script>
    <!-- end 穿透编辑图片 -->


    <!-- test -->
    <script type="text/javascript">
        
        var goSubmit = document.getElementsByClassName('go-submit')[0];
        var options = {
            path: '<?php echo url('home/do_check/doImg'); ?>',
            onSuccess: function (res) { // 根据xhr返回状态码判断成功与否
                document.getElementsByClassName('go-submit')[0].innerHTML = '开始上传';
                // swal('图片已成功上传');
                swal({ 
                    title: '图片已成功上传', 
                    timer: 1000, 
                    showConfirmButton: false 
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
                // goSubmit.innerHTML = '开始上传';
                sweetAlert('哎呀...', '出了一点小状况，过一会再试吧', 'error');
            }
        }
        var upload = tinyImgUpload('#upload', options);
        // document.getElementById('upload').onclick = function(){
        //     goSubmit.style.display = 'block';
        // }
        goSubmit.onclick = function (e) {
            var imgNum = $('#img-container img').size(); // 图片数量
            var viewImgNum = $('#get-view img').size(); // 已上传图片数量
            var allImgNum = imgNum + viewImgNum; // 总图片数量
            if (imgNum === 0) {
                sweetAlert('哎呀...', '您还没有选择图片', 'error');
            } else if (allImgNum > 8) {
                sweetAlert('哎呀...', '图片不能超过8张', 'error');
            } else {
                document.getElementsByClassName('go-submit')[0].innerHTML = '正在上传';
                upload();
            }
            return false; // 阻止触发整张表单的post事件
        }
        document.getElementsByClassName('select-btn')[0].onclick = function(){
            goSubmit.style.display = 'block';
        }

    </script>
    <!-- end test -->



    
    <div class="col-sm-12">
        <ul id="problem">
        <?php if(is_array($toGetPro) || $toGetPro instanceof \think\Collection || $toGetPro instanceof \think\Paginator): $i = 0; $__LIST__ = $toGetPro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 1 );++$i;?>
            <li <?php if ($i%2 == 1): ?>style="margin-right: 19%;"<?php endif; ?>>
                <div class="problem">
                    <?php echo $vo['question']; ?>：
                </div>
                <!-- 隐藏提交问题 -->
                <input type="hidden" name="<?php echo $vo['id']; ?>[question]" value="<?php echo $vo['question']; ?>" />
                <div class="answer">
                    <label class="yes<?php echo $vo['id']; ?>">
                        <span><?php echo $vo['yes']; ?><i <?php if($vo['answer'] == '1'): ?>class="ion-ios-checkmark-outline"<?php else: ?>class="ion-ios-circle-outline"<?php endif; ?> data="1"></i></span>
                        <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="1" class="answer-option" <?php if($vo['answer'] == '1'): ?>checked="checked"<?php endif; ?> />
                    </label>
                    <label class="no<?php echo $vo['id']; ?>">
                        <span><?php echo $vo['no']; ?><i <?php if($vo['answer'] == '0'): ?>class="ion-ios-checkmark-outline"<?php else: ?>class="ion-ios-circle-outline"<?php endif; ?> data="0"></i></span>
                        <input type="radio" name="<?php echo $vo['id']; ?>[answer]" value="0" class="answer-option" <?php if($vo['answer'] == '0'): ?>checked="checked"<?php endif; ?> />
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
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- 隐藏提交cstcode，用于判断是否更新操作 -->
        <input type="hidden" name="cstcode" value="<?php echo $roomInfo['cstcode']; ?>" />
    </div>
    <div class="col-sm-12 center" style="line-height: 60px;">
        <label class="all-yes-btn" style="display: block; width: 600px; margin: 0 auto;">全部无问题<i class="ion-ios-circle-outline"></i></label>
    </div>
    <script type="text/javascript">
        // 全部无问题
        $('.all-yes-btn').click(function() {

            // 全无问题Btn
            // if ($('.all-yes-btn i').attr('class') == 'ion-ios-circle-outline') {
                $('.all-yes-btn i').attr('class', 'ion-ios-checkmark-outline');
            // } else {
                // $('.all-yes-btn i').attr('class', 'ion-ios-circle-outline');
            // }

            $('.idea').hide(); // 隐藏意见框

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
    </script>
    <div class="col-sm-12" style="text-align: center;">
        <button class="btn btn-primary" id="doPost">确定修改</button>
    </div>
    <script src="__MOBILE__/sweetalert/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="__MOBILE__/sweetalert/sweetalert.css">
    <script type="text/javascript">
        $('#doPost').click(function(){ // 点击提交
            $('#doPost').html('正在提交');
            $.post("<?php echo url('home/do_check/doAddLog'); ?>", $('#goToPost').serialize(), function(data){ // 异步post，方便加tips
                if (data) {
                    swal('恭喜，修改成功', '请等待复审结果', 'success');
                    $('#doPost').html('确定修改');
                    setTimeout(function() {
                        window.location.href = "<?php echo url('home/do_check/wait'); ?>";
                    }, 1000)
                } else {
                    sweetAlert('哎呀...', '出了一点小状况，过一会再试吧', 'error');
                    $('#doPost').html('确定修改');
                }
            }, 'json');
            return false; // 阻止事件穿透
        });
    </script>
</form>

								<div style="width: 100%;height: 76px;"></div>
							</div><!-- /.col -->

						</div>

					</div><!-- /.page-content -->
					<div style="width: 100%" id="tc"></div>
				</div><!-- /.main-content -->



				<!--<div class="ace-settings-container" id="ace-settings-container">-->

					<!--<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">-->

						<!--<i class="icon-cog bigger-150"></i>-->

					<!--</div>-->



					<!--<div class="ace-settings-box" id="ace-settings-box">-->

						<!--<div>-->

							<!--<div class="pull-left">-->

								<!--<select id="skin-colorpicker" class="hide">-->

									<!--<option data-skin="default" value="#438EB9">#438EB9</option>-->

									<!--<option data-skin="skin-1" value="#222A2D">#222A2D</option>-->

									<!--<option data-skin="skin-2" value="#C6487E">#C6487E</option>-->

									<!--<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>-->

								<!--</select>-->

							<!--</div>-->

							<!--<span>&nbsp; 选择皮肤</span>-->

						<!--</div>-->



						<!--<div>-->

							<!--<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />-->

							<!--<label class="lbl" for="ace-settings-navbar"> 固定导航条</label>-->

						<!--</div>-->



						<!--<div>-->

							<!--<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />-->

							<!--<label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>-->

						<!--</div>-->



						<!--<div>-->

							<!--<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />-->

							<!--<label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>-->

						<!--</div>-->



						<!--<div>-->

							<!--<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />-->

							<!--<label class="lbl" for="ace-settings-rtl">切换到左边</label>-->

						<!--</div>-->



						<!--<div>-->

							<!--<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />-->

							<!--<label class="lbl" for="ace-settings-add-container">-->

								<!--切换窄屏-->

								<!--<b></b>-->

							<!--</label>-->

						<!--</div>-->

					<!--</div>-->

				<!--</div>&lt;!&ndash; /#ace-settings-container &ndash;&gt;-->

			</div><!-- /.main-container-inner -->



			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

				<i class="icon-double-angle-up icon-only bigger-110"></i>

			</a>

		</div><!-- /.main-container -->



		<!-- basic scripts -->



		<!--[if !IE]> -->



		<!--<script src="http://www.jq22.com/jquery/jquery-2.1.1.js"></script>-->



		<!-- <![endif]-->



		<!--[if IE]>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<![endif]-->



		<!--[if !IE]> -->



		<script type="text/javascript">

			window.jQuery || document.write("<script src='__PC__/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");

		</script>



		<!-- <![endif]-->



		<!--[if IE]>

<script type="text/javascript">

 window.jQuery || document.write("<script src='__PC__/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");

</script>

<![endif]-->



		<script type="text/javascript">

			if("ontouchend" in document) document.write("<script src='__PC__/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");

		</script>

		<script src="__PC__/assets/js/bootstrap.min.js"></script>

		<script src="__PC__/assets/js/typeahead-bs2.min.js"></script>



		<!-- page specific plugin scripts -->



		<!--[if lte IE 8]>

		  <script src="__PC__/assets/js/excanvas.min.js"></script>

		<![endif]-->



		<script src="__PC__/assets/js/jquery-ui-1.10.3.custom.min.js"></script>

		<script src="__PC__/assets/js/jquery.ui.touch-punch.min.js"></script>

		<script src="__PC__/assets/js/jquery.slimscroll.min.js"></script>

		<script src="__PC__/assets/js/jquery.easy-pie-chart.min.js"></script>

		<script src="__PC__/assets/js/jquery.sparkline.min.js"></script>

		<!--<script src="__PC__/assets/js/flot/jquery.flot.min.js"></script>-->

		<!--<script src="__PC__/assets/js/flot/jquery.flot.pie.min.js"></script>-->
		<!--<script src="__PC__/assets/js/fuelux/data/fuelux.tree-sampledata.js"></script>-->
		<!--<script src="__PC__/assets/js/fuelux/fuelux.tree.min.js"></script>-->

		<!--<script src="__PC__/assets/js/flot/jquery.flot.resize.min.js"></script>-->
		<script src="__PC__/assets/easyui/jquery-easyui-1.4.5/jquery.easyui.min.js"></script>
        <script src="__PC__/assets/easyui/jquery-easyui-1.4.5/src/jquery.datebox.js"></script>
		<script src="__PC__/assets/easyui/jquery-easyui-1.4.5/easyui-lang-zh_CN.js"></script>
		<script src="__PC__/assets/js/myJs/my.js"></script>

		<!-- ace scripts -->



		<script src="__PC__/assets/js/ace-elements.min.js"></script>

		<script src="__PC__/assets/js/ace.min.js"></script>



		<!-- inline scripts related to this page -->



		<script type="text/javascript">

			jQuery(function($) {

				$('.easy-pie-chart.percentage').each(function(){

					var $box = $(this).closest('.infobox');

					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');

					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';

					var size = parseInt($(this).data('size')) || 50;

					$(this).easyPieChart({

						barColor: barColor,

						trackColor: trackColor,

						scaleColor: false,

						lineCap: 'butt',

						lineWidth: parseInt(size/10),

						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,

						size: size

					});

				})



				$('.sparkline').each(function(){

					var $box = $(this).closest('.infobox');

					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';

					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );

				});









			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});

			  var data = [

				{ label: "social networks",  data: 38.7, color: "#68BC31"},

				{ label: "search engines",  data: 24.5, color: "#2091CF"},

				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},

				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},

				{ label: "other",  data: 10, color: "#FEE074"}

			  ]
//
//			  function drawPieChart(placeholder, data, position) {
//
//			 	  $.plot(placeholder, data, {
//
//					series: {
//
//						pie: {
//
//							show: true,
//
//							tilt:0.8,
//
//							highlight: {
//
//								opacity: 0.25
//
//							},
//
//							stroke: {
//
//								color: '#fff',
//
//								width: 2
//
//							},
//
//							startAngle: 2
//
//						}
//
//					},
//
//					legend: {
//
//						show: true,
//
//						position: position || "ne",
//
//						labelBoxBorderColor: null,
//
//						margin:[-30,15]
//
//					}
//
//					,
//
//					grid: {
//
//						hoverable: true,
//
//						clickable: true
//
//					}
//
//				 })
//
//			 }
//
//			 drawPieChart(placeholder, data);



			 /**

			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically

			 so that's not needed actually.

			 */

//			 placeholder.data('chart', data);
//
//			 placeholder.data('draw', drawPieChart);







			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');

			  var previousPoint = null;
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {

					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
			 });
				var d1 = [];

				for (var i = 0; i < Math.PI * 2; i += 0.5) {

					d1.push([i, Math.sin(i)]);

				}



				var d2 = [];

				for (var i = 0; i < Math.PI * 2; i += 0.5) {

					d2.push([i, Math.cos(i)]);

				}



				var d3 = [];

				for (var i = 0; i < Math.PI * 2; i += 0.2) {

					d3.push([i, Math.tan(i)]);

				}





				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});

//				$.plot("#sales-charts", [
//
//					{ label: "Domains", data: d1 },
//
//					{ label: "Hosting", data: d2 },
//
//					{ label: "Services", data: d3 }
//
//				], {
//
//					hoverable: true,
//
//					shadowSize: 0,
//
//					series: {
//
//						lines: { show: true },
//
//						points: { show: true }
//
//					},
//
//					xaxis: {
//
//						tickLength: 0
//
//					},
//
//					yaxis: {
//
//						ticks: 10,
//
//						min: -2,
//
//						max: 2,
//
//						tickDecimals: 3
//
//					},
//
//					grid: {
//
//						backgroundColor: { colors: [ "#fff", "#fff" ] },
//
//						borderWidth: 1,
//
//						borderColor:'#555'
//
//					}
//
//				});





				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});

				function tooltip_placement(context, source) {

					var $source = $(source);

					var $parent = $source.closest('.tab-content');

					var off1 = $parent.offset();

					var w1 = $parent.width();



					var off2 = $source.offset();

					var w2 = $source.width();



					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';

					return 'left';

				}





				$('.dialogs,.comments').slimScroll({

					height: '300px'

			    });





				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task

				//so disable dragging when clicking on label

				var agent = navigator.userAgent.toLowerCase();

				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))

				  $('#tasks').on('touchstart', function(e){

					var li = $(e.target).closest('#tasks li');

					if(li.length == 0)return;

					var label = li.find('label.inline').get(0);

					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;

				   });



				$('#tasks').sortable({

						opacity:0.8,

						revert:true,

						forceHelperSize:true,

						placeholder: 'draggable-placeholder',

						forcePlaceholderSize:true,

						tolerance:'pointer',

//						stop : function( event, ui ) 
					});

				$('#tasks').disableSelection();

				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){

					if(this.checked) $(this).closest('li').addClass('selected');

					else $(this).closest('li').removeClass('selected');

				});
			})

		</script>

	<div style="display:none">
		<!--<script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'>-->

		</script></div>
</body>
</html>
