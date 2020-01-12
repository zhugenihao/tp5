
function addBrand(obj){
    var brand_name = $("#brand_name").val();
    if(!trim(brand_name)){
        layer.msg("品牌标题不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'brand/brand_add/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('brand/brand_list?top=3&type=5');
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}