$("#ct1 .widget-body").css("min-height",hs+"px");
$("#ct2 .widget-body").css("min-height",hs+"px");
$(function () {
    //公司分级控制
    $(".col-xs-12").on("click","#ctType tr i[down='true']",function() {
        if($(this).parents('tr').attr("d_id")!=null && $(this).attr("class")=='icon-plus'&& $(this).parents('tr').attr("role")==null) {
            //alert();
            var sp=$(this);
            var tr = $(this).parents('tr');
            var id = tr.attr("d_id");
            $(this).attr("class","icon-minus");
            var trs=$("tr[pars="+id+"]");
            var dtr=$("#ctType tr[par="+id+"]");
                $("#ctType tr[par="+id+"]").insertAfter(tr);
                $("#ctType tr[par="+id+"]").css({display:"table-row"});
        }else{
            var tr=$(this).parents('tr');
            var id=tr.attr("d_id");
            $(this).attr("class","icon-plus");
            $("#ctType tr[pars="+id+"]").css({display:"none"});
            $("#ctType tr[par="+id+"]").css({display:"none"});
            for(var i=0;i< $("#ctType tr[par="+id+"]").length;i++){
                var d_id1=$("#ctType tr[par="+id+"]").eq(i).attr("d_id");
                $("#ctType tr[pars="+d_id1+"]").css({display:"none"});
                $("#ctType tr[par="+id+"]").eq(i).find("i[class='icon-minus']").attr("class","icon-plus");
            }

        }

    });
    //查看对应的街道
    $(".col-xs-12").on("click","#ctType tr span",function() {
        num=0;
        $("#div2").css("display","block");
        $("#addBm").css("display","none");
        $("#getTab").css("display","block");
        $(this).css("color","blue");
        $("#ctType tr span").not($(this)).css("color","gray");
        $(this).attr("check","true");
        $("#ctType tr span").not($(this)).attr("check","false");
        var did=$(this).parents("tr").attr("d_id");
        var par=$(this).parents("tr").attr("par");
        if(par==null){
            par="";
        }
        $("#ct2").attr("did",did);
        $("#ct2").attr("par",par);
        if(par!=null && par!=""){
            $("#jd").show();
            $("#jd").attr("did",did);
        }else{
            $("#jd").hide();
            $("#jd").attr("did","");
        }
        $.ajax({
            type:"post",
            url:street,
            data:{
                did:did,
                par:par
            },
            success:function (data) {
                $("#ct2 .widget-main").html(data);
            }
        });
    });

    //分页
    $("body").on("click","#userPageC1>li",function(){
        var did=$("#ct2").attr("did");
        var par=$("#ct2").attr("par");
        var liLen=$("#userPageC1>li").length;
        var t=$(this).text();
        num=pageNum(t,liLen,num);
        $.ajax({
            type:"post",
            url:street,
            data:{
                start:num,
                did:did,
                par:par
            },
            success:function (data) {
                $("#ct2 .widget-main").html(data);
            }
        });
    });

    //新增街道/小区
    $("body").on("click","#addT",function(){
        var name=$("#addStreet input[name='sname']").val();
        var did=$("#ct2").attr("did");
        if(name=="" || name==null){
            // $.messager.alert({
            //     title:"注意",
            //     icon:"info",
            //     msg:"<span style='line-height: 40px'>请先填写内容后再提交！</span>"
            // });
            swal("注意！","请先填写内容后再提交！","error");
        }else{
            $.ajax({
                type:"post",
                url:addStreet,
                data:{
                    name:name,
                    did:did
                },
                success:function (data) {
                    if(data=="true"){
                        $("#ctType span[check='true']").trigger("click");
                        $(".modal-backdrop").remove();//移除模态框残留样式，但是会造成滚动条消失
                        $("body").removeClass('modal-open');//恢复滚动条
                    }else{
                        // $.messager.alert({
                        //     title:"注意",
                        //     icon:"warning",
                        //     msg:"<span style='line-height: 40px'>添加失败，街道/小区已存在!</span>"
                        // });
                        swal("注意！","添加失败，街道/小区已存在！","error");
                    }
                }
            });
        }

    });

    //删除小区街道
    $("body").on("click","#sample-table-c1 a",function(){
        var id=$(this).parents("tr").attr("pid");
        swal({
                title: "确定删除吗？",
                text: "删除后你将无法恢复！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认删除！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type:"post",
                        url:"deleteStreet",
                        data:{
                            id:id
                        },
                        success:function () {
                            $("#ctType span[check='true']").trigger("click");
                            swal("删除成功！", "记录已删除！",
                                "success");
                        }
                    });
                } else {
                    swal("取消！", "操作已取消！",
                        "error");
                }
            });
    });

    //修改名称
    $(".col-xs-12").on("click",'#ctType a[class="blue"]',function(){
        $("#upC").show();
        $("#addQ").hide();
        $("#addStreet1 h4").text('修改名称');
        var tr=$(this).parents("tr");
        $("#addStreet1 input[type='hidden']").val(tr.attr("d_id"));
        $("#addStreet1 input[name='cname']").val($.trim(tr.find("span").text()));
    });

    $("body").on("click","#upC",function(){
        var id=$("#addStreet1 input[type='hidden']").val();
        var name=$("#addStreet1 input[name='cname']").val();
        if(name=="" || name==null){
            // $.messager.alert({
            //     title:"注意",
            //     icon:"info",
            //     msg:"<span style='line-height: 40px'>请先填写内容后再提交！</span>"
            // });
            swal("提示！","请先填写内容后再提交！","info");
        }else{
            $.ajax({
                type:"post",
                url:upName,
                data:{
                    id:id,
                    name:name
                },
                success:function (data) {
                    if(data=="true"){
                        window.location.reload();
                    }else{
                        // $.messager.alert({
                        //     title:"注意",
                        //     icon:"info",
                        //     msg:"<span style='line-height: 40px'>该名字已存在！</span>"
                        // });
                        swal("出错！","该名字已存在！","error");
                    }
                }
            });
        }
    });

    //新增区域
    $(".col-xs-12").on("click",'#ctType a[class="green"]',function(){
        $("#upC").hide();
        $("#addQ").show();
        $("#addStreet1 h4").text('新增区域');
        var tr=$(this).parents("tr");
        $("#addStreet1 input[type='hidden']").val(tr.attr("d_id"));
        $("#addStreet1 input[name='cname']").val('');
    });

    $("body").on("click","#addQ",function(){
        var id=$("#addStreet1 input[type='hidden']").val();
        var name=$("#addStreet1 input[name='cname']").val();
        if(name=="" || name==null){
            // $.messager.alert({
            //     title:"注意",
            //     icon:"info",
            //     msg:"<span style='line-height: 40px'>请先填写内容后再提交！</span>"
            // });
            swal("提示！","请先填写内容后再提交！","info");
        }else{
            $.ajax({
                type:"post",
                url:addQ,
                data:{
                    name:name,
                    pid:id
                },
                success:function (data) {
                    if(data=="true"){
                       window.location.reload();
                    }else{
                        // $.messager.alert({
                        //     title:"注意",
                        //     icon:"warning",
                        //     msg:"<span style='line-height: 40px'>添加失败，区域已存在!</span>"
                        // });
                        swal("注意！","添加失败，区域已存在!","error");
                    }
                }
            });
        }

    });

    //新增城市
    $(".col-xs-12").on("click",'#addCt',function(){
        $("#upC").hide();
        $("#addQ").show();
        $("#addStreet1 h4").text('新增城市');
        var tr=$(this).parents("tr");
        $("#addStreet1 input[type='hidden']").val("");
        $("#addStreet1 input[name='cname']").val('');
    });

    //删除城市和区域
    //删除部门
    $(".col-xs-12").on("click","#ctType a[class='red']",function() {
        var did=$(this).parents("tr").attr("d_id");
        swal({
                title: "确定删除吗？",
                text: "删除后你将无法恢复该条记录！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认删除！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type:"post",
                        url:deleteCq,
                        data:{
                            did:did
                        },
                        success:function (data) {
                            // alert(data);
                            if(data=="true"){
                                swal({
                                    title: "删除成功！",
                                    text: "记录已删除！",
                                    type: "success"
                                },function () {
                                    window.location.reload();
                                    window.location.reload();
                                });
                            }else if(data=="false"){
                                swal("注意！","存在业务数据，不能删除。","error");
                            }else{
                                swal("报错！","程序出错，刷新重试。","error");
                            }
                        }
                    });
                } else {
                    swal("取消！", "操作已取消！",
                        "error");
                }
            });
    });
});