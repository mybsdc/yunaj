/**
 * Created by Administrator on 2017/6/27 0027.
 */
var hh=$("html").height();
var hs=parseInt(hh)*0.7;
$("#bmList .widget-body").css("min-height",hs+"px");
var num1=0;
$(function () {


    //关闭部门新增DIV
    $("body").on("click","#closeDiv",function() {
        $("#div2").css("display","none");
        $("#addBm").css("display","none");
    });
//新增部门到数据库
    $("body").on("submit","#addBm",function() {
        var l=$("#div2 input:checked").length;
        if(l==0){
            swal("提示！","请至少选中一项权限！","info");
        }else{
            $.ajax({
                type:"post",
                url:addDepartment,
                data:$(this).serialize(),
                success:function(data){
                    // alert(data);
                    if(data=="true"){
                       window.location.reload();
                    }else{
                        swal("注意！","添加失败，存在同样名称的部门","warning");
                    }
                }
            });
        }
        return false;
    });
//新增下级
    $("body").on("click","#bmType a[class='green']",function() {

        var id=$(this).parent("div").parent("li").attr("d_id");
        // alert(id);
        $("#div2").css("display","block");
        $("#div2 h4").text("部门新增");
        $("#addBm").css("display","block");
        $("#getTab").css("display","none");
        $("#div2 #addBm  button[type='submit']").css("display","inline");
        $("#div2 #addBm  input:eq(0)").val("");
        $("#div2 #addBm  input:checkbox").prop("checked",false);
        $("#div2 #addBm  #updateRole").css("display","none");
        $("#div2 #addBm  #updateDpt").css("display","none");
        $("#div2 #addBm  hr").css("display","none");
        $("#addBm input[type='hidden']").val(id);
    });

    //公司分级控制
    $(".col-xs-12").on("click","#bmType li i[down='true']",function() {
        // alert($(this).parent('li').length);
        if($(this).parent('li').attr("d_id")!=null && $(this).attr("class")=='icon-plus'&& $(this).parents('tr').attr("role")==null) {
            //alert();
            var sp=$(this);
            var li = $(this).parent('li');
            var id = li.attr("d_id");
            $(this).attr("class","icon-minus");
            var lis=$("li[pars="+id+"]");
            var lir=$("#bmType li[par="+id+"]");
            if(lir.length==0){
                if(lis.length==0){
                    // alert(lis.length);
                    $.ajax({
                        type: "post",
                        url: getRole,
                        data: {d_id: id},
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                var a = "";
                                $.each(data, function (index, val) {
                                    if (val['r_id'] == 2) {
                                        a = "检查";
                                    } else if (val['r_id'] == 3) {
                                        a = "审核";
                                    } else if (val['r_id'] == 4) {
                                        a = "基础数据管理";
                                    }
                                    if(sp.parent('li').attr("par")==null){
                                        $("<li  pars=" + id + " role=" + val['r_id'] + " style='border-top: 1px solid #c3c3c3;margin-top: 0;border-right: 0'> <span style='cursor: pointer;padding-right:50%;color: gray'> " + a + " </span>  <i class='icon-ok' off='1' style='float: right;background-color:#FFF;color: #FFF;margin-top:1%;margin-right:4%;border-radius: 2px' id='gou'></i> </li>}").appendTo(li.find('ul'));
                                    }else{
                                        $("<li  pars=" + id + " role=" + val['r_id'] + " style='border-top: 1px solid #c3c3c3;margin-top: 0;border-right: 0'> <span style='cursor: pointer;margin-left: 5px;padding-right:50%;color: gray'> " + a + " </span>  <i class='icon-ok' off='1' style='float: right;background-color:#FFF;color: #FFF;margin-top:1%;margin-right:4%;border-radius: 2px' id='gou'></i> </li>}").appendTo(li.find('ul'));
                                    }
                                });
                            }

                        }

                    });
                }else{
                    // alert(li.find('ul').html().length);
                    // if(li.find('ul').html().length==0){
                    //     $("#bmType li[pars="+id+"]").appendTo(li.find('ul'));
                    //     $("#bmType li[pars="+id+"]").css({display:"block"});
                    // }else{
                        li.find('ul li[pars='+id+']').show();
                    // }

                }
            }else{
                // alert(li.find('ul').html().length);
                if(li.find('ul').html()==""){
                    $("#bmType li[par="+id+"]").appendTo(li.find('ul')).show();
                    // $("#bmType li[par="+id+"][tp='1']").appendTo(li.find('ul')).show();
                    // $("#bmType li[par="+id+"][tp='2']").appendTo(li.find('ul')).show();
                    // $("#bmType li[par="+id+"][tp='3']").appendTo(li.find('ul')).show();
                }else{
                    li.find('ul>li[par='+id+']').show();
                }
            }
        }else{
            var tr=$(this).parent('li');
            var id=tr.attr("d_id");
            $(this).attr("class","icon-plus");
            tr.find("li").hide();
            // $("#bmType li[par="+id+"]").hide();
            for(var i=0;i< $("#bmType li[par="+id+"]").length;i++){
                // var d_id1=$("#bmType li[par="+id+"]").eq(i).attr("d_id");
                // $("#bmType li[pars="+d_id1+"]").css({display:"none"});
                $("#bmType li[par="+id+"]").eq(i).find("i[class='icon-minus']").attr("class","icon-plus");
            }

        }

    });
    // $("#bmType tr i[down='true']").trigger("click");

    //查看对应的用户
    $(".col-xs-12").on("click","#bmType li span",function() {
        $("#div2").css("display","block");
        $("#addBm").css("display","none");
        $("#getTab").css("display","block");
        $(this).css("color","blue");
        $("#bmType li span").not($(this)).css("color","gray");
        $(this).attr("check","true");
        $("#bmType li span").not($(this)).attr("check","false");
        var did=$(this).parent("li").attr("d_id");
        var tp=$(this).parent("li").attr("tp");
        var par=$(this).parent("li").attr("par");
        var pars=$(this).parent("li").attr("pars");
        var role=$(this).parent("li").attr("role");
        if(tp==0 || tp==1){
            $("#addOne").show();
        }else{
            $("#addOne").hide();
        }
        num=0;
        $.ajax({
            type:"post",
            url:getBmUser,
            data:{
                did:did,
                par:par,
                pars:pars,
                role:role,
                tp:tp
            },
            success:function (data) {
                $("#getTab").html(data);
            }
        });
    });

    //用户分页
    $("body").on("click","#userPages1>li",function(){
        var sn=$(".col-xs-12 #bmType li").find("span[check='true']");
        var did=sn.parent("li").attr("d_id");
        var par=sn.parent("li").attr("par");
        var pars=sn.parent("li").attr("pars");
        var role=sn.parent("li").attr("role");
        var tp=sn.parent("li").attr("tp");
        var liLen=$("#userPages1>li").length;
        var t=$(this).text();
        num=pageNum(t,liLen,num);
        $.ajax({
            type:"post",
            url:getBmUser,
            data:{
                start:num,
                did:did,
                par:par,
                pars:pars,
                role:role,
                tp:tp
            },
            success:function (data) {
                $("#getTab").html(data);
            }
        });
    });
    //触发用户列表模态框，并取得用户数据
    $(".col-xs-12").on("click","#div2 #addBmUser",function() {
        num=0;
        var id=$(this).parents("table").attr("bmId");
        $.ajax({
            type:"post",
            url:getUsers,
            data:{did:id},
            success:function(data){
                $("#div2 #getTab .modal-body").html(data);
            }
        });
    });
    //模态框表格分页
    $("body").on("click","#userPages>li",function(){
        var liLen=$("#userPages>li").length;
        var t=$(this).text();
        var mh=$("#userMh").text();
        num1=pageNum(t,liLen,num1);
        $.ajax({
            type:"post",
            url:userPages,
            data:{
                start:num1,
                mh:mh
            },
            success:function (data) {
                $("#div2 #getTab .modal-body").html(data);
            }
        });
    });

    //用户模糊查询
    $(".col-xs-12").on("click","#userHe #likeUsers",function() {
        num1=0;
        //alert($(this).text());
        var va=$("#userHe #nav-search-input").val();
            $.ajax({
                type:"post",
                url:userPages,
                data:{
                    mh:va
                },
                success:function (data) {
                    $("#div2 #getTab .modal-body").html(data);
                }
            });
    });

    $(".col-xs-12").on("keydown","#users1",function(){
        num1=0;
        var va=$(this).val();
        if(event.keyCode == 13){
                $.ajax({
                    type:"post",
                    url:userPages,
                    data:{
                        mh:va
                    },
                    success:function (data) {
                        $("#div2 #getTab .modal-body").html(data);
                    }
                });
            }
    });

    //选择用户关联到数据库
    $(".col-xs-12").on("click",'#div2 #getTab #getU',function(){
        var ruid=$("#sample-table-d1").attr("ruid");
        var tr=$("#div2 #getTab #sample-table-3").find("tr input:checked").parents("tr");
        if(tr.length==0){
            swal("提示！","请先选择用户!","info");
        }else{
            var arr=[];
            for(var i=0;i<tr.length-1;i++){
                arr[i]=tr.eq(i).attr("u_id");
            }
            $.ajax({
                type:"post",
                url:addRdu,
                data:{
                    ruid:ruid,
                    ids:arr
                },
                success:function(data){
                    if(data=="true"){
                        $(".col-xs-12 #bmType li").find("span[check='true']").trigger("click");
                        $('#myModals').css('display',"none");
                        $(".modal-backdrop").remove();//移除模态框残留样式，但是会造成滚动条消失
                        $("body").removeClass('modal-open');//恢复滚动条
                    }else{
                        swal("注意！","该用户已存在!","warning");
                    }
                }
            });
        }
    });

    //删除角色里面的用户
    $(".col-xs-12").on("click",'#div2 #getTab #sample-table-d1 .icon-trash',function(){
        var ruid=$("#sample-table-d1").attr("ruid");
        var uid=$(this).parents("tr").attr("u_ids");
        swal({
                title: "确定删除吗？",
                text: "删除后将无法恢复！",
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
                        url:deleteRdu,
                        data:{
                            ruid:ruid,
                            u_id:uid
                        },
                        success:function(data){
                            $(".col-xs-12 #bmType li").find("span[check='true']").trigger("click");
                            swal("删除成功！", "用户已删除！",
                                "success");
                        }
                    });
                } else {
                    swal("取消！", "操作已取消！",
                        "error");
                }
            });
    });

    //修改部门信息（名字和代码）
    $(".col-xs-12").on("click",'#bmType a[class="blue"]',function(){
        $("#div2 #addBm p").remove();
        var ids=$(this).parent("div").parent("li").attr("d_id");
        var txt=$(this).parent("div").parent("li").find("span").eq(0).text();
        txt=$.trim(txt);
        $("#div2").css("display","block");
        $("#div2 h4").text("信息修改");
        $("#addBm").css("display","block");
        $("#getTab").css("display","none");
        $("#div2 #addBm  button[type='submit']").css("display","none");
        $("#div2 #addBm  #updateDpt").css("display","inline");
        $("#div2 #addBm  #updateRole").css("display","inline");
        $("#div2 #addBm  hr").css("display","block");
        $("#addBm input[type='hidden']").val(ids);
        $("#addBm input[name='bmName']").val(txt);
        $.ajax({
            type:"post",
            url:getR,
            data:{id:ids},
            dataType:"json",
            success:function(data){
                if(data){
                    $("#div2 #addBm  input").prop("checked",false);
                    for(var i=0;i<data.length;i++){
                        $("#div2 #addBm  input[value="+data[i]['r_id']+"]").prop("checked",true);
                    }
                }
            }
        });
    });

    //修改信息到数据库
    $(".col-xs-12").on("click",'#div2 #addBm #updateDpt',function(){
        var name=$("#div2 #addBm  input:eq(0)").val();
        var id=$("#addBm input[type='hidden']").val();
        $.ajax({
            type:"post",
            url:updateDr,
            data:{
                name:name,
                id:id
            },
            success:function(data){
                if(data=="true"){
                   window.location.reload();
                }else{
                    swal("注意！","信息修改失败，因为信息没有发生改变！!","warning");
                }
            }
        });
    });

    //修改权限到数据库
    $(".col-xs-12").on("click",'#div2 #addBm #updateRole',function(){
        var id=$("#addBm input[type='hidden']").val();
        var role=$("#addBm input:checked");
        var re=[];
        var rid=[];
        for(var i=0;i<role.length;i++){
            re[i]=role.eq(i).val();
        }
        swal({
                title: "确定修改吗？",
                text: "修改权限会清除掉用户，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认修改！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(){
                    $.ajax({
                        type:"post",
                        url:updateRole,
                        data:{
                            id:id,
                            role:re
                        },
                        success:function(data){
                            //alert(data);
                            if(data=="true"){
                                window.location.reload();
                            }else if(data=="false1"){
                                window.location.reload();
                            } else{
                                swal("注意！","权限修改失败，因为权限没有发生变化！","warning");
                            }
                        }
                    });
            });

    });

    //删除部门
    $(".col-xs-12").on("click","#bmType a[class='red']",function() {
        var did=$(this).parent("li").attr("d_id");
        swal({
                title: "确定修改吗？",
                text: "是否删除该部门，删除后不可恢复！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认删除！",
                cancelButtonText: "取消！",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(){
                    $.ajax({
                        type:"post",
                        url:deleteBm,
                        data:{
                            did:did
                        },
                        success:function (data) {
                            // alert(data);
                            if(data=="true"){
                                swal({
                                     title: "删除成功！",
                                     text: "部门已删除！",
                                     type: "success"
                                     },function () {
                                    window.location.reload();
                                });

                            }else if(data=="false"){
                                swal("注意！", "存在业务数据，不能删除！", "warning");
                            }else{
                                swal("报错！", "程序出错，刷新重试。", "warning");
                            }
                        }
                    });
            });

    });

    //新增公司
    $(".col-xs-12").on("click","#addOne",function(){
        var did=$(".col-xs-12 #bmType li").find("span[check='true']").parent("li").attr("d_id");
        var tp=$(".col-xs-12 #bmType li").find("span[check='true']").parent("li").attr("tp");
        $("#addCom input[type='hidden']").val(did);
        if(Number(tp)!=0){
            $("#addCom input[value='2']").prop("checked",true);
            $("#addCom input[value='1']").prop("disabled",true);
        }else{
            $("#addCom input[value='2']").prop("checked",false);
            $("#addCom input[value='1']").prop("disabled",false);
        }

    });

    $("body").on("submit","#addCom",function(){
        $.ajax({
            type:"post",
            url:addCom,
            data:$(this).serialize(),
            success:function (data) {
                // alert(data);
                window.location.reload();
            }
        });
        return false;
    });

    //公司关联城市
    $(".col-xs-12").on("click",'#bmType a[class="orange"]',function(){
        var id=$(this).parent("div").parent("li").attr("d_id");
        $.ajax({
            type:'post',
            url:getCity,
            data:{
                id:id
            },success:function (data) {
                if(data=="false"){
                    $("#myModals2 input[type='hidden']").val(id);
                }else{
                    $("#myModals2 select").html("<option>"+data+"</option>");

                }
            }

        });

    });

    $(".col-xs-12").on("click",'#addCz',function(){
        var id=  $("#myModals2 input[type='hidden']").val();
         var cid=  $("#myModals2 select").val();
         if(cid=="" || cid==null){
            swal("注意","请先选择一个城市后再提交!","info");
         }else{
            $.ajax({
                type:"post",
                url:addCz,
                data:{
                    id:id,
                    cid:cid
                },success:function (data) {
                    if(data=="false"){
                        swal("注意!","该公司已经设置了城市，请勿重复设置！","info");
                    }else{
                        swal({
                            title: "添加成功！",
                            text: "数据已经发生改变.",
                            type: "success",
                            confirmButtonText: "确认"
                        }, function(){
                            window.location.reload();
                        })
                    }
                }
            });
         }
    });
});
