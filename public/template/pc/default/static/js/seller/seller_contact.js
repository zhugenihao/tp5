
function contactSubmit(obj) {
    var contact_name = $("#contact_name").val();
    var contact_mobile = $("#contact_mobile").val();
    var contact_email = $("#contact_email").val();
    if (!trim(contact_name) || !trim(contact_mobile) || !trim(contact_email)) {
        layer.msg("缺一不可！", {icon: 2});
        return;
    }
    if (!isMobile(contact_mobile)) {
        layer.msg("手机号码不正确！", {icon: 2});
        return;
    }
    if (!isEmail(contact_email)) {
        layer.msg("邮箱不正确！", {icon: 2});
        return;
    }
    var application_type = $('input:radio[name="application_type"]:checked').val();
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在提交中...');
    ajaxForm({
        url: 'seller/seller_contact/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (application_type == '1') {
                href_url('seller/seller_store?application_type='+application_type);
            }
            if (application_type == '2') {
                href_url('seller/seller_company');
            }

        }
    });
}
