
function delCoupon(obj) {
    var copid = $(obj).data('copid');
    var copid_str = copid ? copid : getChecked();
    if (!trim(copid_str)) {
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_sales_promotion.coupon/delCoupon/',
            type: 'post',
            data: {copid_str: copid_str},
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
    });

}