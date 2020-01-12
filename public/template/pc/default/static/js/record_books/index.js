
layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form, layer = layui.layer;
    // select下拉框选中触发事件
    form.on("select(bookstype)", function (data) {
        console.log(data.value);
        var bookstype = data.value;
        href_url('record_books/index?type=2&books_type='+bookstype);
    });
});
