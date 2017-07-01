// 匹配准备
function toRun(isID) {
    var ulID; // ul的id
    ulID = $("#" + isID);
    ulID.children().each(function() {
        var wordCN = $(this).html();
        var wordPinYin = $(this).toPinyin();
        var wordPY = "";
        wordPinYin.replace(/[A-Z]/g, function(word) { wordPY += word });
        $(this).attr('CN', (wordCN).toLowerCase()); // 汉字
        $(this).attr('PinYin', (wordPinYin).toLowerCase()); // 拼音全拼
        $(this).attr('PY', (wordPY).toLowerCase()); // 拼音首字母
    });
}