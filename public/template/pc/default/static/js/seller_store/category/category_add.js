
function addCategory(obj){
    var cat_name = $("#cat_name").val();
    if(!trim(cat_name)){
        layer.msg("标题不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_store.category/category_add/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    returnOnPage();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}