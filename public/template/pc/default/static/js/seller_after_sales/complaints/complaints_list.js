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
function delComplaints(obj) {
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
            url: 'seller_after_sales.complaints/delComplaints/',
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
    layer.confirm('你确定要处理么？', {
        btn: ['处理中', '已完成'] //按钮
    }, function () {
        modifyAuditAjax(id, 2);
    }, function () {
        modifyAuditAjax(id, 3);
    });
}
function modifyAuditAjax(id, state) {
    ajaxMethods({
        url: 'seller_after_sales.complaints/modifyAudit/',
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
function complaintsDetails(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '投诉详情',
        shadeClose: true,
        shade: 0.2,
        area: ['900px', '700px'],
        fixed: false, //不固定
        maxmin: true,
        content: url //iframe的url
    });
}