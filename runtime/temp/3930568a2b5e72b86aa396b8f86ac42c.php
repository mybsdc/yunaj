<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:32:"app/mobile\view\login\index.html";i:1499091567;s:32:"app/mobile\view\common\base.html";i:1497450644;}*/ ?>
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
    <title>登录 - 云安检</title>
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
    
    <!-- end 当前页单独样式 -->
    
</head>

<body>
    <!-- 遮罩 -->
    <div class="mask"></div>
    <!-- end 遮罩 -->
    <div id="big-box">
    <!-- 主体内容 -->
    
<div class="base">
    <div id="div-error" >
        <div id="div-error-title" >&nbsp;消息</div>
        <div style="height:90px;width:100%">
            <div id="div-error-info">-</div>
        </div>
        <div id="div-error-btn" onclick="hiderror();">
            确&nbsp;定
        </div>
    </div>
    <div class="wrapperlog" style="overflow-y: hidden;">
        <div  id="dlk" class="container">
            <h1 id="Welcome">Welcome</h1>
            <form class="form">
                <input type="url" placeholder="手机或用户代码" class="saler-login-box-user-input">
                <input type="password" placeholder="密码" class="saler-login-box-password-input">
                <button type="button" id="login-button" class="js-saler-login-box-btn">登&nbsp;录</button>
            </form>
        </div>
        <div class="authent">
            <img src='__MOBILE__/images/puff.svg' style="">
        </div>
        <script type="text/javascript">

        // 登录
        $(".js-saler-login-box-btn").click(function() {
            var name = $('.saler-login-box-user-input').val();
            var password = $('.saler-login-box-password-input').val();
            if (name === ''){
                //信息框
                layer.open({
                    content: '请输入手机或用户代码！',
                    btn: '我知道了'
                });
                return false;
            }

            // 加载动画
            $(".form").hide();
            $("#dlk").removeClass("container");
            $("#dlk").addClass("container1");
            $(".authent").show();

            // 异步验证
            $.post("<?php echo url('mobile/login/doLogin'); ?>", {username: name, pwd: password}, function(data){
                console.log(data);
                if (data) { // 登录成功
                    /*layer.open({
                        content: '登录成功！',
                        time: 2
                    });*/
                    setTimeout(function() {
                        window.location.href = "<?php echo url('mobile/index/index'); ?>";
                    }, 1000)
                } else {
                    layer.open({
                        content: '用户名或密码错误！',
                        btn: '我知道了'
                    });

                    // 隐藏动画
                    $(".authent").hide();
                    $("#dlk").addClass("container");
                    $("#dlk").removeClass("container1");
                    $(".form").show();
                }
            });
            /*
            var $url = saler_url.login;
            var $data = {
                name: $name,
                pwd: $password,
            };
            $(".form").hide();
            $("#dlk").removeClass("container");
            $("#dlk").addClass("container1");
            $(".authent").show();
            ajax_post_callback($url, $data, function(data) {
                if (data.status == 0) {
                                    //showerror(data['info']);
                    layer_alert(data['info']);
                    $(".authent").hide();
                    $("#dlk").addClass("container");
                    $("#dlk").removeClass("container1");
                    $(".form").show();
                } else {
                    //layer_alert("登录成功！");
                    //setTimeout(function() {
                        //location.href = saler_url.index;
                                            location.href = data['info'];           
                    //}, 300);
                }
            });
            */
        });
        </script>
        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

    </div>
    <!--<div class="bqsy-sm">版权所有 成都链商科技有限公司</div>-->
</div>
<style>
    .layui-m-layercont {
        padding: 50px 30px;
        line-height: 22px;
        text-align: center;
        color: #000;
    }
    .authent{
        position:absolute;
        top:55%;
        left:45%;
        width:100%;
        display:none;
    }
    #div-error{
        position:absolute;
        top:35%;left:8%;
        height:170px;
        width:84%;
        background:rgba(248, 248, 248, 0.95);
        border-radius:10px;
        border:2px solid rgba(255,0,0,0.3);
        z-index:99999;
        -webkit-box-shadow: 0 0 10px rgba(5, 74, 83, 0.98);
        -moz-box-shadow: 0 0 10px rgba(5, 74, 83, 0.95);
        box-shadow: 0 0 10px rgba(5, 74, 83, 0.95);
        display:none;
    }
    #div-error-info
    {
        text-align: center;
        color: #050505;
        line-height: 95px;
        font-weight: 500;
        font-size:105%
    }

    #div-error-title
    {
        height:30px;width:100%;
        background:rgba(255,0,0,0.3);
        border-radius: 10px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        text-align:left;
        line-height:30px;
        font-size:105%
    }
    #div-error-btn{
        height: 44px;
        width: 100%;
        text-align: center;
        line-height: 44px;
        border-top: 1px solid rgba(255,0,0,0.3);
        color: #222;
        font-weight: 700;
        font-size:110%
    }
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-weight: 300;
    }
    body {
        font-family: 'Source Sans Pro', sans-serif;
        color: white;
        font-weight: 300;
    }
    body ::-webkit-input-placeholder {
        /* WebKit browsers */
        font-family: 'Source Sans Pro', sans-serif;
        color: white;
        font-weight: 300;
    }
    body :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        font-family: 'Source Sans Pro', sans-serif;
        color: white;
        opacity: 1;
        font-weight: 300;
    }
    body ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        font-family: 'Source Sans Pro', sans-serif;
        color: white;
        opacity: 1;
        font-weight: 300;
    }
    body :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        font-family: 'Source Sans Pro', sans-serif;
        color: white;
        font-weight: 300;
    }
    .wrapperlog {
        background: #009688;
        background: -webkit-linear-gradient(top left, #009688 10%, #03a9f4 110%);
        background: linear-gradient(to bottom right, #009688 10%, #03a9f4 110%);
        opacity: 0.8;
        position: absolute;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .container1 {
        max-width: 600px;
        margin: 0 auto;
        padding: 32% 0;
        height: 400px;
        text-align: center;
    }

    .container1 h1 {
        -webkit-transform: translateY(100px);
        -ms-transform: translateY(100px);
        transform: translateY(100px);
        font-size: 45px;
        -webkit-transition-duration: 0.6s;
        transition-duration: 0.6s;
        -webkit-transition-timing-function: ease-in-put;
        transition-timing-function: ease-in-put;
        font-weight: 200;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 32% 0;
        height: 400px;
        text-align: center;
    }
    .container h1 {
        font-size: 35px;
        -webkit-transition-duration: 0.6s;
        transition-duration: 0.6s;
        -webkit-transition-timing-function: ease-in-put;
        transition-timing-function: ease-in-put;
        font-weight: 200;
    }
    form {
        padding: 20px 0;
        position: relative;
        z-index: 2;
    }
    form input {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: 0;
        border: 1px solid rgba(255, 255, 255, 0.4);
        background-color: rgba(255, 255, 255, 0.2);
        width: 250px;
        border-radius: 3px;
        padding: 10px 15px;
        margin: 0 auto 10px auto;
        display: block;
        text-align: center;
        font-size: 18px;
        color: white;
        -webkit-transition-duration: 0.25s;
        transition-duration: 0.25s;
        font-weight: 300;
    }
    form input:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }
    form input:focus {
        background-color: white;
        width: 300px;
        /*color: #53e3a6;*/
        color:red;
    }
    form button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: 0;
        background-color: white;
        border: 0;
        padding: 10px 15px;
        color: #03A9F4;
        border-radius: 3px;
        width: 250px;
        cursor: pointer;
        font-size: 18px;
        -webkit-transition-duration: 0.25s;
        transition-duration: 0.25s;
    }
    form button:hover {
        background-color: #f5f7f9;
    }
    .bg-bubbles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    .bg-bubbles li {
        position: absolute;
        list-style: none;
        display: block;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.15);
        bottom: -160px;
        -webkit-animation: square 10s infinite;
        animation: square 10s infinite;
        -webkit-transition-timing-function: linear;
        transition-timing-function: linear;
    }
    .bg-bubbles li:nth-child(1) {
        left: 10%;
    }
    .bg-bubbles li:nth-child(2) {
        left: 20%;
        width: 80px;
        height: 80px;
        -webkit-animation-delay: 2s;
        animation-delay: 2s;
        -webkit-animation-duration: 17s;
        animation-duration: 17s;
    }
    .bg-bubbles li:nth-child(3) {
        left: 25%;
        -webkit-animation-delay: 4s;
        animation-delay: 4s;
    }
    .bg-bubbles li:nth-child(4) {
        left: 40%;
        width: 60px;
        height: 60px;
        -webkit-animation-duration: 22s;
        animation-duration: 22s;
        background-color: rgba(255, 255, 255, 0.25);
    }
    .bg-bubbles li:nth-child(5) {
        left: 70%;
    }
    .bg-bubbles li:nth-child(6) {
        left: 80%;
        width: 120px;
        height: 120px;
        -webkit-animation-delay: 3s;
        animation-delay: 3s;
        background-color: rgba(255, 255, 255, 0.2);
    }
    .bg-bubbles li:nth-child(7) {
        left: 32%;
        width: 160px;
        height: 160px;
        -webkit-animation-delay: 7s;
        animation-delay: 7s;
    }
    .bg-bubbles li:nth-child(8) {
        left: 55%;
        width: 20px;
        height: 20px;
        -webkit-animation-delay: 15s;
        animation-delay: 15s;
        -webkit-animation-duration: 40s;
        animation-duration: 40s;
    }
    .bg-bubbles li:nth-child(9) {
        left: 25%;
        width: 10px;
        height: 10px;
        -webkit-animation-delay: 2s;
        animation-delay: 2s;
        -webkit-animation-duration: 40s;
        animation-duration: 40s;
        background-color: rgba(255, 255, 255, 0.3);
    }
    .bg-bubbles li:nth-child(10) {
        left: 90%;
        width: 160px;
        height: 160px;
        -webkit-animation-delay: 11s;
        animation-delay: 11s;
    }
    @-webkit-keyframes square {
        0% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }
        100% {
            -webkit-transform: translateY(-700px) rotate(600deg);
            transform: translateY(-700px) rotate(600deg);
        }
    }
    @keyframes square {
        0% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }
        100% {
            -webkit-transform: translateY(-700px) rotate(600deg);
            transform: translateY(-700px) rotate(600deg);
        }
    }
</style>
<script> 
    $(window).resize(function() { 
        setTimeout(function(){
            var $zgd=$(window).height();
            var $zb=$("#login-button").offset();

            if ($zb.top>$zgd-20)
            {
                $('.wrapperlog').scrollTop($zgd/2 - 50);
            }  
            else
            {
                $('.wrapperlog').scrollTop(0);
            }
        },20);
   });
</script>

    <!-- end 主体内容 -->
    <!-- 底部 -->
    
    </div>
    <!-- 当前页单独js -->
    
    <!-- end 当前页单独js -->
</body>

</html>
