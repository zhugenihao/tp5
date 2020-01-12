
$(function () {
    var content = $("#content2").text();
    var go_type = $("#content2").attr('go_type');
    if (go_type == 'goods') {
        var content = goodsHtml(content);
    } else if (go_type == 'order') {
        var content = orderHtml(content);
    } else {
        var content = replaceContent(content);
    }
    $("#content2").html(content);
})
function goodsHtml(data) {
    var goods = JSON.parse(data);
    var html = `<div class="mallzdiv-auto">
                    <a href="` + goods.url + `" target="_blank">
                        <div class="mallzdiv-img">
                            <img src="` + goods.thecover + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name2">` + goods.goods_name + `</div>
                            <div class="color-red">单价：￥<span>` + goods.goods_price + `</span></div>
                        </div>
                    </a>
                </div>`;
    return html;
}

function orderHtml(data) {
    var order = JSON.parse(data);
    console.log(order);
    var html = `<div class="mallzdiv-auto">
                        <div class="mallzdiv-img">
                            <img src="` + order.goods_img + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name2">订单：` + order.order_no + `</div>
                            <div class="color-red">实付：￥<span>` + order.total_price + `</span></div>
                        </div>
                </div>`;
    return html;
}
function detailsSubmit(obj) {
    ajaxForm({
        url: 'seller_kefu.kefu_chat/kefu_chat_details/',
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
