function updateSellerCourier(obj) {
    var courierid_str = getChecked();
    layer.confirm('确认要更新么？', function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.courier/updateSellerCourier',
            data: {'courierid_str': courierid_str},
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