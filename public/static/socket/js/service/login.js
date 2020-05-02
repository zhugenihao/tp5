document.onkeydown = function (event) {
    var e = event || window.event || arguments.callee.caller.arguments[0];
    if (e && e.keyCode == 13) { // enter 键
        doLogin();
    }
};

$(function () {
    $("#btn").click(function () {
        doLogin();
    });
});
function doLogin(obj) {
    var btn = $("#btn");
    btn.css({'pointer-events': 'none'});//设置禁止点击
    btn.val('正在登录...');
    ajaxForm({
        url: 'service/login/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            btn.val('立即登录');
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('service/index/');
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 2});
                btn.css({'pointer-events': 'auto'});
            }
        }
    });
}