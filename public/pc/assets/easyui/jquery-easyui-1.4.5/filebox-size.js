$.extend($.fn.validatebox.defaults.rules, {
    // filebox验证文件大小的规则函数
    // 如：validType : ['fileSize[1,"MB"]']
    fileSize : {
        validator : function(value, array) {
            var size = array[0];
            var unit = array[1];
            if (!size || isNaN(size) || size == 0) {
                $.error('验证文件大小的值不能为 "' + size + '"');
            } else if (!unit) {
                $.error('请指定验证文件大小的单位');
            }
            var index = -1;
            var unitArr = new Array("bytes", "kb", "mb", "gb", "tb", "pb", "eb", "zb", "yb");
            for (var i = 0; i < unitArr.length; i++) {
                if (unitArr[i] == unit.toLowerCase()) {
                    index = i;
                    break;
                }
            }
            if (index == -1) {
                $.error('请指定正确的验证文件大小的单位：["bytes", "kb", "mb", "gb", "tb", "pb", "eb", "zb", "yb"]');
            }
            // 转换为bytes公式
            var formula = 1;
            while (index > 0) {
                formula = formula * 1024;
                index--;
            }
            // this为页面上能看到文件名称的文本框，而非真实的file
            // $(this).next()是file元素
            return $(this).next().get(0).files[0].size < parseFloat(size) * formula;
        },
        message : '文件大小必须小于 {0}{1}'
    }
});/**
 * Created by Administrator on 2017/2/23.
 */
