/**
 * Created by Administrator on 2017/4/24 0024.
 */
var ajaxbg = $("#background,#progressBar");

// 分页封装

var num = 0;

function pageNum(txt, len, num) {
    if (txt == "上一页") {
        if (num > 0) {
            num = num - 1;
        } else {
            num = 0;
        }
    } else if (txt == "下一页") {
        if (num == (len - 5)) {
            num = len - 5;
        } else {
            num = num + 1;
        }
    } else if (txt == "首页") {
        num = 0;
    } else if (txt == "尾页") {
        num = len - 5;
    } else {
        num = txt - 1;
    }
    return num;
}




$(function() {
    //一级游标移动设置
    $("#sidebar").on("click", "#re-list>li:not(:first)", function() {
        $(this).attr("class", "active");
        $("li ").not($(this)).attr("class", "");
        var fid = $(this).attr("f_id");
        /*$.ajax({
            type: "post",
            url: 'Index/tNav',
            data: {
                fid: fid
            },
            success: function(re) {
                $("#tc").html(re);
            }
        });*/
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
               $(".wizard-steps span:contains("+t+")").css("background-color","rgb(111, 179, 224)").css("color","#FFF");
            }
        });
    }

    $("body").on("click", ".wizard-steps>li span", function() {
        var val = $(this).text();
        $(this).css("background-color", "rgb(111, 179, 224)");
        $(this).css("color", "#FFF");
        $(".wizard-steps>li span").not($(this)).css("background", "");
        $(".wizard-steps>li span").not($(this)).css("color", "#546474");
        var h = window.location.host;
        if (val == '用户管理') {
            // window.location.href="http://"+h
        }

    });



});
