function memberPayPassword(obj) {
    var pay_password_old = $("#pay_password_old").val();
    var pay_password_new = $("#pay_password_new").val();
    var pay_password_queren = $("#pay_password_queren").val();
    if (!trim(pay_password_old)) {
        layer.msg('原始登录密码不能为空!', {icon:5});
        return false;
    }
    if (!trim(pay_password_new)) {
        layer.msg('新的密码不能为空!', {icon:5});
        return false;
    }
    if (!trim(pay_password_queren)) {
        layer.msg('确认密码不能为空!', {icon:5});
        return false;
    }
    if (pay_password_new!==pay_password_queren) {
        layer.msg('确认密码不正确!', {icon:5});
        return false;
    }
    layer.confirm('你确定要修改登录密码么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
        ajaxMemberPayPassword(pay_password_old,pay_password_new);
    });
}
function ajaxMemberPayPassword(pay_password_old,pay_password_new) {
    ajaxMethods({
        url: 'member/pay_password/',
        type: 'post',
        data: {pay_password_old: pay_password_old,pay_password_new:pay_password_new},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt,{icon:1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon:5});
            }
        }
    });
}