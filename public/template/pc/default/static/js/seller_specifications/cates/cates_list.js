
function delCates(obj) {
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
            url: 'seller_specifications.cates/delCates/',
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
function catesAdd(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '添加版本',
        shadeClose: true,
        shade: 0.2,
        area: ['750px', '700px'],
        content: url //iframe的url
    });
}
function catesDetails(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '编辑版本',
        shadeClose: true,
        shade: 0.2,
        area: ['750px', '700px'],
        content: url //iframe的url
    });
}
