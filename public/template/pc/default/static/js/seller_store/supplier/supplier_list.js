
function delSupplier(obj) {
    var supplier_id = $(obj).data('supplierid');
    var supplierid_all = supplier_id ? supplier_id : getChecked();
    if (!trim(supplierid_all)) {
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_store.supplier/delSupplier/',
            type: 'post',
            data: {supplierid_str: supplierid_all},
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
function supplierAdd(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '添加供货商',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
function supplierDetails(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '编辑供货商',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
