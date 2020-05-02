
var module = '/socket/';
//var module = 'http://syzwangzhanmei.club/mallz/public/socket/';//测试服务器地址
function ajaxMethods(ajaxArray) {
    if (ajaxArray.type == '') {
        ajaxArray.type = 'GET';
    }
    $.ajax({
        type: ajaxArray.type,
        url: module + ajaxArray.url,
        data: ajaxArray.data,
        dataType: 'json',
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
    });
}
//表单提交优化
function ajaxForm(ajaxArray) {
    if (ajaxArray.type == '') {
        ajaxArray.type = 'GET';
    }
    var form = document.forms.namedItem(ajaxArray.formName);
    var form = new FormData(form);
    $.ajax({
        type: ajaxArray.type,
        url: module + ajaxArray.url,
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
    });
}
//跳转
function href_url(url) {
    window.location.href = module + url;
}
//返回上一页
function returnOnPage() {
    history.back();
}