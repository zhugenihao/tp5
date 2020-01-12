
function delComdsption(obj) {
    var comdsptionid = $(obj).data('comdsptionid');
    var comdsptionid_str = comdsptionid ? comdsptionid : getChecked();
    if(!trim(comdsptionid_str)){
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_sales_promotion.comdysales_promotion/delComdsption/',
            type: 'post',
            data: {comdsptionid_str: comdsptionid_str},
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