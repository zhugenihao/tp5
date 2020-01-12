$(function () {
    $("body").on('click', '.guigekc', function () {
        $(".goods_cos").show();
        $(".goods_cos").animate({'opacity': 1}, 300);
        var goods_id = $(this).data('goodsid');
        var goods_name = $(this).parents("tr").find(".goods-names").text();
        $("#goods_name").text("商品名称：" + goods_name);
        getInventoryList(goods_id);
    });
    $(".goodscos_guanbi").click(function () {
        $(".goods_cos").animate({'opacity': 0}, 300);
        setTimeout(function () {
            $(".goods_cos").hide();
        }, 300);
    });
})
function getInventoryList(goods_id) {
    ajaxMethods({
        url: 'inventory/getInventoryList/',
        type: 'get',
        data: {goods_id: goods_id},
        sCallback: function (data) {
            $("#inventorylist tr").remove();
            var html = '';
            $.each(data, function (index, val) {
                html += `<tr class="tbcenter">
                            <td>` + val['id'] + `</td>
                            <td>` + val['color_name'] + `</td>
                            <td>` + val['cate_name'] + `</td>
                            <td>` + val['inty_price'] + `</td>
                            <td>` + val['weight'] + `</td>
                            <td><input type="text" value="` + val['inventory'] + `" oninput="modifyInventory(this,` + val['id'] + `)" size="10" /></td>
                        </tr>`;
            })
            var length = data.length;
            if (length < 1) {
                html = `<tr class="tbcenter"><td colspan="6">暂无数据</td></tr>`;
            }
            $("#inventorylist").prepend(html);
        }
    });
}
function modifyGoodsStock(obj, goods_id) {
    var GoodsStock = $(obj).val();
    layer.load(2);
    ajaxMethods({
        url: 'seller_goods/modifyGoodsStock/',
        type: 'get',
        data: {goods_id: goods_id, goods_stock: GoodsStock},
        sCallback: function (data) {
            layer.closeAll();
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function modifyInventory(obj, inventory_id) {
    var inventory = $(obj).val();
    layer.load(2);
    ajaxMethods({
        url: 'inventory/modifyInventory/',
        type: 'get',
        data: {inventory_id: inventory_id, inventory: inventory},
        sCallback: function (data) {
            layer.closeAll();
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}