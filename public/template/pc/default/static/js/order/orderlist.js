
layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form, layer = layui.layer;
    // select下拉框选中触发事件
    form.on("select(order_state)", function (data) {
        console.log(data.value);
        var state = data.value;
        var activity = $("#activity").val();
        href_url('order/orderlist?type=4&state=' + state+"&activity="+activity);
    });
});
$(function () {
    shopWindow({
        selector:".det_payment",
        top:'20%',
        width:'400px',
        height:'400px',
        sCallback:function(obj){
            var order_no = $(obj).data('orderno');
            var total_price = $(obj).data('totalprice');
            var goods_num = $(obj).data('goodsnum');
            $("#order_no").val(order_no);
            $("#total_price").val(total_price);
            $("#tprice_text").text(total_price);
            $(".goods_num").text(goods_num);
        }
    });
    $("#payment_div div").click(function(){
        $("#payment_div div").removeClass('paybacg');
        $(this).addClass('paybacg');
        var payment_type = $(this).data('paytype');
        $("#payment_type").val(payment_type);
    })
});

function orderDel(obj) {
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        orderDelAjax(obj);
    });
}
function orderDelAjax(obj) {
    var order_id = $(obj).data('orderid');
    ajaxMethods({
        url: 'order/orderDel/',
        type: 'get',
        data: {order_id: order_id},
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

function detPayment(obj) {
    var payment_type = $("#payment_type").val();
    if(payment_type!='balance'){
        layer.msg("该支付暂未开放！", {icon: 5});return;
    }
    layer.confirm('确认支付', {
        btn: ['确认', '取消']
    }, function () {
        payUpdate(obj);
    });
}

function payUpdate(obj) {
    layer.load(2);
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    ajaxForm({
        url: 'pay/payUpdateOne/',
        type: 'post',
        formName: 'pay_submit',
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
function confirmGoods(obj) {
    var order_no = $(obj).data('orderno');
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

