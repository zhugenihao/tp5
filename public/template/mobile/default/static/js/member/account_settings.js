$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
        //表单初始赋值

    })
    $("#clickphoto").click(function () {
        $("#idphoto").click();
    });
    $("#idphoto").on('change', function () {
        layer.load(1);
        ajaxForm({
            url: 'member/account_settings/',
            type: 'post',
            formName: 'formsubmit',
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, function () {//关闭后的操作
                    });
                }
            }
        });
    });
})

//退出登录
function mLogout(obj) {
    layer.confirm('你确定要退出登录么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
        ajaxMethods_mLogout(obj);
    });
}
function ajaxMethods_mLogout(obj) {
    ajaxMethods({
        url: 'common/mLogout/',
        sCallback: function (data) {
            console.log(data);
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    href_url('index/index/');
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
