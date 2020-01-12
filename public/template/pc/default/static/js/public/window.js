$(function () {
    $(".windowcos_guanbi").click(function () {
        $(".window_cos").animate({'opacity': 0}, 300);
        setTimeout(function () {
            $(".window_cos").hide();
        }, 300);
    });
});
/**
 * 弹窗
 * @param {type} list
 * @returns {undefined}
 */
function shopWindow(list){
    $(list.selector).click(function () {
        $(".window_cos").show();
        $(".windowcos_auto2").css({'height':list.height});
        $(".windowcos_det").css({'height':list.height,'top':list.top});
        $(".windowcos_auto").css({'width':list.width,'height':list.height});
        $(".window-text1").css({'height':list.height});
        $(".window_cos").animate({'opacity': 1}, 300);
        list.sCallback && list.sCallback(this);
    });
}