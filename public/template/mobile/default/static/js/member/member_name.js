$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
        //表单初始赋值

    })
})
function memberName(obj) {
    var member_name = $("#member_name").val();
    if (!trim(member_name)) {
        layer.msg('用户名不能为空!', function () {//关闭后的操作
        });
        return false;
    }
    layer.confirm('你确定要修改用户名么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
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