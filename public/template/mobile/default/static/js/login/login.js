$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
        //表单初始赋值

    })
})
//用户登录
function loginSubmit(obj) {
    $(obj).text('正在登录...');
    ajaxForm({
        url: 'login/loginSubmit/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            $(obj).text('立即登录');
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    href_url('index/index/');
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {//关闭后的操作
                });
            }
        }
    });
}
