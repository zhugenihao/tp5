$(function () {

})
/*删除*/
function delFreight(obj) {
    var freightid = $(obj).data('freightid');
    var idstr = getChecked();
    var idstr = freightid ? freightid : idstr;
    if (!idstr) {
        layer.msg("未选择数据！", {icon: 5});
        return;
    }
    layer.confirm('确认要删除这些吗？', function (index) {
        ajaxMethods({
            type: 'get',
            url: 'seller_order_logistics.freight/delFreight',
            data: {'freight_str': idstr},
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