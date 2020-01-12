
function del(obj) {
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
            url: 'seller_kefu.kefu_statements/del/',
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
function add(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '添加常用语句',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
function details(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '编辑常用语句',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
