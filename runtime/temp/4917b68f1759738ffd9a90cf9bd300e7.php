<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:36:"app/home\view\audit_check\index.html";i:1498713975;s:30:"app/home\view\common\base.html";i:1498449249;}*/ ?>
﻿<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="utf-8" />

		<title>燃气入户安全检查管理系统</title>



		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

						<li class="active">
							<a href="#">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 首页 </span>
							</a>
						</li>

						
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
								
<!-- layer -->

<link rel="stylesheet" type="text/css" href="__PC__/layui/css/layui.css" />
<script type="text/javascript" src="__PC__/layui/lay/dest/layui.all.js"></script>
<!-- <script type="text/javascript" src="__PC__/layui/layui.js"></script> -->
<!-- <script type="text/javascript">
    layui.config({
        base: '__PC__/layui/lay/modules/' // 模块目录
    }).use('laypage'); // 加载入口
</script> -->
<!-- 引入图标库 -->
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/ionicons.min.css" />
<!-- end 引入图标库 -->
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
<!-- end layer -->
<!-- 编辑弹出窗 -->
<div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabels" style="font-size: 16px;">
                    编辑用户资料
                </h4>
            </div>
            <form class="form-horizontal" role="form" action="" method="post" autocomplete="off" id="udUser">
                <div class="modal-body" id="isForm">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-11"> 姓名：</label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-11" placeholder="请输入用户姓名" required name="cstname" class="col-xs-10 col-sm-5 getName">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-12">联系电话：</label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-12" placeholder="请输入用户电话" name="telphone" required class="col-xs-10 col-sm-5 getTel">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
					        <label style="margin-right: 4%;">
					            <span>气表类型：</span>
					            <select style="border: 1px solid #307ecc; border-radius: 6px;" name="type">
					                <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
					                <?php endforeach; endif; else: echo "" ;endif; ?>
					            </select>
					        </label>
					        <label style="margin-right: 4%;">
					            <span>品牌：</span>
					            <select style="border: 1px solid #307ecc; border-radius: 6px;" name="brand">
					                <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
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
					             if ($(this).val() == '') {
					                $(this).attr('selected', 'selected');
					                return false;
					             }
					         });
					        </script>
					    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="icon-ok bigger-110"></i> 确认修改
                        </button>
                        <buttonss class="btn btn-default" data-dismiss="modal">关闭</buttonss>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end 编辑弹出窗 -->
<div class="table-header" id="userHe">
	<label>
    	<select id="task">
    		<option value="y">全部</option>
    		<?php if(is_array($taskList) || $taskList instanceof \think\Collection || $taskList instanceof \think\Paginator): $i = 0; $__LIST__ = $taskList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
    		<?php endforeach; endif; else: echo "" ;endif; ?>
    	</select>
    	<span>未检查列表</span>
    </label>
</div>
<div class="row" style="background-color: #f0f3f8; padding: 16px 0; height: 55px;">
    <div class="col-sm-8">
	    <label>
	    	<span>城市</span>
	    	<select id="city">
	    	<option value="">请选择</option>
	    	<?php if(is_array($allCity) || $allCity instanceof \think\Collection || $allCity instanceof \think\Paginator): $i = 0; $__LIST__ = $allCity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	    		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
	    	<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    </label>
	    <label>
	    	<span>区域</span>
	    	<select id="area">
	    	<option value="">请选择</option>
	    	<?php if(is_array($allArea) || $allArea instanceof \think\Collection || $allArea instanceof \think\Paginator): $i = 0; $__LIST__ = $allArea;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	    		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
	    	<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    </label>
	    <label>
	    	<span>小区/街道</span>
	    	<select id="xq">
	    	<option value="">请选择</option>
	    	<?php if(is_array($allXq) || $allXq instanceof \think\Collection || $allXq instanceof \think\Paginator): $i = 0; $__LIST__ = $allXq;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	    		<option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
	    	<?php endforeach; endif; else: echo "" ;endif; ?>
	    	</select>
	    </label>
    </div>
    <script type="text/javascript" src="__MOBILE__/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">

    	// 选城市
    	$('#city').change(function(){
    		var city_id = $(this).val();
    		var html = '<option value="">请选择</option>';
    		$.post("<?php echo url('home/audit_check/index'); ?>", {city_id: city_id}, function(data){
    			var dataObj = JSON.parse(data); // string to obj
		    	$(dataObj.area).each(function(i){
				    html += '<option value="' + this.id + '">' + this.name + '</option>';
				});
				$('#area').html(html);

				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 7, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: false,
			        last: false,
			        prev: '《',
			        next: '》',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, city_id: city_id};
				        $.post("<?php echo url('home/audit_check/toPage'); ?>", postData, function(data){
			                let dataObj = eval(data); // json转对象
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr class="' + this.id + '">';
					                html += '<td class="center">' + this.id + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=' + this.cstcode + '"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别
			        }
			    });
		   }, 'json');
    	});

    	// 选区域
    	$('#area').change(function(){
    		var area_id = $(this).val();
    		var html = '<option value="">请选择</option>';
    		$.post("<?php echo url('home/audit_check/index'); ?>", {area_id: area_id}, function(data){
    			// let dataObj = eval(data); // json转对象
    			var dataObj = JSON.parse(data);
		    	$(dataObj.xq).each(function(i){
				    html += '<option value="' + this.id + '">' + this.name + '</option>';
				});
				$('#xq').html(html);

				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 7, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: false,
			        last: false,
			        prev: '《',
			        next: '》',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, area_id: area_id};
				        $.post("<?php echo url('home/audit_check/toPage'); ?>", postData, function(data){
			                let dataObj = eval(data); // json转对象
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr class="' + this.id + '">';
					                html += '<td class="center">' + this.id + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=' + this.cstcode + '"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别
			        }
			    });
		   }, 'json');
    	});

    	// 选小区
    	$('#xq').change(function(){
    		var xq_id = $(this).val();
    		var html = '';
    		$.post("<?php echo url('home/audit_check/index'); ?>", {xq_id: xq_id}, function(data){
    			// let dataObj = eval(data); // json转对象
    			var dataObj = JSON.parse(data);
				$('#pageNum').html(dataObj.pageNum); // 共几页
				$('#isCount').html(dataObj.count); // 共几条
			    layui.laypage({
			        cont: 'layer-pages',
			        groups: 7, // 显示页码数
			        skin: '#0f90e7',
			        pages: dataObj.pageNum, // 总页数
			        first: false,
			        last: false,
			        prev: '《',
			        next: '》',
			        jump: function(obj, first){

			            // 得到了当前页，用于向服务端请求对应数据
			            var curr = obj.curr;
			            $('#isCurrPage').html(curr);
		            	postData = {page: curr, xq_id: xq_id};
				        $.post("<?php echo url('home/audit_check/toPage'); ?>", postData, function(data){
			                let dataObj = eval(data); // json转对象
			                var html = '';
			                $(dataObj).each(function(i){
			                	html += '<tr class="' + this.id + '">';
					                html += '<td class="center">' + this.id + '</td>';
					                html += '<td>' + this.areaName + this.xqName + '</td>';
					                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
					                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
					                html += '<td style="text-align: center;">' + this.cstname + '</td>';
					                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
					                html += '<td class="hidden-480">' + this.typeName + '</td>';
					                html += '<td class="hidden-480">' + this.brandName + '</td>';
					                html += '<td class="hidden-480">' + this.direction + '</td>';
					                html += '<td class="hidden-480 center"><a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=' + this.cstcode + '"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a></td>';
					            html += '</tr>';
			                });
			                html += '<tr style="background-color: #f5f5f5;">';
			                html += '<td></td>';
			                html += '<td colspan="10">';
				            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
				            html += '</td>';
				            html += '</tr>';
			                $('#listData').html(html);
			            }, 'json'); // 必须指定json，否则前台无法识别

			        }
			    });
		   }, 'json');
    	});

    	// 选任务
    	$('#task').change(function(){
    		var task_id = $(this).val();
    		var html = '';
    		$.post("<?php echo url('home/audit_check/index'); ?>", {task_id: task_id}, function(data){
    			let dataObj = eval(data); // json转对象
		    	$(dataObj).each(function(i){
				    
				});
		   }, 'json');
    	});
    </script>
    <div class="col-sm-4">
	    <div class="nav-search" id="nav-search" style="top: -3px;">
	        <span class="input-icon">
	            <input type="text" id="toSearch" placeholder="按房号或卡号搜索" class="nav-search-input" autocomplete="off" value="" />
	            <i class="icon-search nav-search-icon" style="cursor: pointer" id="likeUser"></i>
	        </span>
	    </div>
    </div>
</div>
<script type="text/javascript">
    $('#toSearch').bind('input propertychange', function() { // 监听搜索框
        var num = $('#toSearch').val();
        var html = '';
        $.get("<?php echo url('home/audit_check/index'); ?>", {num: num}, function(data){
        	var dataObj = JSON.parse(data);
			$('#pageNum').html(dataObj.pageNum); // 共几页
			$('#isCount').html(dataObj.count); // 共几条
		    layui.laypage({
		        cont: 'layer-pages',
		        groups: 7, // 显示页码数
		        skin: '#0f90e7',
		        pages: dataObj.pageNum, // 总页数
		        first: false,
		        last: false,
		        prev: '《',
		        next: '》',
		        jump: function(obj, first){

		            // 得到了当前页，用于向服务端请求对应数据
		            var curr = obj.curr;
		            $('#isCurrPage').html(curr);
	            	postData = {page: curr, num: num};
			        $.post("<?php echo url('home/audit_check/toPage'); ?>", postData, function(data){
			        	console.log(curr);
		                let dataObj = eval(data); // json转对象
		                var html = '';
		                $(dataObj).each(function(i){
		                	html += '<tr class="' + this.id + '">';
				                html += '<td class="center">' + this.id + '</td>';
				                html += '<td>' + this.areaName + this.xqName + '</td>';
				                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
				                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
				                html += '<td style="text-align: center;">' + this.cstname + '</td>';
				                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
				                html += '<td class="hidden-480">' + this.typeName + '</td>';
				                html += '<td class="hidden-480">' + this.brandName + '</td>';
				                html += '<td class="hidden-480">' + this.direction + '</td>';
				                html += '<td class="hidden-480 center"><a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=' + this.cstcode + '"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a></td>';
				            html += '</tr>';
		                });
		                html += '<tr style="background-color: #f5f5f5;">';
		                html += '<td></td>';
		                html += '<td colspan="10">';
			            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
			            html += '</td>';
			            html += '</tr>';
		                $('#listData').html(html);
		            }, 'json'); // 必须指定json，否则前台无法识别

		        }
		    });
        }, 'json');               
    });
</script>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>序号</th>
                <th style="text-align: left;">地址</th>
                <th style="text-align: left;">房号</th>
                <th style="text-align: right;">用户编号</th>
                <th style="text-align: center;">姓名</th>
                <th style="text-align: right;">联系电话</th>
                <th style="text-align: left;">气表类型</th>
                <th style="text-align: left;">品牌</th>
                <th style="text-align: left;">进气方向</th>
                <th class="center">操作</th>
            </tr>
        </thead>
        <tbody style="text-align: left;" id="listData">
        <?php if(is_array($listData) || $listData instanceof \think\Collection || $listData instanceof \think\Paginator): $i = 0; $__LIST__ = $listData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="<?php echo $vo['id']; ?>">
                <td class="center">
                	<?php echo $vo['id']; ?>
                </td>
                <td><?php echo $vo['areaName']; ?><?php echo $vo['xqName']; ?></td>
                <td><?php echo $vo['dong']; ?><?php echo $vo['unit']; ?>单元<?php echo $vo['room']; ?></td>
                <td style="text-align: right;"><?php echo $vo['cstcode']; ?></td>
                <td style="text-align: center;" class="getName"><?php echo $vo['cstname']; ?></td>
                <td class="hidden-480 getTel" style="text-align: right;"><?php echo $vo['telphone']; ?></td>
                <td class="hidden-480">
                	<?php echo $vo['typeName']; ?>
                </td>
                <td class="hidden-480">
                	<?php echo $vo['brandName']; ?>
                </td>
                <td class="hidden-480">
                	<?php echo $vo['direction']; ?>
                </td>
                <td class="hidden-480 center">
	                <a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=<?php echo $vo['cstcode']; ?>"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
            <tr style="background-color: #f5f5f5;">
                <td></td>
                <td colspan="10">
                    <button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">
                        导出数据
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
		$(document).delegate('#toExcel', 'click', function(){ // 导出excel
			var num = $('#toSearch').val(); // 模糊搜索数据结果
			var toCityId = $('#city').val();
			var toAreaId = $('#area').val();
			var toXqId = $('#xq').val();
			/*$.get("<?php echo url('home/audit_check/toExcel'); ?>", {toCityId: toCityId, toAreaId: toAreaId, toXqId: toXqId}, function (data){
					console.log(data)
			}, 'json');*/
			window.location.href="<?php echo url('home/audit_check/toExcel'); ?>?toCityId=" + toCityId + "&toAreaId=" + toAreaId + "&toXqId=" + toXqId + "&num=" + num;
		});
	</script>
    <div class="row" style="background-color: #f0f3f8; line-height: 70px;">
        <div class="col-sm-4">
            <div class="dataTables_info" id="sample-table-2_info">
                第&nbsp;<span id="isCurrPage"></span>&nbsp;/&nbsp;<span id="pageNum"><?php echo $pageNum; ?></span>&nbsp;页，共&nbsp;<span id="isCount"><?php echo $count; ?></span>&nbsp;条
            </div>
        </div>
        <div class="col-sm-8">
            <div class="dataTables_paginate paging_bootstrap">
                <!-- layer 分页 -->
				<div id="layer-pages"></div>
				<script type="text/javascript">
					pageNum = <?php echo $pageNum; ?>; // 全局变量
				    layui.laypage({
				        cont: 'layer-pages',
				        groups: 7, // 显示页码数
				        skin: '#0f90e7',
				        pages: pageNum, // 总页数
				        first: false,
				        last: false,
				        prev: '《',
				        next: '》',
				        jump: function(obj, first){

				            // 得到了当前页，用于向服务端请求对应数据
				            var curr = obj.curr;
				            $('#isCurrPage').html(curr);
				            if(!first){
				            	postData = {page: curr};
						        $.post("<?php echo url('home/audit_check/toPage'); ?>", postData, function(data){
					                let dataObj = eval(data); // json转对象
					                var html = '';
					                $(dataObj).each(function(i){
					                	html += '<tr class="' + this.id + '">';
							                html += '<td class="center">' + this.id + '</td>';
							                html += '<td>' + this.areaName + this.xqName + '</td>';
							                html += '<td>' + this.dong + this.unit + '单元' + this.room + '</td>';
							                html += '<td style="text-align: right;">' + this.cstcode + '</td>';
							                html += '<td style="text-align: center;">' + this.cstname + '</td>';
							                html += '<td class="hidden-480" style="text-align: right;">' + this.telphone + '</td>';
							                html += '<td class="hidden-480">' + this.typeName + '</td>';
							                html += '<td class="hidden-480">' + this.brandName + '</td>';
							                html += '<td class="hidden-480">' + this.direction + '</td>';
							                html += '<td class="hidden-480 center"><a href="<?php echo url('home/audit_check/addLog'); ?>?cstcode=' + this.cstcode + '"><i class="ion-ios-plus-outline" style="color: #2f7bba; font-size: 18px; cursor: pointer"></i></a></td>';
							            html += '</tr>';
					                });
					                html += '<tr style="background-color: #f5f5f5;">';
					                html += '<td></td>';
					                html += '<td colspan="10">';
						            html += '<button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer" id="toExcel">导出数据</button>';
						            html += '</td>';
						            html += '</tr>';
					                $('#listData').html(html);
					            }, 'json'); // 必须指定json，否则前台无法识别
						    }
				        }
				    });
				</script>
				<!-- end layer 分页 -->
            </div>
        </div>
    </div>
</div>


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
