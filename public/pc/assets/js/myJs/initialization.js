/**
 * Created by Administrator on 2017/7/4 0004.
 */
$(function () {

    //导入Excel
    $("body").on("change","form #file",function() {
        var formdata = new FormData($('#upload')[0]);
        $.ajax({
            url: checkIn,
            type: "post",
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function () {
                ajaxbg.show();
            },
            success: function (data) {
                if(data=="false"){
                    swal({
                        title: "上传出错",
                        text: "文件上传不成功。请重试!",
                        type: "error",
                        confirmButtonText: "确认"
                    });
                }else{
                    var arr=JSON.parse(data);
                    var t="";
                    if(arr['errorpath']!=""){
                        t=",存在异常数据，点击确认后自动下载。"
                    }else{
                        t="。";
                    }
                    swal({
                        title: "导入信息",
                        text: "成功导入"+arr['room']+"条数据"+t,
                        type: "info",
                        confirmButtonText: "确认"
                    }, function(){
                            if(t==="。"){
                                window.location.reload();
                            }else{
                                window.open("http://"+h+arr['errorpath']);
                                window.location.reload();
                            };
                     }
                    );
                }
            },
            complete: function() {
                ajaxbg.hide();
            }
        });
    });

    //三级联动
    $("body").on("change","#city",function () {
        num =0;
        var t=$("#xq").val();
        var q=$("#qy").val();
        var c=$("#city").val();
        if(c!="全部"){
            $("#qy option[pid="+c+"]").show();
            $("#qy option[pid!="+c+"]:not([value='全部'])").hide();
            $("#qy option[value='全部']").prop("selected",true);
            $("#xq option[value='全部']").prop("selected",true);
            $("#xq option[value!='全部']").hide();
        }else{
            $("#qy option[value='全部']").show();
            $("#qy option[value!='全部']").hide();
            $("#xq option[value='全部']").show();
            $("#xq option[value!='全部']").hide();
            $("#qy option[value='全部']").prop("selected",true);
            $("#xq option[value='全部']").prop("selected",true);
        }
        $.ajax({
            type:"post",
            url:getPage,
            data:{
                ct:c,
                qy:q,
                xq:t
            },success:function (data) {
                $("#ipage").html(data);
            }
        });
    });

    $("body").on("change","#qy",function () {
        num =0;
        var t=$("#xq").val();
        var q=$("#qy").val();
        var c=$("#city").val();
        if(q!="全部"){
            $("#xq option[xid="+q+"]").show();
            $("#xq option[xid!="+q+"]:not([value='全部'])").hide();
            $("#xq option[value='全部']").prop("selected",true);
        }else{
            $("#xq option[value='全部']").show();
            $("#xq option[value!='全部']").hide();
            $("#xq option[value='全部']").prop("selected",true);
        }
        $.ajax({
            type:"post",
            url:getPage,
            data:{
                ct:c,
                qy:q,
                xq:t
            },success:function (data) {
                $("#ipage").html(data);
            }
        });
    });

    $("body").on("change","#xq",function () {
        num =0;
        var t=$("#xq").val();
        var q=$("#qy").val();
        var c=$("#city").val();
        $.ajax({
            type:"post",
            url:getPage,
            data:{
                ct:c,
                qy:q,
                xq:t
            },success:function (data) {
                $("#ipage").html(data);
            }
        });

    });

    //模糊查询
    $(".col-xs-12").on("click","#likeRoom",function() {
        //alert($(this).text());
        var va=$("#room").val();
        num =0;
        var t=$("#xq").val();
        var q=$("#qy").val();
        var c=$("#city").val();
        $.ajax({
            type:"post",
            url:getPage,
            data:{
                ct:c,
                qy:q,
                xq:t,
                va:va
            },success:function (data) {
                $("#ipage").html(data);
            }
        });
    });

    $(".col-xs-12").on("keydown","#room",function(){
        var va=$(this).val();
        if(event.keyCode == 13){
            num =0;
            var t=$("#xq").val();
            var q=$("#qy").val();
            var c=$("#city").val();
            $.ajax({
                type:"post",
                url:getPage,
                data:{
                    ct:c,
                    qy:q,
                    xq:t,
                    va:va
                },success:function (data) {
                    $("#ipage").html(data);
                }
            });
        };
    });

    //分页
    $("body").on("click","#userPageS1>li",function(){
        var liLen=$("#userPageS1>li").length;
        var tx=$(this).text();
        var va=$("#room").val();
        var t=$("#xq").val();
        var q=$("#qy").val();
        var c=$("#city").val();
        num=pageNum(tx,liLen,num);
        $.ajax({
            type:"post",
            url:getPage,
            data:{
                start:num,
                ct:c,
                qy:q,
                xq:t,
                va:va
            },success:function (data) {
                $("#ipage").html(data);
            }
        });
    });

    //修改信息
    $("body").on("click","#sample-table-i1 a",function(){
        var id=$(this).parents("tr").attr("iiid");
        var tr=$(this).parents("tr");
        var qx=tr.find("td").eq(1).text();
        var ld=tr.find("td").eq(2).text();
        qx=$.trim(qx);
        ld=$.trim(ld);
        var arr=qx.split("-");
        var arr1=ld.split("-");
        // alert(qx);
        $("#myModalI1 input[name='qy']").val(arr[0]);
        $("#myModalI1 input[name='xq']").val(arr[1]);
        $("#myModalI1 input[name='ld']").val(arr1[0]);
        $("#myModalI1 input[name='dy']").val(arr1[1]);
        $("#myModalI1 input[name='fh']").val(arr1[2]);
        $("#myModalI1 input[name='bh']").val($.trim(tr.find("td").eq(3).text()));
        $("#myModalI1 input[name='mz']").val($.trim(tr.find("td").eq(5).text()));
        $("#myModalI1 input[name='dh']").val($.trim(tr.find("td").eq(6).text()));
        $("#myModalI1 input[name='lx']").val($.trim(tr.find("td").eq(7).text()));
        $("#myModalI1 input[name='pp']").val($.trim(tr.find("td").eq(8).text()));
        $("#myModalI1 input[name='bds']").val($.trim(tr.find("td").eq(4).text()));
        $("#myModalI1 input[type='hidden']").val(id);
        var se="";
        if($.trim(tr.find("td").eq(9).text())=="无"){
            se="";
        }else{
            se=$.trim(tr.find("td").eq(9).text());
        }
        $("#myModalI1 select[name='fx']").find("option[value="+se+"]").prop("selected",true);
    });
    //删除数据icon-trash
    $("body").on("click","#sample-table-i1 .icon-trash",function(){
        var id=$(this).parents("tr").attr("iiid");
        swal({
                title: "确定删除吗？",
                text: "你将无法恢复该条记录！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定删除！",
                cancelButtonText: "取消删除！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type:"post",
                        data:{
                            id:id
                        },
                        url:deleteSj,
                        success:function (data) {
                            if(data=="true"){
                                swal({
                                    title: "删除成功！",
                                    text: "记录已删除！",
                                    type: "success"
                                },function () {
                                    window.location.reload();
                                });
                            }else{
                                swal("删除失败！", "存在业务数据关联，不能删除！", "error");
                            }
                        }
                    });

                } else {
                    swal("取消！", "操作已取消！",
                        "error");
                }
            });

    });

    //提交修改信息到数据库
    $("body").on("submit","#updateIu",function(){
        $.ajax({
            type:"post",
            url:updateIu,
            data:$(this).serialize(),
            success:function (data) {
               if(data=="true"){
                   swal({
                       title: "修改成功！",
                       text: "数据已经发生改变",
                       type: "success",
                       confirmButtonText: "确认"
                   }, function(){
                           window.location.reload();
                   }
               );
               }else if(data=="false4"){
                   swal("修改失败！","用户编号已存在！","error");
               }else{
                   swal("修改失败！","数据没有发生变化！","error");
               }
            }
        });
        return false;
    });

});