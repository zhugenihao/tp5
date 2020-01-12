
function detailsSupplier(obj) {
    var supplier_name = $("#supplier_name").val();
    var contact_name = $("#contact_name").val();
    var contact_phone = $("#contact_phone").val();
    if (!trim(supplier_name) || !trim(contact_name) || !trim(contact_phone)) {
        layer.msg("供货商名称/联系人名称/联系电话缺一不可！", {icon: 5});
        return;
    }
    if (!isMobile(contact_phone)) {
        layer.msg("联系电话格式不正确！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_store.supplier/supplier_details/',
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
