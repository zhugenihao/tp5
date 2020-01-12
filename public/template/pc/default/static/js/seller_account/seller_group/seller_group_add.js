
function addSellerGroup(obj) {
    var group_name = $("#group_name").val();
    if (!trim(group_name)) {
        layer.msg("账号组名称不能为空！", {icon: 5});
        return;
    }
//    if (!isMobile(contact_phone)) {
//        layer.msg("联系电话格式不正确！", {icon: 5});
//        return;
//    }
    ajaxForm({
        url: 'seller_account.seller_group/seller_group_add',
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
$(function () {
    $("#table_click table .checkedAll").click(function () {
        console.log(3232);
        if ($(this).prop("checked")) {
            $(this).parents("table").find(".checkboxzi").each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $(this).parents("table").find(".checkboxzi").each(function () {
                $(this).prop("checked", false);
            });
        }
    })
    $(".checkboxzi").click(function () {
        if ($(this).prop("checked")) {
            $(this).parents("table").find(".checkedAll").prop("checked", true);
        } else {
            $(this).parents("table").find(".checkedAll").prop("checked", false);
        }
        var length = $(this).parents("table").find(".checkboxzi").length;
        for (var i = 0; i < length; i++) {
            if ($(this).parents("table").find(".checkboxzi").eq(i).prop("checked")) {
                $(this).parents("table").find(".checkedAll").prop("checked", true);
            }
        }
    })
})
