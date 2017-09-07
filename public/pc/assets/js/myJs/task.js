/**
 * Created by Administrator on 2017/7/6 0006.
 */
$(function () {
    $("#start").datebox({
        onSelect: function(date){
            var start= $("#start").next("span").find("input[type='hidden']").val();
            var end= $("#end").next("span").find("input[type='hidden']").val();
            if(start!="" && end!=""){
                var sta=$.myTime.DateToUnix(start);
                var en=$.myTime.DateToUnix(end);
                if(sta>en){
                    swal({
                        title: "注意！",
                        text: "开始日期不能大于截止日期",
                        type: "warning",
                        confirmButtonText: "确认"
                    }, function(){
                        $("#end").next("span").find("input[type='hidden']").val("");
                        $("#end").next("span").find("input[type='text']").val("");
                    });
                }else {
                    num=0;
                    var mh=$("#task").val();
                    $.ajax({
                        type:"post",
                        url:taskPage,
                        data:{
                            mh:mh,
                            ks:sta,
                            js:en
                        },
                        success:function (data) {
                            $("#task_page").html(data);
                        }
                    });
                }
            }
        }
    });
    $("#end").datebox({
        onSelect: function(){
            var start= $("#start").next("span").find("input[type='hidden']").val();
            var end= $("#end").next("span").find("input[type='hidden']").val();
            // alert(end);
            if(start!="" && end!=""){
                var sta=$.myTime.DateToUnix(start);
                var en=$.myTime.DateToUnix(end);
                if(sta>en){
                    swal({
                        title: "注意！",
                        text: "截止日期不能小于开始日期",
                        type: "warning",
                        confirmButtonText: "确认"
                    }, function(){
                        $("#end").next("span").find("input[type='hidden']").val("");
                        $("#end").next("span").find("input[type='text']").val("");
                    });
                }else {
                    num=0;
                    var mh=$("#task").val();
                    $.ajax({
                        type:"post",
                        url:taskPage,
                        data:{
                            mh:mh,
                            ks:sta,
                            js:en
                        },
                        success:function (data) {
                            $("#task_page").html(data);
                        }
                    });
                }
            }
        }
    });
    $("#ks").datebox({
        required:true
    });
    $("#js").datebox({
        required:true
    });
    
    //城市联动
    $("body").on("change","#tct",function (event,a) {
        var id=$(this).val();
        if(id==""){
            $("#tqy").html("");
            $("#ldList").html("");
            $("#tqy").append("<option value=''></option>");
            $("#txq").html("");
            $("#txq").append("<option value=''></option>");
        }else{
            $.ajax({
                type:"post",
                url:getQy,
                data:{
                    id:id
                },success:function (data) {
                    // alert(data);
                    $("#tqy").html("");
                    var arr=JSON.parse(data);
                    for(var i=0;i<arr.length;i++){
                        if(i==0){
                            $("#tqy").append("<option value=''></option>");
                                if(a==arr[i]['id']){
                                    $("#tqy").append("<option value='"+arr[i]['id']+"' selected='selected'>"+arr[i]['name']+"</option>");
                                }else{
                                    $("#tqy").append("<option value='"+arr[i]['id']+"'>"+arr[i]['name']+"</option>");
                                }
                        }else{
                                if(a==arr[i]['id']){
                                    $("#tqy").append("<option value='"+arr[i]['id']+"' selected='selected'>"+arr[i]['name']+"</option>");
                                }else{
                                    $("#tqy").append("<option value='"+arr[i]['id']+"'>"+arr[i]['name']+"</option>");
                                }
                        }

                    }
                }
            })
        }
    });

    //区域联动
    $("body").on("change","#tqy",function (event,a,b) {
        var id='';
        if(a=="" || a==null){
             id=$(this).val();
        }else{
            id=b;
        }
        // alert(id);
        if(id==""){
            $("#txq").html("");
            $("#ldList").html("");
            $("#txq").append("<option value=''></option>");
        }else{
            $.ajax({
                type:"post",
                url:getXq,
                data:{
                    id:id
                },success:function (data) {
                    $("#txq").html("");
                    var arr=JSON.parse(data);
                    for(var i=0;i<arr.length;i++){
                        if(i==0){
                            $("#txq").append("<option value=''></option>");
                            if(a==arr[i]['id']){
                                $("#txq").append("<option value='"+arr[i]['id']+"' selected='selected'>"+arr[i]['name']+"</option>");
                            }else{
                                $("#txq").append("<option value='"+arr[i]['id']+"'>"+arr[i]['name']+"</option>");
                            }
                            $("#ldList").html("");
                        }else{
                            if(a==arr[i]['id']){
                                $("#txq").append("<option value='"+arr[i]['id']+"' selected='selected'>"+arr[i]['name']+"</option>");
                            }else{
                                $("#txq").append("<option value='"+arr[i]['id']+"'>"+arr[i]['name']+"</option>");
                            }
                            $("#ldList").html("");
                        }

                    }
                }
            })
        }
    });

    //小区
    // $("body").on("change","#txq",function (event,a) {
    //     var id=$(this).val();
    //     if(id==""){
    //        $("#checkLd").hide();
    //     }else{
    //         $("#checkLd").show();
    //     }
    // });

    //显示楼栋列表
    $("body").on("change","#txq",function (event,a,b) {
        // alert();
        // alert(b);
        var id='';
        if(a=="" || a==null){
            id=$(this).val();
        }else{
            id=a;
        }

        if(id=="" || id==null){
            $("#ldList").html("");
        }else{
            $.ajax({
                type:"post",
                url:getLd,
                data:{
                    id:id
                },success:function (data) {
                    // alert(data);
                    $("#ldList").html("");
                    var arr=JSON.parse(data);
                    // alert(console.log(arr));
                    if(arr.length==0){
                        $("#ldList").html("<p>当前小区或者街道还没有楼栋选项...</p>");
                    }
                    for(var i=0;i<arr.length;i++){
                        if(b!="" && b!=null && b.length>0){
                            for(var k=0;k<b.length;k++){
                                if(b[k]==arr[i]['id']){
                                    // alert(1);
                                    $("#ldList").append("<label style='float: left;margin-left: 10px'><input type='checkbox' checked='checked' class='ace' value='"+arr[i]['id']+"'> <span class='lbl'>&nbsp;&nbsp;"+arr[i]['name']+"</span></label>");
                                    break;
                                }else{
                                    // alert(2);
                                    if(k==(b.length-1)){
                                        // alert(3);
                                        $("#ldList").append("<label style='float: left;margin-left: 10px'><input type='checkbox'  class='ace' value='"+arr[i]['id']+"'> <span class='lbl'>&nbsp;&nbsp;"+arr[i]['name']+"</span></label>");
                                    }
                                }
                            }
                        }else{
                            // alert(4);
                            $("#ldList").append("<label style='float: left;margin-left: 10px'><input type='checkbox'  class='ace' value='"+arr[i]['id']+"'> <span class='lbl'>&nbsp;&nbsp;"+arr[i]['name']+"</span></label>");
                        }
                    }
                }
            })
        }
    });

    //全选
    $("body").on("click","#qx",function () {
        $("#ldList input").prop("checked",true);
    });
    //全不选
    $("body").on("click","#qbx",function () {
        $("#ldList input").prop("checked",false);
    });


    $("body").on("click","#xj",function () {
        $("#myTask1 input").prop("checked",false);
        var a=$("#addTa").attr("on");
        if(a==null || a==""){
            $("#addTa").attr("on","1");
        }else{
            if(a==0){
                $("#addTa").attr("on","1");
                $("#myTask1 input").prop("checked",false);
            }
        }

    });

    $("body").on("click","#xs",function () {
        $("#myTask1 input").prop("checked",false);
        var a=$("#addTa").attr("on");
        if(a==null || a=="" ){
            $("#addTa").attr("on","0");
        }else{
            if(a==1){
                $("#addTa").attr("on","0");
                $("#myTask1 input").prop("checked",false);
            }
        }

    });

    //用户模糊查询
    $(".col-xs-12").on("click","#userHe #likeUsers1",function() {
        //alert($(this).text());
        var va=$("#users1").val();
            $.ajax({
                type:"post",
                url:tkUser,
                data:{
                    va:va
                },
                success:function (data) {
                    $("#myTask1 .table-responsive").html(data);
                }
            });
    });
    $(".col-xs-12").on("keydown","#users1",function(){
        var va=$(this).val();
        if(event.keyCode == 13){
            $.ajax({
                type:"post",
                url:tkUser,
                data:{
                    va:va
                },
                success:function (data) {
                    $("#myTask1 .table-responsive").html(data);
                }
            });
        };
    });
//确认选择检查人和审核人
    $("body").on("click","#addTa",function () {
        var pd=$(this).attr('on');
        var cd=$("#myTask1 input:checked");

        if(cd.length==0){
            swal("注意！","请至少选择一项！","error");
        }else {
            var tr="";
            var xjarr=new Array();
            var xjarr1=new Array();
            for(var i=0;i<cd.length;i++){
                tr=cd.eq(i).parents("tr");
                xjarr.push(tr.attr("r_id"));
                xjarr1.push(tr.find("td").eq(1).text());
            }
            xjarr=$.unique(xjarr);
            xjarr1=$.unique(xjarr1);
            // alert(JSON.stringify(xjarr));
            // alert(JSON.stringify(xjarr1));
            if(pd==1){
                // $("#jcr").html("");
                var sp=$("#jcr").find("a");
                for(var k=0;k<xjarr.length;k++){
                   if(sp.length>0){
                       var a=0;
                        for(var i=0;i<sp.length;i++){
                            if(sp.eq(i).text()==xjarr1[k]){
                               break;
                            }else{
                                a++;
                                if(a==sp.length){
                                    $("#jcr").append("<a href='#' uid='"+xjarr[k]+"'>"+xjarr1[k]+"</a>&nbsp;")
                                }
                            }
                        }
                   }else{
                       $("#jcr").append("<a href='#'  uid='"+xjarr[k]+"'>"+xjarr1[k]+"</a>&nbsp;")
                   }
                }
                $('#myTask1').modal('hide');
            }else{
                // $("#shr").html("");
                var sp=$("#shr").find("a");
                for(var k=0;k<xjarr.length;k++){
                    if(sp.length>0){
                        var a=0;
                        for(var i=0;i<sp.length;i++){
                            if(sp.eq(i).text()==xjarr1[k]){
                                break;
                            }else{
                                a++;
                                if(a==sp.length){
                                    $("#shr").append("<a href='#' uid='"+xjarr[k]+"' style='padding-right: 5px'>"+xjarr1[k]+"</a>")
                                }
                            }
                        }
                    }else{
                        $("#shr").append("<a href='#' uid='"+xjarr[k]+"' style='padding-right: 5px'>"+xjarr1[k]+"</a>&nbsp;")
                    }
                }
                $('#myTask1').modal('hide');
            }
        }
    });

    //删除人员
    $("body").on("click","#jcr a",function (){
        $(this).remove();
    });
    $("body").on("click","#shr a",function (){
        $(this).remove();
    });

    //保存数据到后台addTask
    $("body").on("submit","#addTask",function (){
        var name=$("#addTask input[name='tname']").val();
        var start= $("#ks").next("span").find("input[type='text']").val();
        var end= $("#js").next("span").find("input[type='text']").val();
        var ct=$("#tct").val();
        var qy=$("#tqy").val();
        var xq=$("#txq").val();
        var taid=$("#taskid").val();
        var ck=$("#ldList input:checked");
        var jc=$("#jcr a");
        var sh=$("#shr a");
        var lid=new Array();
        var jid=new Array();
        var sid=new Array();
        for(var i=0;i<ck.length;i++){
            lid.push(ck.eq(i).val());
        }
        for(var i=0;i<jc.length;i++){
            jid.push(jc.eq(i).attr("uid"));
        }
        for(var i=0;i<sh.length;i++){
            sid.push(sh.eq(i).attr("uid"));
        }
        if(start!="" && end!=""){
            var sta=$.myTime.DateToUnix(start);
            var en=$.myTime.DateToUnix(end);
            if(sta>en){
                swal({
                    title: "注意！",
                    text: "开始日期不能大于截止日期",
                    type: "warning",
                    confirmButtonText: "确认"
                }, function(){
                    $("#js").next("span").find("input[type='text']").val("");
                });
            }else {
                if(jc.length==0){
                    swal("注意！","请至少选择一个检查人！","error");
                }else{
                    if(sh.length==0){
                        swal("注意！","请至少选择一个审核人！","error");
                    }else{
                        // swal("成功！","666+！","success");
                        $.ajax({
                            type:"post",
                            data:{
                                name:name,
                                start:sta,
                                end:en,
                                ct:ct,
                                qy:qy,
                                xq:xq,
                                lid:lid,
                                jid:jid,
                                sid:sid,
                                taskid:taid
                            },
                            url:addTask,
                            success:function (data) {
                                if(data=="true"){
                                    swal({
                                        title: "添加成功！",
                                        text: "任务已成功添加",
                                        type: "success",
                                        confirmButtonText: "确认"
                                    }, function(){
                                      window.location.reload();
                                    });
                                }else  if(data=="true1"){
                                    swal({
                                        title: "修改成功！",
                                        text: "任务已成功修改",
                                        type: "success",
                                        confirmButtonText: "确认"
                                    }, function(){
                                        window.location.reload();
                                    });
                                } else{
                                     swal("操作失败！",data,"error");
                                }
                            }
                        })

                    }
                }
            }
        }
        return false;
    });

    //分页
    $("body").on("click","#userPageT1>li",function(){
        var liLen=$("#userPageT1>li").length;
        var start= $("#start").next("span").find("input[type='text']").val();
        var end= $("#end").next("span").find("input[type='text']").val();
        var t=$(this).text();
        var mh=$("#task").text();
        var sta="";
        var en="";
        if(start!="" && end!=""){
            sta=$.myTime.DateToUnix(start);
            en=$.myTime.DateToUnix(end);
        }
        num=pageNum(t,liLen,num);
        $.ajax({
            type:"post",
            url:taskPage,
            data:{
                start:num,
                mh:mh,
                ks:sta,
                js:en
            },
            success:function (data) {
                $("#task_page").html(data);
            }
        });
    });

    //    //用户模糊查询
    $(".col-xs-12").on("click","#likeTask",function() {
        num=0;
        var start= $("#start").next("span").find("input[type='text']").val();
        var end= $("#end").next("span").find("input[type='text']").val();
        var mh=$("#task").val();
        var sta="";
        var en="";
        if(start!="" && end!=""){
            sta=$.myTime.DateToUnix(start);
            en=$.myTime.DateToUnix(end);
        }
        $.ajax({
            type:"post",
            url:taskPage,
            data:{
                mh:mh,
                ks:sta,
                js:en
            },
            success:function (data) {
                $("#task_page").html(data);
            }
        });
    });

    $(".col-xs-12").on("keydown","#task",function(){
        if(event.keyCode == 13){
            num=0;
            var start= $("#start").next("span").find("input[type='text']").val();
            var end= $("#end").next("span").find("input[type='text']").val();
            var mh=$("#task").val();
            var sta="";
            var en="";
            if(start!="" && end!=""){
                sta=$.myTime.DateToUnix(start);
                en=$.myTime.DateToUnix(end);
            }
            $.ajax({
                type:"post",
                url:taskPage,
                data:{
                    mh:mh,
                    ks:sta,
                    js:en
                },
                success:function (data) {
                    $("#task_page").html(data);
                }
            });
        };
    });

    //作废功能
    $("body").on("click","#sample-table-T1 .icon-ban-circle",function (){
        var tr=$(this).parents("tr");
        var tx=tr.find("td").eq(7).text();
        tx=$.trim(tx);
        if(tx=='进行中'){
            swal({
                    title: "确定作废吗？",
                    text: "作废后你将无法恢复该条记录的状态！",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确认作废！",
                    cancelButtonText: "取消！",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type:"post",
                            url:abandoned,
                            data:{
                                id:id
                            },
                            success:function (data) {
                                if(data=='true'){
                                    swal({
                                        title: "作废成功！",
                                        text: "记录已作废！",
                                        type: "success"
                                    },function () {
                                        tr.find("td").eq(7).find("button").text('已作废');
                                        tr.find("td").eq(7).find("button").css("background-color","#808080");
                                    });
                                }
                            }
                        })
                    } else {
                        swal("取消！", "操作已取消！",
                            "error");
                    }
                });
        }
        var id=tr.attr('tid');
    });

    //编辑
    $("body").on("click","#sample-table-T1 .icon-edit",function (){
        var tr=$(this).parents("tr");
        if($.trim(tr.find("td").eq(7).text())!="已作废"){
            $(this).attr("data-target","#myTask");
            $("#taskCz").text("确认修改");
            $("#myTask #tct").find("option").eq(0).prop("selected",true);
            $("#myTask #tqy").html("<option></option>");
            $("#myTask #txq").html("<option></option>");
            $("#myTask input[name='tname']").val("");
            $("#ks").next("span").find("input[type='text']").val("");
            $("#js").next("span").find("input[type='text']").val("");
            $("#taskid").val("");
            $("#ldList").html("");
            $("#jcr").html("");
            $("#shr").html("");
            var tid=tr.attr('tid');
            var name=tr.find("td").eq(1).text();
            var start=tr.find("td").eq(2).text();
            var end=tr.find("td").eq(3).text();
            var jc=tr.find("td").eq(5).find('span');
            var sh=tr.find("td").eq(6).find('span');
            for(var i=0;i<jc.length;i++){
                var tx=$.trim(jc.eq(i).text());
                var id=jc.eq(i).attr("yid");
                $("#jcr").append("<a href='#' uid='"+id+"'>"+tx+"</a>&nbsp;")
            }
            for(var i=0;i<sh.length;i++){
                var txs=$.trim(sh.eq(i).text());
                var ids=sh.eq(i).attr("yid");
                $("#shr").append("<a href='#' uid='"+ids+"'>"+txs+"</a>&nbsp;")
            }
            name=$.trim(name);
            start=$.trim(start);
            end=$.trim(end);
            $("#myTask input[name='tname']").val(name);
            $("#myTask #tct").find("option").eq(1).prop("selected",true);
            $("#ks").next("span").find("input[type='text']").val(start);
            $("#js").next("span").find("input[type='text']").val(end);
            $("#taskid").val(tid);
            var sp=tr.find("td").eq(4).find("span").eq(0);
            var tp=sp.attr("tp");
            var xid="";
            var pid="";
            var yid="";
            if(tp==1){
                xid=sp.attr("xid");
                pid=sp.attr("pid");
                $("#tct").trigger("change",[xid]);
                $("#tqy").trigger("change",[pid,xid]);
                var sp1=tr.find("td").eq(4).find("span:not(:first)");
                var lid=new Array();
                for(var i=0;i<sp1.length;i++){
                    lid[i]=sp1.eq(i).attr('yid');
                }
                $("#txq").trigger("change",[pid,lid]);
            }else if(tp==2){
                xid=sp.attr("xid");
                yid=sp.attr("yid");
                $("#tct").trigger("change",[xid]);
                $("#tqy").trigger("change",[yid,xid]);
                $("#txq").trigger("change",[yid,["0"]]);
            }else if(tp==3){
                xid=sp.attr("yid");
                $("#tct").trigger("change",[xid]);
            }
        }else{
            swal("提示！","已作废的记录不能编辑！","info")
        }



    });

    //新增情况模态框
    $(".col-xs-12").on("click","#qk",function(){
        $("#myTask #tct").find("option").eq(0).prop("selected",true);
        $("#myTask #tqy").html("<option></option>");
        $("#myTask #txq").html("<option></option>");
        $("#myTask input[name='tname']").val("");
        $("#ks").next("span").find("input[type='text']").val("");
        $("#js").next("span").find("input[type='text']").val("");
        $("#ldList").html("");
        $("#jcr").html("");
        $("#shr").html("");
        $("#taskid").val("");
        $("#taskid").val("0");
        $("#taskCz").text("确认新增");
    });
});