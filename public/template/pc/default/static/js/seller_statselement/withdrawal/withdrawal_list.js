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
function withdrawalAdd(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '添加提现申请',
        shadeClose: true,
        shade: 0.2,
        area: ['800px', '700px'],
        fixed: false, //不固定
        maxmin: true,
        content: url //iframe的url
    });
}