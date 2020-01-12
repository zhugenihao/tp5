$(function () {
    $("#kefu_tool").on('change', function () {
        var value = $(this).val();
        if (value == 1) {
            $("#passworddiv").show();
        } else {
            $("#passworddiv").hide();
        }
    })
    var kefu_tool = $("#kefu_tool").val();
    if (kefu_tool == 1) {
        $("#passworddiv").show();
    } else {
        $("#passworddiv").hide();
    }
})
function detailsKefu(obj) {
    var kefu_name = $("#kefu_name").val();
    var kefu_account = $("#kefu_account").val();
    if (!trim(kefu_name) || !trim(kefu_account)) {
        layer.msg("客服名称/客服账号缺一不可！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_kefu.kefu/kefu_details/',
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
