var form = '';
layui.use(['form', 'flow', 'layedit', 'laydate'], function () {
    form = layui.form,
            flow = layui.flow;

    //表单初始赋值
    form.val('example', {
        "like[write]": true //复选框选中状态
    })
    //全选
    form.on('checkbox(c_all)', function (data) {
        var a = data.elem.checked;

        if (a == true) {
            $(".cart_id").prop("checked", true);
            form.render('checkbox');
            var cartidarr = $('.cart_id');
            var all_goods_num2 = 0;
            var all_cart_price2 = 0;
            var all_courier_price2 = 0;
            for (var i = 0; i < cartidarr.length; i++) {
                var cart_id = cartidarr[i].value;
                var goods_num = $("#goods_nums" + cart_id).val();
                var all_goods_num = Number(goods_num);
                var total_price = $(".total_price" + cart_id).val();
                var all_cart_price = Number(total_price);

                var courier_price = $(".courier_price" + cart_id).val();
                var all_courier_price = Number(courier_price);

                all_goods_num2 += all_goods_num;
                all_cart_price2 += all_cart_price;
                all_courier_price2 += all_courier_price;
            }
//            console.log(all_goods_num2);
            var all_cart_price2 = returnFloat(all_cart_price2);
            var all_courier_price2 = returnFloat(all_courier_price2);
            $(".goods_num_all").text(all_goods_num2);
            $("#cart_price").text(all_cart_price2);
            $("#courier_price_all").text(all_courier_price2);
        } else {
            $(".cart_id").prop("checked", false);
            form.render('checkbox');
            $("#cart_price").text('0.00');
            $("#courier_price_all").text('0.00');
            $(".goods_num_all").text(0);
        }
    });
    form.on('checkbox(c_one)', function (data) {
        var a = data.elem.checked;
        var cart_id = data.value;
        var goods_num = $("#goods_nums" + cart_id).val();
        var goods_price = $("#goods_prices" + cart_id).val();
        var total_price = $(".total_price" + cart_id).val();
        var courier_price = $(".courier_price" + cart_id).val();
        var cart_price = $("#cart_price").text();
        var courier_price_all = $("#courier_price_all").text();
        var goods_num_all = $(".goods_num_all").text();

        console.log(cart_price);
        if (a !== true) {
            $("#c_all").prop("checked", false);
            form.render('checkbox');
            var all_cart_price = returnFloat(Number(cart_price) - Number(total_price));
            $("#cart_price").text(all_cart_price);
            var all_goods_num = Number(goods_num_all) - Number(goods_num);
            $(".goods_num_all").text(all_goods_num);
            var all_courier_price = returnFloat(Number(courier_price_all) - Number(courier_price));
            $("#courier_price_all").text(all_courier_price);
        } else {
            var all_cart_price = returnFloat(Number(cart_price) + Number(total_price));
            $("#cart_price").text(all_cart_price);
            var all_goods_num = Number(goods_num_all) + Number(goods_num);
            $(".goods_num_all").text(all_goods_num);
            var all_courier_price = returnFloat(Number(courier_price_all) + Number(courier_price));
            $("#courier_price_all").text(all_courier_price);
        }
    });
    flow.load({
        elem: '#rolling-list' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                cartList(page, next);
            }, 100);
        }
    });
});
$(function () {
    $(".goods-guige").click(function () {
        $(".goods_cos").show();
        $(".goods_cos").animate({'opacity': 1}, 300);
        var n_id = $(this).data('nid');
        var goods_id = $(this).data('goodsid');
        var cart_id = $(this).data('cartid');
        normList(goods_id, n_id, cart_id);
    });
    $(".goodscos_guanbi").click(function () {
        $(".goods_cos").animate({'opacity': 0}, 300);
        setTimeout(function () {
            $(".goods_cos").hide();
        }, 300);
    });
    $(".cart-jian").click(function () {
        var num = $(this).parents('.goodsnum-text').find('.cart-text').val();
        --num;
        if (num < 1) {
            $(this).css({'color': '#ccc'});
            return false;
        }
        $(this).parents('.goodsnum-text').find('.cart-text').val(num);
        $(".goodsnum").text(num);
        $("#goods_num,.goods_one_num").val(num);
        var goods_num = $(".goods_one_num").val();
        var price = $(".goods_one_price").val();
        $(".total_one_price").val(returnFloat(price * goods_num));
    });
    $(".cart-jia").click(function () {
        var goods_num = $(".goods_one_num").val();
        var price = $(".goods_one_price").val();
        var goods_stock = $("#goods_stock").text();
        if (Number(goods_num) >= Number(goods_stock)) {
            layer.msg('库存不足！', {icon: 5});
            return;
        }
        $(".cart-jian").css({'color': '#333'});
        var num = $(this).parents('.goodsnum-text').find('.cart-text').val();
        ++num;
        $(this).parents('.goodsnum-text').find('.cart-text').val(num);
        $(".goodsnum").text(num);
        $("#goods_num,.goods_one_num").val(num);

        $(".total_one_price").val(returnFloat(price * goods_num));

    });


    $("#rolling-list").on('click', '.cart-qita', function () {
        $(".cart-guige").show();
        $(".cart-guige-auto").animate({'top': '24%'});
        var n_id = $(this).data('nid');
        var goods_id = $(this).data('goodsid');
        var cart_id = $(this).data('cartid');
        normList(goods_id, n_id, cart_id);
        var html = $("#cartyanse").html();
        $("#cartyanse li").eq(0).click();
    });
    $("#goodscolor_click").on('click', 'a', function () {
        $("#goodscolor_click a").removeClass('gcolor_active');
        $(this).addClass('gcolor_active');
        var text = $(this).text();
        $(".yansetext").text(text);
        var goods_id = $(this).data('goodsid');
        var goodscolor_id = $(this).data('goodscolorid');
        var cart_id = $(this).data('cartid');
        catesList(goods_id, goodscolor_id, cart_id);
    });


    $("#cartbanben").on('click', 'a', function () {
        $("#cartbanben a").removeClass('gcolor_active');
        $(this).addClass('gcolor_active');
        var text = $(this).text();
        $(".banbentext").text(text);
        var cate_id = $(this).data('cateid');
        $(".cate_one_id").val(cate_id);
        var inventory = $(this).data('inventory');
        $(".inventory,#goods_stock").text(inventory);
        var price = $(this).data('cateprice');
        $(".cart-guigejiage").text('￥' + returnFloat(price));
        $(".goods_one_price").val(price);
        var goods_num = $(".goods_one_num").val();
        $(".total_one_price").val(price * goods_num);
    });
})


function catesList(goods_id, goodscolor_id, cart_id) {
    $("#cartbanben div").remove();
    ajaxMethods({
        url: 'cart/catesList/',
        type: 'get',
        data: {goods_id: goods_id, goodscolor_id: goodscolor_id, cart_id: cart_id},
        sCallback: function (data) {
            var cates_html = '';
            $.each(data.cate_list, function (index, vals) {
                var gcolor_active = '';
                if (index === 0) {
                    var gcolor_active = 'gcolor_active';
                }
                cates_html += `<div>
                                    <a href="javascript:;" data-inventory="` + vals['inventory'] + `" data-cateprice="` + vals['cate_price'] + `" class="cart-yanseli ` + gcolor_active + `" data-cateid="` + vals['cate_id'] + `">` + vals['cate_name'] + `</a>
                                </div>`;
            });
            $("#cartbanben").prepend(cates_html);
            $("#goods_stock").text(data.inventory);
            var cate_id0 = data.cate_list[0] ? data.cate_list[0].cate_id : 0;
            $(".cate_one_id").val(cate_id0);
            $(".n_one_id").val(data.norm_info.n_id);
            var price = data.cate_price ? data.cate_price : '0.00';
            $(".goods_gkp_p").text('￥' + returnFloat(price));
            $(".small-img img").attr('src', staticurl + data.norm_info.default_gallery);
            if (data.cate_list[0]) {
                $(".goods_one_price").val(data.cate_list[0].cate_price);
                var goods_num = $(".goods_one_num").val();
                $(".total_one_price").val(data.cate_list[0].cate_price * goods_num);
            }

        }
    });
}

function normList(goods_id, n_id, cart_id) {
    $("#goodscolor_click div,#cartbanben div").remove();
    ajaxMethods({
        url: 'cart/normList/',
        type: 'get',
        data: {goods_id: goods_id, n_id: n_id, cart_id: cart_id},
        sCallback: function (data) {
            var goods_color_html = '';
            var cates_html = '';
            var cart_info = data.cart_info;
            $.each(data.goods_color_list, function (index, val) {
                var gcolor_active = '';
                if (index === 0) {
                    var gcolor_active = 'gcolor_active';
                }
                goods_color_html += '<div><a href="javascript:;" class="active-lx ' + gcolor_active + '" data-cartid="' + cart_id + '" data-goodsid="' + goods_id + '" data-goodscolorid="' + val['id'] + '">' + val['color_name'] + '</a></div>';
            });
            $.each(data.cates_list, function (index, val) {
                var gcolor_active = '';
                if (index === 0) {
                    var gcolor_active = 'gcolor_active';
                }
                cates_html += `<div>
                                    <a href="javascript:;" data-cateprice="` + val['cate_price'] + `" class="cart-yanseli ` + gcolor_active + `" data-cateid="` + val['cate_id'] + `">` + val['cate_name'] + `</a>
                                </div>`;
            });
            $("#goodscolor_click").prepend(goods_color_html);
            $("#cartbanben").prepend(cates_html);
            $("#goods_stock").text(data.inventory);

            $(".yansetext").text(cart_info.color_name);
            $(".banbentext").text(cart_info.cate_name);
            $(".goodsnum").text(cart_info.goods_num);
            $(".cart-text").val(cart_info.goods_num);
            var cates_info0 = data.cates_list[0];

            var goods_num = $(".goods_one_num").val();
            if (cates_info0) {
                $(".total_one_price").val(cates_info0.cate_price * goods_num);
                $(".goods_one_price").val(cates_info0.cate_price);
                $(".cate_one_id").val(cates_info0.cate_id);
            }


            $(".cart_one_id").val(cart_id);
            $(".n_one_id").val(n_id);

            $(".goods_one_num").val(cart_info.goods_num);


            $(".small-img img").attr('src', staticurl + data.norm_info.default_gallery);
            var price = data.cate_price ? data.cate_price : '0.00';
            $(".goods_gkp_p").text('￥' + returnFloat(price));
        }
    });
}

function cartCancel(obj) {
    $(".goodscos_guanbi").click();
}

function cartJian(obj) {
    var num = $(obj).parents('.cart-btnnum').find('.cgoods_num').val();
    --num;
    if (num < 1) {
        $(obj).css({'color': '#ccc'});
        return false;
    }
    $(obj).parents('.cart-btnnum').find('.cgoods_num').val(num);
    var cart_id = $(obj).data('cartid');
    algorithmCartAjax(cart_id, num, 'jian');

}
function cartJia(obj) {
    $(obj).parents('.cart-btnnum').find('.goods_num_jian').css({'color': '#333'});
    var num = $(obj).parents('.cart-btnnum').find('.cgoods_num').val();
    ++num;
    $(obj).parents('.cart-btnnum').find('.cgoods_num').val(num);
    var cart_id = $(obj).data('cartid');
    algorithmCartAjax(cart_id, num, 'jia');
}
function algorithmCartAjax(cart_id, num, algorithm) {
    ajaxMethods({
        url: 'cart/algorithmCart/',
        type: 'get',
        data: {cart_id: cart_id, goods_num: num},
        sCallback: function (data) {
            var cart = data.content;
            if (data.types === 1) {
                $("#goods_nums" + cart_id).val(num);
                $("#total_price" + cart_id).text("￥" + cart.total_price);
                $(".total_price" + cart_id).val(cart.total_price);
                $(".courier_price" + cart_id).val(cart.courier_price);
                $("#courier_price_all").text('0.00');
                $("#cart_price").text('0.00');
                $(".goods_num_all").text(0);
                $("input:checkbox").each(function () {
                    $(this).prop("checked", false);
                });
                form.render('checkbox');
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function get_goods_num(obj) {
    var goods_num = $(obj).val();
    var goods_stock = $("#goods_stock").text();
    $(".goodsnum").text(goods_num);
    $(".goods_one_num").val(goods_num);
    var price = $(".goods_one_price").val();
    $(".total_one_price").val(returnFloat(price * goods_num));
    if (goods_num <= 0) {
        $(obj).val(1);
        $(".goodsnum").text(1);
        $(".goods_one_num").val(1);
        $(".total_one_price").val(returnFloat(price));
    }
    if (Number(goods_num) >= Number(goods_stock)) {
        layer.msg('库存不足！', {icon: 5});
        $(obj).val(goods_stock);
        $(".goodsnum").text(goods_stock);
        $(".goods_one_num").val(goods_stock);
        $(".total_one_price").val(returnFloat(price * goods_stock));
    }
}