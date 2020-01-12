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
    $("#cart-jian").click(function () {
        var num = $(this).parents('.cart-btnnum').find('#cart-text').val();
        --num;
        if (num < 1) {
            $(this).css({'color': '#ccc'});
            return false;
        }
        $(this).parents('.cart-btnnum').find('#cart-text').val(num);
        $(".goodsnum").text(num);
        $("#goods_num,.goods_one_num").val(num);
        var goods_num = $(".goods_one_num").val();
        var price = $(".goods_one_price").val();
        $(".total_one_price").val(returnFloat(price * goods_num));
    });
    $("#cart-jia").click(function () {
        $("#cart-jian").css({'color': '#333'});
        var num = $(this).parents('.cart-btnnum').find('#cart-text').val();
        ++num;
        $(this).parents('.cart-btnnum').find('#cart-text').val(num);
        $(".goodsnum").text(num);
        $("#goods_num,.goods_one_num").val(num);
        var goods_num = $(".goods_one_num").val();
        var price = $(".goods_one_price").val();
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
    $(".cart-guigeer").click(function () {
        $(".cart-guige").hide();
        $(".cart-guige-auto").animate({'top': '182%'});
    });
    $("#cartyanse").on('click', 'li', function () {
        $("#cartyanse li").removeClass('active-lx');
        $(this).addClass('active-lx');
        var text = $(this).text();
        $(".yansetext").text(text);
        var goods_id = $(this).data('goodsid');
        var goodscolor_id = $(this).data('goodscolorid');
        var cart_id = $(this).data('cartid');
        catesList(goods_id, goodscolor_id, cart_id);
    });


    $("#cartbanben").on('click', 'li', function () {
        $("#cartbanben li").removeClass('active-lx');
        $(this).addClass('active-lx');
        var text = $(this).text();
        $(".banbentext").text(text);
        var cate_id = $(this).data('cateid');
        $(".cate_one_id").val(cate_id);
        var inventory = $(this).data('inventory');
        $(".inventory").text(inventory);
        var price = $(this).data('cateprice');
        $(".cart-guigejiage").text('￥' + returnFloat(price));
        $(".goods_one_price").val(price);
        var goods_num = $(".goods_one_num").val();
        $(".total_one_price").val(price * goods_num);
    });
})


function catesList(goods_id, goodscolor_id, cart_id) {
    $("#cartbanben li").remove();
    ajaxMethods({
        url: 'cart/catesList/',
        type: 'get',
        data: {goods_id: goods_id, goodscolor_id: goodscolor_id, cart_id: cart_id},
        sCallback: function (data) {
            var cates_html = '';
            $.each(data.cate_list, function (index, vals) {
                var active_lx = '';
                if (index === 0) {
                    var active_lx = 'active-lx';
                }
                cates_html += '<li data-inventory="' + vals['inventory'] + '" data-cateprice="' + vals['cate_price'] + '" class="cart-yanseli ' + active_lx + '" data-cateid="' + vals['cate_id'] + '" >' + vals['cate_name'] + '</li>';
            });
            $("#cartbanben").prepend(cates_html);
            $(".inventory").text(data.inventory);
            var cate_id0 = data.cate_list[0] ? data.cate_list[0].cate_id : 0;
            $(".cate_one_id").val(cate_id0);
            $(".n_one_id").val(data.norm_info.n_id);
            var price = data.cate_price ? data.cate_price : '0.00';
            $(".cart-guigejiage").text('￥' + returnFloat(price));
            $(".cart-guigeimg img").attr('src', staticurl + data.norm_info.default_gallery);
            if (data.cate_list[0]) {
                $(".goods_one_price").val(data.cate_list[0].cate_price);
                var goods_num = $(".goods_one_num").val();
                $(".total_one_price").val(data.cate_list[0].cate_price * goods_num);
            }

        }
    });
}

function normList(goods_id, n_id, cart_id) {
    $("#cartyanse li,#cartbanben li").remove();
    ajaxMethods({
        url: 'cart/normList/',
        type: 'get',
        data: {goods_id: goods_id, n_id: n_id, cart_id: cart_id},
        sCallback: function (data) {
            var goods_color_html = '';
            var cates_html = '';
            var cart_info = data.cart_info;
            $.each(data.goods_color_list, function (index, val) {
                var active_lx = '';
                if (index === 0) {
                    var active_lx = 'active-lx';
                }
                goods_color_html += '<li class="cart-yanseli ' + active_lx + '" data-cartid="' + cart_id + '" data-goodsid="' + goods_id + '" data-goodscolorid="' + val['id'] + '">' + val['color_name'] + '</li>';
            });
            $.each(data.cates_list, function (index, val) {
                var active_lx = '';
                if (index === 0) {
                    var active_lx = 'active-lx';
                }
                cates_html += '<li data-cateprice="' + val['cate_price'] + '" class="cart-yanseli ' + active_lx + '" data-cateid="' + val['cate_id'] + '" >' + val['cate_name'] + '</li>';
            });
            $("#cartyanse").prepend(goods_color_html);
            $("#cartbanben").prepend(cates_html);
            $(".inventory").text(data.inventory);

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


            $(".cart-guigeimg img").attr('src', staticurl + data.norm_info.default_gallery);
            var price = data.cate_price ? data.cate_price : '0.00';
            $(".cart-guigejiage").text('￥' + returnFloat(price));
        }
    });
}

function cartCancel(obj) {
    $(".cart-guigeer").click();
}

//异步获取数据
function cartList(page, next) {
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'cart/cartList/',
        type: 'get',
        data: {start: start, limit: number},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = cartListHtml(data.list);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10
            form.val('example', {
                "like[write]": true //复选框选中状态
            })
        }
    });
}
function cartListHtml(data) {
    var list = [];
    $.each(data, function (index, val) {
        var activity_html = '';
        var setup_norm_html = '<p style="height:20px;"></p>';
        if (val['setup_norm'] != 'off') {
            var setup_norm_html = `<div class="cart-qita" data-nid="` + val['n_id'] + `" data-goodsid="` + val['goods_id'] + `" data-cartid="` + val['cart_id'] + `">
                                        <p class="cart-qitagg floatleft">规格:` + val['color_name'] + val['cate_name'] + `</p>
                                        <p class="cart-qger floatright"><i class="Hui-iconfont">&#xe6d7;</i></p>
                                    </div>`;
        }
        if (val['activity'] == 'seconds_kill') {
            var activity_html = '<div class="activitycart">秒杀商品</div>';
        } else if (val['activity'] == 'spell_group') {
            var activity_html = '<div class="activitycart">拼团商品</div>';
        } else if (val['activity'] == 'comdysalesp') {
            var activity_html = '<div class="activitycart">促销商品</div>';
        }
        var html = `<li class="cart-li">
                            ` + activity_html + `
                            <div class="cart-lidiv layui-form-item">
                                <div class="cart-input">
                                    <input type="checkbox" name="cartid[]" value="` + val['cart_id'] + `" lay-skin="primary" lay-filter="c_one" class="cart_id"/>
                                </div>
                                <div class="cart-imgas">
                                    <div class="cart-img">
                                        <a href="` + module + 'goods/goods_details?goods_id=' + val['goods_id'] + `" >
                                            <img src="` + staticurl + val['goods_img'] + `" />
                                        </a>
                                    </div>
                                    <p>某某旗舰店</p>
                                </div>
                                <div class="cart-title">
                                    <div class="cart-textas">
                                        <a href="` + module + 'goods/goods_details?goods_id=' + val['goods_id'] + `" >` + val['goods_name'] + `</a>
                                    </div>
                                    <div class="cart-jiage">￥` + val['goods_price'] + `
                                        <a href="#" class="cartdel floatright" data-cartid="` + val['cart_id'] + `" onclick="delCart(this)">删除</a>
                                    </div>
                                    ` + setup_norm_html + `
                                    <div class="cart-btnas floatfalse">
                                        <div class="cart-num floatleft">数量：<span class="cgoods_num1">` + val['goods_num'] + `</span></div>
                                        <div class="cart-btnnum floatright">
                                            <input type="button" value="-" name="cart-jian" class="cart-jian" onclick="cartJian(this)" data-cartid="` + val['cart_id'] + `"/>
                                            <input type="text" value="` + val['goods_num'] + `" name="cart-text" class="cart-text cgoods_num" />
                                            <input type="button" value="+" name="cart-jia" class="cart-jia" onclick="cartJia(this)" data-cartid="` + val['cart_id'] + `"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="` + val['goods_num'] + `" id="goods_nums` + val['cart_id'] + `" />
                            <input type="hidden" value="` + val['goods_price'] + `" id="goods_prices` + val['cart_id'] + `" />
                            <input type="hidden" value="` + val['total_price'] + `" class="total_price` + val['cart_id'] + `" />
                            <input type="hidden" value="` + val['courier_price'] + `" class="courier_price` + val['cart_id'] + `" />
                    </li>`;
        list.push(html);
    });
    return list;
}

function cartJian(obj) {
    var num = $(obj).parents('.cart-btnnum').find('.cgoods_num').val();
    --num;
    if (num < 1) {
        $(obj).css({'color': '#ccc'});
        return false;
    }
    $(obj).parents('.cart-btnas').find('.cgoods_num').val(num);
    $(obj).parents('.cart-btnas').find('.cgoods_num1').text(num);
    var cart_id = $(obj).data('cartid');
    algorithmCartAjax(cart_id, num, 'jian');

}
function cartJia(obj) {
    var num = $(obj).parents('.cart-btnnum').find('.cgoods_num').val();
    ++num;
    $(obj).parents('.cart-btnas').find('.cgoods_num').val(num);
    $(obj).parents('.cart-btnas').find('.cgoods_num1').text(num);
    var cart_id = $(obj).data('cartid');
    algorithmCartAjax(cart_id, num, 'jia');
}
function algorithmCartAjax(cart_id, num, algorithm) {
    var goods_price = $("#goods_prices" + cart_id).val();
    ajaxMethods({
        url: 'cart/algorithmCart/',
        type: 'get',
        data: {cart_id: cart_id, goods_num: num, goods_price: goods_price},
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