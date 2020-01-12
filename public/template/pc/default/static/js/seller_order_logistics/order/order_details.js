/*付款*/
function modifyStart(obj) {
    var order_id = $(obj).data("orderid");
    var order_type = $(obj).data("ordertype");
    var text = "确认要付款吗？";
    layer.confirm(text, function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/disable',
            data: {'order_id': order_id, order_type: order_type},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}
/***
 * 修改订单金额
 * @param {type} obj
 * @returns {undefined}
 */
function modifyTotalPrice(obj) {
    var order_id = $(obj).data("orderid");
    var total_price = $("#total_price").val();
    var text = "确认要订单金额吗？";
    layer.confirm(text, function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/modifyTotalPrice',
            data: {'order_id': order_id,total_price:total_price},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}

/**
 * 发货
 * @param {type} obj
 * @returns {undefined}
 */
function deliveryStart(obj) {
    var order_id = $(obj).data("orderid");
    var order_type = $(obj).data("ordertype");
    var text = "确认要发货吗？";
    layer.confirm(text, function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/deliveryStart',
            data: {'order_id': order_id, order_type: order_type},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}