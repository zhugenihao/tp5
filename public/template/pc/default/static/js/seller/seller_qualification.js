layui.use('laydate', function () {
    var laydate = layui.laydate;
    //常规用法
    laydate.render({
        elem: '#effective_start_time'
    });
    laydate.render({
        elem: '#effective_end_time'
    });
});
function qualificationSubmit(obj) {
    var business_attachment = $("#business_attachment").val();
    var trc_copy = $("#trc_copy").val();
    var koc_copy = $("#koc_copy").val();
    var panlpicop_copy = $("#panlpicop_copy").val();
    var shoticcot_front = $("#shoticcot_front").val();
    var card_or_passport = $("#card_or_passport").val();
    var store_card = $("#store_card").val();
    if (!trim(business_attachment) || !trim(trc_copy) || !trim(koc_copy) || !trim(panlpicop_copy) || !trim(shoticcot_front)
            || !trim(card_or_passport) || !trim(store_card)) {
        layer.msg("缺一不可！", {icon: 2});
        return;
    }
    if (!idCard(card_or_passport) && !checkPassport(card_or_passport)) {
        layer.msg("法人身份证/护照号码格式错误！", {icon: 2});
        return;
    }
    if (!idCard(store_card)) {
        layer.msg("店铺负责人身份证号码格式错误！", {icon: 2});
        return;
    }

    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在提交中...');
    ajaxForm({
        url: 'seller/seller_qualification/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {'icon': 1});
                setTimeout(function () {
                    href_url('seller/seller_audit');
                }, 1000);
            } else {
                $(obj).css({'pointer-events': 'auto'});//设置禁止点击
                layer.msg(data.prompt, {'icon': 5});
            }
        }
    });
}
