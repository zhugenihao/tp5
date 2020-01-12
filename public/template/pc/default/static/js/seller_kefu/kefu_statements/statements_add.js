
$(function () {
    
})
function addSubmit(obj) {
    var content = $("#content2").val();
    if (!trim(content)) {
        layer.msg("内容不能为空！", {icon: 5});
        return;
    }

    ajaxForm({
        url: 'seller_kefu.kefu_statements/statements_add/',
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
