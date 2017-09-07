// 选择城市
$('#city').click(function() {

    toRun('is_city'); // 初始化匹配功能，传入ul的id
    $('.city-all input').removeAttr('value'); // 清空输入框值

    // 所有城市
    $('.city-all').show();
    $('.city-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html(''); // 清空楼栋信息列表，仅当选择小区时显示
    $('#area span').html('选区域'); // 下二级改为待选状态
    $('#xq span').html('选小区');

    $('.city-all input').bind('input propertychange', function() { // 监听搜索框
        searchCity();
    });

    function searchCity() {
        var $oLi = $('#is_city').find('li'); // 所有内容对象
        var $keyWords = $('.city-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_city li').bind('click', function() {
        $('#city span').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 城市id
        var html = '';
        $.ajax({
            type: "POST",
            url: ajaxIndexUrl,
            data: "xzqy_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                }
                $('#is_area').html(html); // 更新区域列表
            }
        });
    });
});


// 选择区域
$('#area').click(function() {

    toRun('is_area'); // 初始化匹配功能，传入ul的id
    $('.area-all input').removeAttr('value'); // 清空输入框值

    $('.area-all').show();
    $('.area-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html('');
    $('#xq span').html('选小区');

    $('.area-all input').bind('input propertychange', function() { // 监听搜索框
        searchArea();
    });

    function searchArea() {
        var $oLi = $('#is_area').find('li'); // 所有内容对象
        var $keyWords = $('.area-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_area li').bind('click', function() {
        $('#area span').html($(this).html()); // 下拉框选中值
        close();
        var id = $(this).attr('class'); // 区域id
        var html = '';
        $.ajax({
            type: "POST",
            url: ajaxIndexUrl,
            data: "area_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += ' <li class="' + data[i].id + '">' + data[i].name + '</li>';
                }
                if (html !== '') {
                    $('#is_xq').html(html); // 更新小区列表
                } else {
                    $('#is_xq').html('<p style="padding: 14px 10px;width: calc(100% - 20px);border-bottom: 1px solid #efefef; font-size: 14px; font-weight: 300; letter-spacing: 1.2px;">该区域下没小区，换个区域试试吧</p>');
                }

            }
        });
    });
});

// 选择小区
$('#xq').click(function() {

    toRun('is_xq'); // 初始化匹配功能，传入ul的id
    $('.xq-all input').removeAttr('value'); // 清空输入框值

    // 所有小区
    $('.xq-all').show();
    $('.xq-all').animate({
        textIndent: 0
    }, {
        step: function(now, fx) {
            $(this).css('transform', 'translateX(-50%) scale(1, 1)');
            $(this).css('opacity', 1);
        }
    });
    $('.mask').show(); // 遮罩

    $('#room-list').html(''); // 清空楼栋信息列表，仅当选择小区时显示
    $('#xq span').html('选小区');

    $('.xq-all input').bind('input propertychange', function() { // 监听搜索框
        searchXq();
    });

    function searchXq() {
        var $oLi = $('#is_xq').find('li'); // 所有内容对象
        var $keyWords = $('.xq-all input').val(); // 搜索内容
        if ($keyWords == '') {
            $oLi.show();
            $('.tips').hide();
            return false;
        }
        var $isCN = true;
        var pattern = /^[\u4e00-\u9fa5]*$/; // 汉字正则
        if (!pattern.test($keyWords)){ // 判断搜索内容是否为汉字，影响查询条件
            $isCN = false;
        }
        var $keyWords2 = '';
        $('.tips').hide();
        $showTips = true;
        for (var i = 0; i < $oLi.length; i++) {
            // 根据输入的内容是否为中文判断是否按名称进行查询
            if ($isCN){
                $keyWords2 = $oLi.eq(i).attr("CN"); //中文名称
            } else {
                $keyWords2 = $oLi.eq(i).attr("PY"); // 拼音首字母缩写
            }
            $oLi.eq(i).hide();

            // 匹配是否存在（转小写）
            if ($keyWords2.toLocaleLowerCase().indexOf($keyWords.toLocaleLowerCase()) >= 0) {

                $oLi.eq(i).show();
                $('.tips').hide();
                $showTips = false; // 隐藏未匹配提示
            }
        }
        if ($showTips) {
            $('.tips').show(); // 未匹配到内容提示
        }
    }

    // 点击li
    $('#is_xq li').bind('click', function() {
    	if ($(this).html().length > 4) { // 下拉框选中值
            var subFonts = $(this).html().substr(0, 4) + '···';
            $('#xq span').html(subFonts);
        } else {
            $('#xq span').html($(this).html());
        }
        close();
        var id = $(this).attr('class'); // 小区id
        var html = '';
        $.ajax({
            type: "POST",
            url: ajaxIndexUrl,
            data: "xq_id=" + id,
            dataType: 'json',
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<li>';
                    html += '<a href="'+ajaxRoomUrl+'?proj_id=' + id + '&bld_id=' + data[i].id + '&unit=' + data[i].unit + '">'; // 跳转房间可视化列表页
                    html += '<span class="position">' + data[i].name + data[i].unit + '单元</span>';
                    html += '<span class="result">';
                    html += '<span class="yes-c">已查23</span>';
                    html += '<span class="no-c">未查<span style="color: #fb4b40;">22</span></span>';
                    html += '</span>';
                    html += '</a>';
                    html += '</li>';
                }
                $('#room-list').html(html); // 更新栋单元数据
            }
        });
    });
});