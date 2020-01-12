
function detailsSellerAddress(obj) {
    var contact_name = $("#contact_name").val();
    var mobile = $("#mobile").val();
    var zip_code = $("#zip_code").val();
    var province_id = $("#province_id").val();
    var city_id = $("#city_id").val();
    var county_id = $("#county_id").val();
    var detailed_address = $("#detailed_address").val();
    if (!trim(contact_name)) {
        layer.msg("联系人不能为空！", {icon: 5});
        return;
    }
    if (!trim(mobile)) {
        layer.msg("手机不能为空！", {icon: 5});
        return;
    }
    if (!isMobile(mobile)) {
        layer.msg("手机号格式错误！", {icon: 5});
        return;
    }
    if (!trim(zip_code)) {
        layer.msg("邮政编码不能为空！", {icon: 5});
        return;
    }
    if (Number(province_id) < 1 || Number(city_id) < 1 || Number(county_id) < 1) {
        layer.msg("地区不能为空！", {icon: 5});
        return;
    }
    if (!trim(detailed_address)) {
        layer.msg("详细地址不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_store.seller_address/seller_address_details/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    returnOnPage();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
