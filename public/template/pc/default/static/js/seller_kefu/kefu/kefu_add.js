
$(function () {
    $("#kefu_tool").on('change', function () {
        var value = $(this).val();
        if (value == 1) {
            $("#passworddiv").show();
        } else {
            $("#passworddiv").hide();
        }
    })
})
function addKefu(obj) {
    var kefu_name = $("#kefu_name").val();
    var kefu_account = $("#kefu_account").val();
    var kefu_tool = $("#kefu_tool").val();
    var kefu_password = $("#kefu_password").val();
    if (!trim(kefu_name) || !trim(kefu_account)) {
        layer.msg("客服名称/客服账号缺一不可！", {icon: 5});
        return;
    }
    if (kefu_tool == 1 && kefu_password == '') {
        layer.msg("密码不能为空！", {icon: 5});
        return;
    }

    ajaxForm({
        url: 'seller_kefu.kefu/kefu_add/',
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
