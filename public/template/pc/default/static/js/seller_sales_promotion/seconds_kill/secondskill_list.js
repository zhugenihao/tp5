
function delSecondskill(obj) {
    var secondskill_id = $(obj).data('secondskillid');
    var secondskillid_all = secondskill_id ? secondskill_id : getChecked();
    if(!trim(secondskillid_all)){
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_sales_promotion.seconds_kill/delSecondsKill/',
            type: 'post',
            data: {secondskillid_str: secondskillid_all},
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