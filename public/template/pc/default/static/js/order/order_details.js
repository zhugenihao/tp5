function confirmGoods(obj) {
    var order_no = $("#order_no").val();
    layer.confirm('你确定要确认收货么？', {
        btn: ['确认', '取消']
    }, function () {
        confirmGoodsAjax(order_no);
    });
}
function confirmGoodsAjax(order_no) {
    ajaxMethods({
        url: 'order/confirmGoods/',
        type: 'get',
        data: {order_no: order_no},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}

function detPayment(obj) {
    layer.confirm('确认支付', {
        btn: ['确认', '取消']
    }, function () {
        payUpdate(obj);
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

var isLoginas = true;
function kefuUrl(obj) {

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
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        fixed: false, //不固定
        title: '在线客服',
        shadeClose: true,
        shade: 0.2,
        maxmin: true,
        area: ['700px', '700px'],
        content: url //iframe的url
    });
}
function datel(obj) {
    var tel = $(obj).data('tel');
    layer.open({
        type: 1,
        title: '联系信息',
        skin: 'layui-layer-rim', //加上边框
        area: ['420px', '240px'], //宽高
        content: '<div style="padding:10px;">电话：' + tel + '</div>'
    });
}