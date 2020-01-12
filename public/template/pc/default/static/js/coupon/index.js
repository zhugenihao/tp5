
layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form, layer = layui.layer;
    // select下拉框选中触发事件
    form.on("select(state)", function (data) {
        console.log(data.value);
        var state = data.value;
        href_url('coupon/index?type=3&state='+state);
    });
});
