
function detailsSeller(obj) {
    var seller_name = $("#seller_name").val();
    var seller_password = $("#seller_password").val();
    if (!trim(seller_name) || !trim(seller_password)) {
//        layer.msg("登录账号/登录密码缺一不可！", {icon: 5});
//        return;
    }
    ajaxForm({
        url: 'seller_account.seller/seller_details/',
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
