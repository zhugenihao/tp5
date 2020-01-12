$(function () {
    var contenttb_length = $("#content-tb .content_div").length;
    for (var i = 0; i < contenttb_length; i++) {
        var content = $("#content-tb .content_div").eq(i).text();
        var go_type = $("#content-tb .content_div").eq(i).attr('go_type');
        if (go_type == 'goods') {
            var content = goodsHtml(content);
        } else if (go_type == 'order') {
            var content = orderHtml(content);
        } else {
            var content = replaceContent(content);
        }
        $("#content-tb .content_div").eq(i).html(content);
    }
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
function del(obj) {
    var id = $(obj).data('id');
    var id_all = id ? id : getChecked();
    if (!trim(id_all)) {
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_kefu.kefu_chat/del/',
            type: 'post',
            data: {id_str: id_all},
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
function details(obj) {
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        title: '聊天记录详情',
        shadeClose: true,
        shade: 0.2,
        area: ['600px', '500px'],
        content: url //iframe的url
    });
}
