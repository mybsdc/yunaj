/**
 * Created by Administrator on 2017/4/24 0024.
 */
// test
/*if(navigator.userAgent.indexOf("Chrome")>-1){
     var winOpen=window.open(url,"_blank",winStyle);
     var timer=window.setInterval(function(){
           if(winOpen.closed==true){
                  if(winOpen.returnValue!=null){
                         //业务代码，winOpen.returnValue就是从子页面获取的返回值
                  }
           }
     });
}else{
     if(window.showModalDialog){
          return window.showModalDialog(url, parameter, winStyle);
     }
}*/



// end test




var ajaxbg = $("#background,#progressBar,#hids1");
var h=window.location.host;
var num=0;

//分页公用方法
function pageNum(txt,len,num) {
    // alert(txt);
    // alert(len);
    // alert(num);
    var pageCount=$("#pageCount").text();
    if(txt=="上一页"){
        if(num>0){
            num=num-1;
        }else{
            num=0;
        }
    }else if(txt=="下一页"){
        if(num==Number(pageCount)-1){
            num=Number(pageCount)-1;
        }else{
            num=num+1;
        }
    }else if(txt=="首页"){
        num=0;
    }else if(txt=="尾页"){
        num=Number(pageCount)-1;
    }else{
        num=txt-1;
    }
    return num;
}
$(function(){
    var d=new Date();
//月初
    var f = d.setDate(1);
    f = new Date(f);
    f=f.toLocaleDateString();
    f=f.replace(/\//g,'-');
//月末
    var e=d.setDate(1);
    e=new Date(e);
    e=e.setMonth(d.getMonth()+1)-24*60*60*1000;
    e=new Date(e);
    e=e.toLocaleDateString();
    e=e.replace(/\//g,"-");
    //格式化日期函数
    $.fn.datebox.defaults.formatter = function(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return y+'-'+ m +'-'+ d;
    };
//
    $.fn.datebox.defaults.parser = function(s) {
        if (s) {
            var a = s.split('-');
            var d = new Date(parseInt(a[0]), parseInt(a[1]) - 1, parseInt(a[2]));
            return d;
        } else {
            return new Date();
        }

    };
    // 一级游标移动设置
    $("#sidebar").on("click","#re-list>li:not(:first)",function(){
        // alert($(this).text());
        if($.trim($(this).text())=='系统设置'){
            window.location.href="http://"+h+getUser+"?tname='用户管理'";
        }else if($.trim($(this).text())=='数据初始化'){
            window.location.href="http://"+h+ct+"?tname='城市概况'";
        }else if($.trim($(this).text())=='检查执行'){
            window.location.href="http://"+h+jczx+"?tname='待检查'";
        }else if($.trim($(this).text())=='检查审核'){
            window.location.href="http://"+h+shgl+"?tname='待检查'";
        }else if($.trim($(this).text())=='检查台账'){
            window.location.href="http://"+h+tz+"?tname='全部数据'";
        }
    });
    var fd=$("#re-list .active").attr("f_id");
    // alert(fd);
    if(fd!="" && fd !=null){
        $.ajax({
            type:"post",
            url:tNav,
            data:{
                fid:fd
            },
            success:function (re) {
                $("#tc").html(re);
                var t=$("#tname").text();
                console.log(t);
               $(".wizard-steps span:contains("+t+")").css("background-color","rgb(111, 179, 224)").css("color","#FFF");
            }
        });
    }
    //验证2次密码是否一致
    $(".col-xs-12").on("blur","#form-field-3",function(){
        $(".form-group #sp1").text("");
        //alert()
        if($(this).val()!= $("#form-field-2").val()){
            $(".form-group #sp1").text("两次密码不一致，请重新输入");
            $(this).val("");
        }
    });
    //验证电话号码
    $(".col-xs-12").on("blur","input[name='phone']",function(){
        $(".form-group #sp2").text("");
        $(".form-group #sp3").text("");
        //alert()
        if($(this).val().length!= 11){
            $(".form-group #sp2").text("请输入正确的电话号码");
            $(".form-group #sp3").text("请输入正确的电话号码");
            $(this).val("");
        }
    });
    //二级菜单，跳转
    $("body").on("click",".wizard-steps>li span",function(){
        var val=$(this).text();
        $(this).css("background-color","rgb(111, 179, 224)");
        $(this).css("color","#FFF");
        $(".wizard-steps>li span").not($(this)).css("background","");
        $(".wizard-steps>li span").not($(this)).css("color","#546474");

       if(val=='用户管理'){
            window.location.href="http://"+h+getUser+"?tname="+val;
       }else if(val=='组织架构设置'){
            window.location.href="http://"+h+set+"?tname="+val;
       }else if(val=='城市概况'){
           window.location.href="http://"+h+ct+"?tname="+val;
       }else if(val=='业务参数'){
           window.location.href="http://"+h+su+"?tname="+val;
       }else if(val=='燃气用户库'){
           window.location.href="http://"+h+iitz+"?tname="+val;
       }else if(val=='权限管理模块'){
           window.location.href="http://"+h+showR+"?tname="+val;
       } else if (val == '待检查') {
            if (fd == 1) {
                window.location.href="http://"+h+c1+"?tname="+val;
            } else {
                window.location.href="http://"+h+s1+"?tname="+val;
            }
       } else if (val == '待审核') {
            if (fd == 1) {
                window.location.href="http://"+h+c2+"?tname="+val;
            } else {
                window.location.href="http://"+h+s2+"?tname="+val;
            }
       } else if (val == '未通过审核') {
            if (fd == 1) {
                window.location.href="http://"+h+c3+"?tname="+val;
            } else {
                window.location.href="http://"+h+s3+"?tname="+val;
            }
       } else if (val == '已通过审核') {
            if (fd == 1) {
                window.location.href="http://"+h+c4+"?tname="+val;
            } else {
                window.location.href="http://"+h+s4+"?tname="+val;
            }
       }
    });

    //用户分页
    $("body").on("click","#userPageU1>li",function(){
        var liLen=$("#userPageU1>li").length;
        var t=$(this).text();
        var mh=$("#userMh").text();
        num=pageNum(t,liLen,num);
        $.ajax({
            type:"post",
            url:userPage,
            data:{
                start:num,
                mh:mh
            },
            success:function (data) {
                $("#userPage").html(data);
            }
        });
    });

    //新增用户到数据库
    $(".col-xs-12").on("submit","#sample-table-1 #addUser",function(){
        $.ajax({
            type:"post",
            url:addUser,
            data:$(this).serialize(),
            success:function(data){
                if(data=="true"){
                    window.location.reload();
                }else{
                    swal("注意！","添加失败，用户代码或电话已存在!","warning");
                }
            }
        });
        return false;
    });

    //用户表的启用禁用功能
    $(".col-xs-12").on("click","#sample-table-1 .btn-xs",function(){
        var tr=$(this).parents("tr");
        var uid=tr.attr("r_id");
        var bt=$(this);
        var b="";
        var ch="";
        var i="";
        if($(this).text()=="启用"){
            b=0;
            ch="是否禁用该用户？";
        }else {
            ch="是否启用该用户？";
            b=1;
        }
        swal({
                title: "提示！",
                text: ch,
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type:'post',
                        url:userSwitch,
                        data:{
                            id:uid,
                            enable:b
                        },
                        success:function(data){
                            if(data=="true"){
                                if(b==0){
                                    bt.attr("class","btn btn-xs");
                                    bt.text("未启用");
                                }else {
                                    bt.attr("class","btn btn-xs btn-success");
                                    bt.text("启用");
                                }
                                swal("提示","操作成功！","success");
                            }else{
                                swal("注意","操作失败，请重试！","error");
                            }
                        }
                    });
                } else {
                    swal("取消！", "操作已取消！",
                        "error");
                }
            });
    });

    //用户资料修改
    $(".col-xs-12").on("click","#sample-table-1 .icon-edit:not(:last)",function() {//触发模态框后把原始值填入表单
        var tr=$(this).parents("tr");
        //alert($(this).parents("tr").attr("r_id"));
        $("#form-field-11").val(tr.find("td").eq(1).text());
        $("#form-field-12").val(tr.find("td").eq(2).text());
        $("#form-field-13").val(tr.find("td").eq(3).text());
        $("#udUser input[type='hidden']").val(tr.attr('r_id'));
    });
    $(".col-xs-12").on("submit","#udUser",function(){
        //var r_id=$(this).find("input[type='hidden']").val();
        $.ajax({
            type:"post",
            url:updateUser,
            data:$(this).serialize(),
            success:function(data){
                // alert(data);
                if(data=="true"){
                    $("#updateUser").modal('hide');
                    $.ajax({
                        type:"post",
                        url:userPage,
                        success:function (data) {
                            $("#userPage").html(data);
                        }
                    });
                    swal({
                        title: "修改成功！",
                        text: "资料已成功修改！",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                }else if(data=="false1"){
                    // swal({
                    //     title: "注意！",
                    //     text: "当前账号资料已修改，请重新登录！",
                    //     type: "info"
                    // },function () {
                    //     window.location.reload();
                    // });
                    swal("注意！","代码或电话已存在!","error");
                } else{
                    swal("注意！","信息未发生改变!","error");
                }
            }
        });
        return false;
    });

    //用户模糊查询
    $(".col-xs-12").on("click","#likeUser",function() {
        //alert($(this).text());
        num=0;
        var va=$(this).prev("input").val();
        $.ajax({
            type:"post",
            url:userPage,
            data:{
                mh:va
            },
            success:function (data) {
                $("#userPage").html(data);
            }
        });
    });

    $(".col-xs-12").on("keydown","#users",function(){
        num=0;
        var va=$(this).val();
        if(event.keyCode == 13){
                $.ajax({
                    type:"post",
                    url:userPage,
                    data:{
                        mh:va
                    },
                    success:function (data) {
                        $("#userPage").html(data);
                    }
                });
            }
    });

    //数据导出EXCEL
    $(".col-xs-12").on("click","#sample-table-1 #checkUser",function() {
        //alert($(this).text());
        $.ajax({
            type:"post",
            url:checkExcel,
            beforeSend: function() {
                ajaxbg.show();
                // $("#hids1").show();
            },
            success:function(data){
                if(data=="false"){
                    swal("注意","数据为空，不能导出！","warning");
                }else{
                    window.location.href=checkExcel;
                }
            },
            complete: function() {
                ajaxbg.hide();
                // $("#hids1").hide();
            }
        });
    });

    //角色模块权限显示
    $(".col-xs-12").on("click","#role button",function(){
        $("#fun input").prop("checked",false);
        $(this).css({color:'#FFF',backgroundColor:"rgb(111, 179, 224)"});
        $("#role button").not($(this)).css({color:'black',backgroundColor:"#dddddd"});

        var id=$(this).attr("rid");
        $.ajax({
            type:"post",
            url:updateRl,
            data:{
                id:id
            },
            dataType:'json',
            success:function (data) {
                for(var i=0;i<data.length;i++){
                    $("#fun input[fid="+data[i]['func_id']+"]").prop("checked",true);
                }
                $("#fun button").show();
                $("#fun button").attr("rid",id);
            }


        });
    });
    $("#role button:first").trigger("click");
    //修改角色模块权限
    $(".col-xs-12").on("click","#fun button",function(){
        var id=$(this).attr("rid");
        var ins=$("#fun input:checked");
        var fids=[];
        for(var i=0;i<ins.length;i++){
            fids[i]=ins.eq(i).attr("fid");
        }
        $.ajax({
            type:"post",
            url:updateRls,
            data:{
                id:id,
                fids:fids
            },
            success:function (data) {
             if(data=="true"){
                 swal({
                     title: "修改成功！",
                     text: "功能权限已经成功修改！",
                     type: "success"
                 },function () {
                     window.location.reload();
                 });
             }else{
                 swal("修改失败！", "请刷新后重试！",
                     "error");
             }
            }
        });
    });
//账号密码修改
    $("#updatePwd").on("click",function(){
        var name=$("#users span").text();
        $("#udPwd  #form-field-p1").val(name);
    });
    $("#udPwd #form-field-p4").on("blur",function(){
        $("#udPwd .form-group #sp4").text("");
        if($(this).val()!= $("#form-field-p3").val()){
            $(".form-group #sp4").text("两次密码不一致，请重新输入");
            $(this).val("");
        }
    });
    $("#udPwd #form-field-p3").on("blur",function(){
        $("#udPwd .form-group #sp4").text("");
        if($(this).val()!= $("#form-field-p4").val()){
            $(".form-group #sp4").text("两次密码不一致，请重新输入");
            $("#form-field-p4").val("");
        }
    });

    $("#udPwd").on("submit",function () {
        $.ajax({
            type:"post",
            url:udPwd,
            data:$(this).serialize(),
            success:function (data) {
                // alert(data);
                if(data=="true"){
                    swal({
                        title: "修改成功！",
                        text: "当前账号资料已修改，请重新登录！",
                        type: "info"
                    },function () {
                        window.location.reload();
                    });
                }else if(data=="false1"){
                    swal("注意！","原密码错误!","error");
                }else{
                    swal("注意！","新密码不能和原密码一样!","warning");
                }
            }
        });
        return false;
    });
    //删除session
    $("#sesOut").on("click",function(){
        $.ajax({
            type:"post",
            url:deleteSession,
            success:function(){
                window.location.reload();
            }
        });
    });

});