var form = '';
layui.use(['form', 'flow', 'layedit', 'laydate'], function () {
    form = layui.form,
            flow = layui.flow;
});
function confirmGoods(obj) {
    var order_no = $("#order_no").val();
    layer.msg('你确定要确认收货么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            confirmGoodsAjax(order_no);
        }
    });
}
function confirmGoodsAjax(order_no) {
    ajaxMethods({
        url: 'order/confirmGoods/',
        type: 'get',
        data: {order_no: order_no},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}

function detPayment(obj) {
    layer.msg('确认支付', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            payUpdate(obj);
        }
        , btn2: function () {
        }
    });
}

function payUpdate(obj) {
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    ajaxForm({
        url: 'pay/payUpdate/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
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
function datel(obj) {
    var tel = $(obj).data('tel');
//    layer.open({
//        type: 1,
//        title: '联系信息',
//        skin: 'layui-layer-rim', //加上边框
//        area: ['420px', '240px'], //宽高
//        content: '<div style="padding:10px;">电话：' + tel + '</div>'
//    });
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        closeBtn: true, //不显示关闭按钮
        anim: 2,
        shadeClose: true, //开启遮罩关闭
        content: '<div style="padding:10px;">电话：' + tel + '</div>'
    });
}
var isLoginas = true;
$(function () {
    $("#socketa").click(function () {
        ajaxMethods({
            url: 'common/isLogin/',
            type: 'get',
            data: {},
            sCallback: function (data) {
                if (data.types === 0) {
                    isLoginas = false;
                }
            }
        });
        if (isLoginas === false) {
            layer.msg("请登录再访问", {icon: 5});
            return;
        }
        var url = $(this).attr('url');
        pageJump(url);
    })
})
