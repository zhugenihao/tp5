function memberSetPayPassword(obj) {
    var pay_password = $("#pay_password").val();
    var pay_password_queren = $("#pay_password_queren").val();
    if (!trim(pay_password)) {
        layer.msg('新的密码不能为空!', {icon:5});
        return false;
    }
    if (!trim(pay_password_queren)) {
        layer.msg('确认密码不能为空!', {icon:5});
        return false;
    }
    if (pay_password!==pay_password_queren) {
        layer.msg('确认密码不正确!', {icon:5});
        return false;
    }
    layer.confirm('你确定要修改登录密码么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
        ajaxMemberPayPassword(pay_password);
    });
}
function ajaxMemberPayPassword(pay_password) {
    ajaxMethods({
        url: 'member/setupthe_pay_password/',
        type: 'post',
        data: {pay_password: pay_password},
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