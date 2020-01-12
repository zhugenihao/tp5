$(function () {
    var url = window.location.href;
    //一级目录
    var length1 = $("#sellerul-top li").length;
    $("#sellerul-top li").removeClass('seller_active');
    for (var i = 0; i < length1; i++) {
        var href1 = $("#sellerul-top li").eq(i).find('a').attr('href');

        if (stringContaCharacter(url, href1)) {
            $("#sellerul-top li").eq(i).addClass("seller_active");
            $("#sellerurl_top").val(i);
        }
        if ($("#sellerurl_top").val() === i) {
            $("#sellerul-top li").eq(i).addClass("seller_active");
        }
    }


    var html0 = $("#sellermblist-ul li").eq(0).find('a').data('url');
    $("#content").attr('src', html0);
    $("#sellermblist-ul li").eq(0).addClass("mblist-active");
    //二级目录
    $("#sellermblist-ul li").click(function () {
        $("#sellermblist-ul li").removeClass('mblist-active');
        $(this).addClass("mblist-active");
        var html = $(this).find('a').data('url');
        layer.load(1);
        $("#content").attr('src', html);
        layer.closeAll();

    })

})

function accountSettings(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '账号设置',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
/**
 * 退出登录
 * @param {type} obj
 * @returns {undefined}
 */
function accountOut(obj) {
    layer.confirm('确定要退出账号么？', {
        btn: ['确认', '取消']
    }, function () {
        accountOutAjax();
    });
}
function accountOutAjax() {
    ajaxMethods({
        url: 'seller/accountOut/',
        type: 'get',
        data: {},
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
}