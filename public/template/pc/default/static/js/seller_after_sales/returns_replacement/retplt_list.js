
function delRetplt(obj) {
    var id = $(obj).data('id');
    var id_all = id ? id : getChecked();
    if (!trim(id_all)) {
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_after_sales.returns_replacement/delRetplt/',
            type: 'post',
            data: {id_str: id_all},
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
function modifyAudit(obj) {
    var id = $(obj).data('id');
    layer.confirm('你确定要审核么？', {
        btn: ['审核通过', '审核不用过'] //按钮
    }, function () {
        modifyAuditAjax(id, 2);
    }, function () {
        modifyAuditAjax(id, 3);
    });
}
function modifyAuditAjax(id, state) {
    ajaxMethods({
        url: 'seller_after_sales.returns_replacement/modifyAudit/',
        type: 'get',
        data: {id: id, state: state},
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
}
function retpltDetails(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '退换货详情',
        shadeClose: true,
        shade: 0.2,
        area: ['900px', '700px'],
        fixed: false, //不固定
        maxmin: true,
        content: url //iframe的url
    });
}