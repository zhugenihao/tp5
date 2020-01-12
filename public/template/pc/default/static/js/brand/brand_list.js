
function delBrand(obj) {
    var brand_id = $(obj).data('brandid');
    var brandid_all = brand_id ? brand_id : getChecked();
    if(!trim(brandid_all)){
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'brand/delBrand/',
            type: 'post',
            data: {brandid_str: brandid_all},
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