/*付款*/
function modifyStart(obj) {
    var order_id = $(obj).data("orderid");
    var order_type = $(obj).data("ordertype");
    var text = "确认要付款吗？";
    layer.confirm(text, function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/disable',
            data: {'order_id': order_id,order_type:order_type},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        window.location.reload();//刷新页面
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
            data: {'order_id': order_id,order_type:order_type},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        window.location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}
/*删除*/
function orderDel(obj, id) {
    layer.msg("不能删除订单", {icon: 5});return;
    var idstr = getChecked();
    var idstr = id ? id : idstr;
    layer.confirm('确认要删除这些吗？', function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/orderDel',
            data: {'idstr': idstr},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        window.location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}
function orderGoodsDel(obj, id) {
    layer.msg("不能删除订单", {icon: 5});return;
    var idstr = getChecked();
    var idstr = id ? id : idstr;
    layer.confirm('确认要删除这些吗？', function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.order/orderGoodsDel',
            data: {'idstr': idstr},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        window.location.reload();//刷新页面
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
}