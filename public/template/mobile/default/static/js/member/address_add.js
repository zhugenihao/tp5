$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;

        //表单初始赋值
        form.val('example', {
            "close": true //开关状态
        })
        //监听提交
        form.on('submit(demo1)', function (data) {
            var field = data.field;
            submitAddress(field);
        });

    });
    $(".address-bjas .address-bj").click(function () {
        $(".address-bjas .address-bj").removeClass('bj-active');
        $(this).addClass('bj-active');
        var sign_id = $(this).data('id');
        $(".sign_id").val(sign_id);
    });
    $("#add_sign").click(function () {
        layer.prompt({title: '添加地址标志', formType: 3}, function (sign_name, index) {
            layer.close(index);
            submitSign(sign_name);
        });
    });
    $("#del_sign").click(function () {
        if ($(".delsigns").is(':hidden')) {
            $(".delsigns").show();
        } else {
            $(".delsigns").hide();
        }
    });
    $(".delsigns").click(function () {
        var id = $(this).data('id');
        layer.msg('你确定要删除么？', {
            time: 20000, //20s后自动关闭
            btn: ['确定', '取消'],
            yes: function (index) {
                ajaxDelSign(id);
            }
        });
    });

});
function ajaxDelSign(id) {
    ajaxMethods({
        url: 'member/delSign/',
        type: 'get',
        data: {id: id},
        sCallback: function (data) {
            console.log(data);
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function submitAddress(field) {
    layer.confirm('你确定要添加么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        ajaxSubmitAddress(field);
    });
}

function ajaxSubmitAddress(field) {
    ajaxMethods({
        url: 'Address/addAddress/',
        type: 'post',
        data: field,
        sCallback: function (data) {
            console.log(data);
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    history.back();
                    returnOnPageReload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function submitSign(sign_name) {
    ajaxMethods({
        url: 'member/addSign/',
        data: {'sign_name': sign_name},
        sCallback: function (data) {
            console.log(data);
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
