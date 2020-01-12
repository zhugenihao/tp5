
function detailsCates(obj) {
    var cate_name = $("#cate_name").val();
    var directory3_id = $("#directory3_id").val();
    if (!trim(cate_name) || !trim(directory3_id)) {
        layer.msg("版本名称、类目缺一不可！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_specifications.cates/cates_details',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    closeRefresh();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
