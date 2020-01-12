$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
        //表单初始赋值

    })
})
function memberPassword(obj) {
    var password_old = $("#password_old").val();
    var password_new = $("#password_new").val();
    var password_queren = $("#password_queren").val();
    if (!trim(password_old)) {
        layer.msg('原始登录密码不能为空!', function () {//关闭后的操作
        });
        return false;
    }
    if (!trim(password_new)) {
        layer.msg('新的密码不能为空!', function () {//关闭后的操作
        });
        return false;
    }
    if (!trim(password_queren)) {
        layer.msg('确认密码不能为空!', function () {//关闭后的操作
        });
        return false;
    }
    if (password_new!==password_queren) {
        layer.msg('确认密码不正确!', function () {//关闭后的操作
        });
        return false;
    }
    layer.confirm('你确定要修改登录密码么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
        ajaxMemberPassword(password_old,password_new);
    });
}
function ajaxMemberPassword(password_old,password_new) {
    ajaxMethods({
        url: 'member/member_password/',
        type: 'post',
        data: {password_old: password_old,password_new:password_new},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    href_url('member/index?type=member');
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {//关闭后的操作
                });
            }
        }
    });
}