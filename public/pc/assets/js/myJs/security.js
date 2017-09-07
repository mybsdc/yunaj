/**
 * Created by Administrator on 2017/7/3 0003.
 */
$(function () {
    //用户分页
    $("body").on("click","#userPageS2>li",function(){
        var liLen=$("#userPageS2>li").length;
        var t=$(this).text();
        num=pageNum(t,liLen,num);
        // alert(num);
        var id=$("select[name='ywcs']").val();
        $.ajax({
            type:"post",
            url:suPage,
            data:{
                start:num,
                id:id
            },
            success:function (data) {
                $("#suPage").html(data);
            }
        });
    });

    //根据参数改变选择输入框
    $("body").on("change","select[name='ywcs']",function(){
        $("#wt input").val("");
        var id=$(this).val();
        if(Number(id)==1){
            $("#xz").hide();
            $("#wt").show();
            $("#wt span").text("品牌：");
            $("#wt input").attr("placeholder","请输入品牌");
            $("#xz input").prop("disabled",true);
        }else if(Number(id)==2){
            $("#xz").hide();
            $("#wt").show();
            $("#wt span").text("类型：");
            $("#wt input").attr("placeholder","请输入气表类型");
            $("#xz input").prop("disabled",true);
        }else if(Number(id)==3){
            $("#xz").show();
            $("#wt").show();
            $("#wt span").text("问题：");
            $("#wt input").attr("placeholder","请输入问题");
            $("#xz input").prop("disabled",false);
        }
        num=0;
        $.ajax({
            type:"post",
            url:suPage,
            data:{
                id:id
            },
            success:function (data) {
                $("#suPage").html(data);
                if(Number(id)==1){
                    $("#th1").text("品牌");
                }else if(Number(id)==2){
                    $("#th1").text("类型");
                }else if(Number(id)==3){
                    $("#th1").text("问题");
                }
            }
        });
    });
    $("select[name='ywcs']").trigger("change");
    //新增明细
    $("body").on("submit","#addCd",function(){
        $.ajax({
            type:"post",
            url:addCd,
            data:$(this).serialize(),
            success:function (data) {
                // alert(data);
                if(data=="true"){
                   $("select[name='ywcs']").trigger("change");
                    $("#myModals1").modal("hide");
                    $("#addCd input").val("");
                    // $(".modal-backdrop").remove();
                    // $("body").removeClass('modal-open');//恢复滚动条
                }else{
                   swal("新增失败！","该参数已存在！","error");
                }
            }
        });
        return false;
    });

    //删除明细
    $("body").on("click","#sample-table-s1 button",function(){
        var id=$(this).parents("tr").attr("id");
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
                        url:deleteSu,
                        data:{
                            id:id
                        },
                        success:function (data) {
                            if(data=="true"){
                                swal("删除成功！","数据成功删除！","success");
                                $("select[name='ywcs']").trigger("change");
                            }else{
                        
                                swal("注意！","删除失败，刷新后重试！","error");
                            }
                        }
                    });
                    } else {
                        swal("取消！", "操作已取消！",
                            "error");
                    }
                });
       
    });

    //修改明细
    $("body").on("click","#sample-table-s1 a",function(){
        var id=$(this).parents("tr").attr("id");
        var pid=$(this).parents("tr").attr("pid");
        var name=$(this).parents("tr").find("td").eq(1).text();
        var da=$(this).parents("tr").find("td").eq(2).text();
        var arr=da.split("/");
        $("#myModals1 input[type='hidden']").val(id);
        $("#myModals1 input[name='sname']").val(name);
        if(Number(pid)==1){
            $("#myModals1 #tx1").text("品牌");
            $("#myModals1 input[name='sname']").attr("placeholder","请输入气表品牌");
            $("#myModals1 .form-group:not(:first)").hide();
            $("#myModals1 .form-group:not(:first) input").prop("disabled",true);
        }else if(Number(pid)==2){
            $("#myModals1 #tx1").text("气表类型");
            $("#myModals1 input[name='sname']").attr("placeholder","请输入气表类型");
            $("#myModals1 .form-group:not(:first)").css("display","none");
            $("#myModals1 .form-group:not(:first) input").prop("disabled",true);
        }else if(Number(pid)==3){
            $("#myModals1 #tx1").text("问题");
            $("#myModals1 input[name='sname']").attr("placeholder","请输入问题");
            $("#myModals1 .form-group:not(:first)").show();
            $("#myModals1 .form-group:not(:first) input").prop("disabled",false);
            $("#myModals1 input[name='d1']").val($.trim(arr[0]));
            $("#myModals1 input[name='d2']").val($.trim(arr[1]));
        }
    });
    $("body").on("submit","#updateSu",function(){
        $.ajax({
            type:"post",
            url:updateSu,
            data:$(this).serialize(),
            success:function (data) {
                // alert(data);
                if(data=="true"){
                    $("select[name='ywcs']").trigger("change");
                    $("#myModals1").modal("hide");
                    // $("#myModals1").hide();
                    // $(".modal-backdrop").remove();
                    // $("body").removeClass('modal-open');//恢复滚动条
                }else{
                    swal("修改失败！","该参数已存在！","error");
                }
            }
        });
        return false;
    });

});