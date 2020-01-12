
function delCategory(obj) {
    var category_id = $(obj).data('categoryid');
    var categoryid_all = category_id ? category_id : getChecked();
    if(!trim(categoryid_all)){
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_store.category/delCategory/',
            type: 'post',
            data: {categoryid_all: categoryid_all},
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