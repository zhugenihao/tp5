function memberName(obj) {
    var member_name = $("#member_name").val();
    if (!trim(member_name)) {
        layer.msg('用户名不能为空!', {icon: 5});
        return false;
    }
    layer.confirm('你确定要修改用户名么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMemberName(member_name);
    });
}
function ajaxMemberName(member_name) {
    ajaxMethods({
        url: 'member/member_name/',
        type: 'get',
        data: {member_name: member_name},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}