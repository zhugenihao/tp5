$(function () {
    //加减商品数量
    $(".sorder-jian").click(function () {
        var num = $(this).parents('.sorder-btnnum').find('.sorder-text').val();
        --num;
        if (num < 1) {
            $(this).css({'color': '#ccc'});
            return false;
        }
        var goods_num_all = $("#goods_num_all").val();
        var all_num = Number(goods_num_all) - 1;
        var goods_price = $(this).data('price');
        var cart_id = $(this).data('cartid');
        var cart_total_price = $("#cart_total_price").val();
        var total_price = returnFloat(Number(cart_total_price) - Number(goods_price));
        goodsNumPrice(this, num, all_num, total_price);
        algorithmCartAjax(cart_id, goods_price, num);
    });
    $(".sorder-jia").click(function () {
        $(".sorder-jian").css({'color': '#333'});
        var num = $(this).parents('.sorder-btnnum').find('.sorder-text').val();
        ++num;
        var goods_num_all = $("#goods_num_all").val();
        var all_num = Number(goods_num_all) + 1;
        var goods_price = $(this).data('price');
        var cart_id = $(this).data('cartid');
        var cart_total_price = $("#cart_total_price").val();
        var total_price = returnFloat(Number(cart_total_price) + Number(goods_price));
        goodsNumPrice(this, num, all_num, total_price);
        algorithmCartAjax(cart_id, goods_price, num);
    });
    $("#shouhuoul_btn").click(function (event) {
        event.stopPropagation();
        $("#shouhuoul").show();

    });
    $("#shouhuoul_btn1").click(function (event) {
        event.stopPropagation();
        $("#shouhuoul_1").show();

    });
    $("#shouhuoul_btn2").click(function (event) {
        event.stopPropagation();
        $("#shouhuoul_2").show();

    });
    $(document).click(function (e) {
        var target = $(e.target);
        if (target.closest(".menu_level1").length != 0)
            return;
        $("#shouhuoul,#shouhuoul_1,#shouhuoul_2").hide();
    })
    $("#shouhuoul_1 li").click(function () {
        var text = $(this).text();
        var couId = $(this).data('couid');
        $("#cou_id").val(couId);
        $(".wuliu-text").text(text);
    });
    $(".yoouhui-btn").click(function () {
        var amount = $(this).data('amount');
        var fullamount = $(this).data('fullamount');
        var type = $(this).data('type');
        var type_id = $(this).data('typeid');
        var copon_receive_id = $(this).data('crid');

        //优惠券使用
        var priceArr = [];
        if (type == 1) {//商品优惠券使用
            var priceArr = $(".gprice" + type_id);
        } else if (type == 2) {//商铺优惠券使用
            var priceArr = $(".storeprice" + type_id);
        }
        for (var i = 0; i < priceArr.length; i++) {
            var gprice_one = parseFloat(priceArr[i].value);
            if (fullamount < gprice_one) {
                $("#shouhuoul_2").click();
                var cartid = priceArr[i].attributes.cartid.value;
                var er_copon_receive_id = $("#copon_receive_id" + cartid).val();
                if (er_copon_receive_id > 0) {
                    layer.msg("已使用");
                    return false;
                }
                var sf_goods_price = parseFloat(gprice_one) - parseFloat(amount);

                var goods_num = $("#goods_num" + cartid).val();
                var total_price = sf_goods_price * parseFloat(goods_num);
                var same_price = $("#same_price").val();
                //实付运算
                var sf_all_price = parseFloat(same_price) - (parseFloat(amount) * parseFloat(goods_num));

                var res = algorithmCartAjax(cartid, sf_goods_price, goods_num, copon_receive_id);
                console.log(res);
                if (res == false) {
                    return false;
                }
                $(".goods_price" + cartid).val(sf_goods_price);
                $("#sorder-jiage" + cartid).text("￥" + returnFloat(sf_goods_price));
                $(".sordernum" + cartid).attr('data-price', returnFloat(sf_goods_price));
                $("#total_price" + cartid).val(returnFloat(total_price));
                $("#cart_total_price").val(returnFloat(sf_all_price));
                $(".total_price").text('￥' + returnFloat(sf_all_price));

                $("#youhuiamount").text('');
                $("#youhuiamount").prepend('已选一张可抵￥<span id="amount">' + amount + '</span>');
                $('#copon_receive_id' + cartid).val(copon_receive_id);

                return false;
            }
        }

    });
    $("#shouhuoul li").click(function () {
        var adsId = $(this).data('adsid');
        ajaxMethods({
            url: 'address/getInfo/',
            type: 'get',
            data: {ads_id: adsId},
            sCallback: function (data) {
                var addressnamb = data.ads_name + ' ' + data.ads_mobile;
                $("#addressnamb").text(addressnamb);
                $("#addresstext").text(data.tcgaddress);
                $("#ads_id").val(data.ads_id);
            }
        });
    })
    $(".payall-2auto").click(function () {
        var paytype = $(this).data('paytype');
        $(".payall-2auto").removeClass('paybacg');
        $(this).addClass('paybacg');
        $("#payment_type").val(paytype);
    });
    $("#pay_submit").click(function () {
//        $("#formsubmit").submit();
        paySubmit();
    });
})

function get_goods_num(obj) {
    var goods_num = $(obj).val();
    var goods_stock = $("#goods_stock").text();
    $(".goodsnum,#cartnum").text(goods_num);
    $(".goods_num,#goods_num").val(goods_num);
    if (goods_num <= 0) {
        $(obj).val(1);
        $(".goodsnum,#cartnum").text(1);
        $(".goods_num,#goods_num").val(1);
    }
    if (Number(goods_num) >= Number(goods_stock)) {
        layer.msg('库存不足！', {icon: 5});
        $(obj).val(goods_stock);
        $(".goodsnum,#cartnum").text(goods_stock);
        $(".goods_num,#goods_num").val(goods_stock);
    }
}

function paySubmit() {
    $("#pay_submit").css({'pointer-events': 'none'});//设置禁止点击
    var payment_type = $("#payment_type").val();
    if (payment_type != 'balance') {
        layer.msg("该支付暂未开放！", {icon: 5});
        setTimeout(function () {
            $("#pay_submit").css({'pointer-events': 'auto'});
        }, 2000);
        return;
    }
    ajaxForm({
        url: 'pay/paySubmit/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (data.types === 1) {
                detPayment();
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function detPayment() {
    layer.load(2);
    layer.confirm('确认支付', {
        btn: ['确认', '取消']
    }, function () {
        payUpdate();
    }, function () {
        setTimeout(function () {
            href_url('order/orderlist?type=4');
        }, 1000);
    });
}

function payUpdate() {
    ajaxForm({
        url: 'pay/payUpdate/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('order/orderlist?type=4');
                }, 2000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }


        }
    });
}
function sorderNum(obj) {
    var num = $(obj).parents('.sorder-btnas').find('.goods_num').text();
    $(obj).val(num);
    layer.msg('只能点击加减！', function () {});
}
//商品数量变动
function goodsNumPrice(obj, num, all_num, total_price) {
    var cartid = $(obj).data('cartid');
    $(obj).parents('.sorder-btnnum').find('.sorder-text').val(num);
    $(obj).parents('.sorder-btnas').find('.goods_num').text(num);

    $(".goods_num_all").text(all_num);
    $("#goods_num_all").val(all_num);
    $("#goods_num" + cartid).val(num);
    var goods_price = $(obj).data('price');
    $("#total_price" + cartid).val(returnFloat(goods_price * num));

    $(".total_price").text('￥' + total_price);
    $("#cart_total_price,#same_price").val(total_price);
}
//给卖家留言
function leaveMessage(obj) {
    var text = $(obj).val();
    $("#leave_message").val(text);
}
var isreturn = true;
function algorithmCartAjax(cart_id, goods_price, num, copon_receive_id) {
    ajaxMethods({
        url: 'cart/algorithmCart/',
        type: 'get',
        data: {cart_id: cart_id, goods_num: num, goods_price: goods_price, copon_receive_id: copon_receive_id},
        sCallback: function (data) {
            if (data.types === 1) {
            } else {
                layer.msg(data.prompt, {icon: 5});
                isreturn = false;
            }

        }
    });
    return isreturn;
}