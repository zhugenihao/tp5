layui.use('laydate', function () {
    var laydate = layui.laydate;

    //常规用法
    laydate.render({
        elem: '#start_time'
    });
    laydate.render({
        elem: '#end_time'
    });
});
function delComments(obj) {
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
            url: 'seller_after_sales.comments/delComments/',
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
function modifyShow(obj) {
    var id = $(obj).data('id');
    layer.confirm('你确定要改变显示么？', {
        btn: ['显示', '隐藏'] //按钮
    }, function () {
        modifyShowAjax(id, 1);
    }, function () {
        modifyShowAjax(id, 2);
    });
}
function modifyShowAjax(id, is_show) {
    ajaxMethods({
        url: 'seller_after_sales.comments/modifyShow/',
        type: 'get',
        data: {id: id, is_show: is_show},
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
function commentsDetails(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '商品评论详情',
        shadeClose: true,
        shade: 0.2,
        area: ['900px', '700px'],
        content: url //iframe的url
    });
}