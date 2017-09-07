<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"app/home\view\login\index.html";i:1500350985;}*/ ?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="__PC__/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="__PC__/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>

		  <link rel="stylesheet" href="__PC__/assets/css/font-awesome-ie7.min.css" />

		<![endif]-->
    <!-- page specific plugin styles -->
    <!-- fonts -->
    <!-- ace styles -->
    <link rel="stylesheet" href="__PC__/assets/css/ace.min.css" />
    <link rel="stylesheet" href="__PC__/assets/css/ace-rtl.min.css" />
    <!--[if lte IE 8]>

		  <link rel="stylesheet" href="__PC__/assets/css/ace-ie.min.css" />

		<![endif]-->
    <!-- inline styles related to this page -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>

		<script src="__PC__/assets/js/html5shiv.js"></script>

		<script src="__PC__/assets/js/respond.min.js"></script>

		<![endif]-->
</head>

<body class="login-layout">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>

									<i class="icon-leaf green"></i>

									<span class="blue">云</span>

									<span class="white">安检</span>

								</h1>
                            <h4 class="blue">@链商科技有限公司</h4>
                        </div>
                        <div class="space-6"></div>
                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">

												<i class="icon-coffee green"></i>

												请输入用户信息

											</h4>
                                        <div class="space-6"></div>
                                        <form id="formData">
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">

															<input type="text" class="form-control" placeholder="用户代码或手机号码" id="is-username" name="username" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" />

															<i class="icon-user"></i>

														</span>
                                                </label>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">

															<input type="password" class="form-control" placeholder="密码" id="pwd" name="pwd" />

															<i class="icon-lock"></i>

														</span>
                                                </label>
                                                <div class="space"></div>
                                                <div class="clearfix">
                                                    <label class="inline">
                                                        <input type="checkbox" class="ace" name="rememberMe" value="1" />
                                                        <span class="lbl"> 记住我</span>
                                                    </label>
                                                    <button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="toLogin">
                                                        <i class="icon-key"></i> <span id="login-text">登录</span>
                                                    </button>
                                                </div>
                                                <div class="space-4"></div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <script type="text/javascript" src="__MOBILE__/js/jquery-1.8.3.min.js"></script>
                                    <!-- 弹出框 -->
									<script src="__MOBILE__/sweetalert/sweetalert.min.js"></script>
									<link rel="stylesheet" type="text/css" href="__MOBILE__/sweetalert/sweetalert.css">
									<!-- end 弹出框 -->
                                    <script type="text/javascript">

							        // 登录
							        $('#toLogin').click(function() {
							            var name = $('#is-username').val();
							            var password = $('#pwd').val();

							            if (name === ''){
							                swal({ 
											    title: '请输入用户代码或手机号码',
											    text: '必须填写完整用户信息才能登录哦',
											    timer: 2000, 
											    showConfirmButton: false 
											});
							                return false;
							            }
							            if (password === ''){
							                swal({ 
											    title: '您还没有输入密码',
											    text: '必须填写完整用户信息才能登录哦',
											    timer: 2000, 
											    showConfirmButton: false 
											});
							                return false;
							            }
							            $('#login-text').text('正在登录');

							            // 异步验证
							            $.post("<?php echo url('home/login/doLogin'); ?>", $('#formData').serialize(), function(data){
							                if (data['code'] === 1) { // 登录成功
							                	swal({
												    title: '亲爱的' + data['name'] + '，登录成功', 
												    showConfirmButton: false,
												    text: '欢迎回来，正在跳转后台首页',
												    type: 'success',
												    timer: 2000
												});
							                    setTimeout(function() {
							                        window.location.href = "<?php echo url('home/index/index'); ?>";
							                    }, 1000)
							                } else if (data['code'] === -1) {
							                	swal({
												    title: '密码错误', 
												    showConfirmButton: true,
												    text: '请检查您输入的密码是否正确',
												    type: 'error',
												    confirmButtonText: '我知道了'
												});
												$('#login-text').text('登录');
							                } else if (data['code'] === 0) {
							                	swal({
												    title: '用户名或手机号码不存在', 
												    showConfirmButton: true,
												    text: '请输入正确的用户代码或手机号码再登录',
												    type: 'error',
												    confirmButtonText: '我知道了'
												});
												$('#login-text').text('登录');
							                } else if (data['code'] === 2) {
                                                swal({
                                                    title: '该账户尚未启用', 
                                                    showConfirmButton: true,
                                                    text: '请联系基础数据管理员启用您的账户',
                                                    type: 'error',
                                                    confirmButtonText: '我知道了'
                                                });
                                                $('#login-text').text('登录');
                                            } else if (data['code'] === 3) {
                                                swal({
                                                    title: '该账户尚未分配角色', 
                                                    showConfirmButton: true,
                                                    text: '请联系基础数据管理员为您的账户分配角色',
                                                    type: 'error',
                                                    confirmButtonText: '我知道了'
                                                });
                                                $('#login-text').text('登录');
                                            }
							            });
							        });

                                    // 监听回车事件
                                    $('#is-username').keydown(function(e){
                                        if(e.keyCode === 13){
                                            $('#pwd').focus();
                                        }
                                    });
                                    $('#pwd').keydown(function(e){
                                        if(e.keyCode === 13){
                                            $('#toLogin').focus();
                                        }
                                    });
							        </script>
                                    <!-- /widget-main -->
                                </div>
                                <!-- /widget-body -->
                            </div>
                            <!-- /login-box -->
                            <!-- /signup-box -->
                        </div>
                        <!-- /position-relative -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.main-container -->
    <!-- basic scripts -->
    <!--[if !IE]> -->
    <!-- <![endif]-->
    <!--[if IE]>

<![endif]-->
    <!--[if !IE]> -->
    <script type="text/javascript">
    window.jQuery || document.write("<script src='__PC__/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
    </script>
    <!-- <![endif]-->
    <!--[if IE]>

<script type="text/javascript">

 window.jQuery || document.write("<script src='__PC__/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");

</script>

<![endif]-->
    <script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src='__PC__/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    function show_box(id) {

        jQuery('.widget-box.visible').removeClass('visible');

        jQuery('#' + id).addClass('visible');

    }
    </script>
</body>

</html>
