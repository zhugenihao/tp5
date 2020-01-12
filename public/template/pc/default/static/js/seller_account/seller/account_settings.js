
function settingsSeller(obj) {
    var seller_name = $("#seller_name").val();
    if (!trim(seller_name)) {
        layer.msg("登录账号不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_account.seller/account_settings/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    closeRefresh();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
