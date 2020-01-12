$(function () {
    document.onkeydown = function (event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 13) { // enter 键
            $("#seller_login").click();
        }
    };
})

//用户登录
function loginSubmit(obj) {
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在登录...');
    ajaxForm({
        url: 'seller/login/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            $(obj).val('立即登录');
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('seller.index/home/smenu_id/' + data.content + '.html');
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 2});
                $(obj).css({'pointer-events': 'auto'});
            }
        }
    });
}
