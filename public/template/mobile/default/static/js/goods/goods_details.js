var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    loop: true,
//    autoplay: 2000,
    paginationClickable: true,
    //控制左右按钮
    nextEl: '.swiper-button-next', //对应左边按钮类名
    prevEl: '.swiper-button-prev', //对应右边按钮类名
    autoplayDisableOnInteraction: false, //用户操作后不停止

});
isLoginas = true;
$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
    });
    $(".goodsintroducet-auto div").click(function () {
        $(".goodsintroducet-auto div").removeClass('activein');
        $(this).addClass('activein');
        var index = $(this).index();
        $(".goodsintroduce-text div").hide();
        $(".goodsintroduce-text div").eq(index).show();
    });
    $(".goodsyouhui-btn").click(function () {
        if ($(".goodsyhq").is(':hidden')) {
            $(".goodsyhq").show();
            $(".goodsyhq-auto").animate({'bottom': '0%'}, 300);
        }
    });
    $(".goodsyhq-wd").click(function () {
        $(".goodsyhq").hide();
        $(".goodsyhq-auto").animate({'bottom': '-70%'}, 300);
    })


    $(".cart-jian").click(function () {
        var num = $(this).parents('.cart-btnnum').find('.cart-text').val();
        --num;
        if (num < 1) {
            $(this).css({'color': '#ccc'});
            return false;
        }
        $(this).parents('.cart-btnnum').find('.cart-text').val(num);
        $(".goodsnum,#cartnum,#goods_num").text(num);
        $("#goods_num").val(num);
    });
    $(".cart-jia").click(function () {
        $(".cart-jian").css({'color': '#333'});
        var num = $(this).parents('.cart-btnnum').find('.cart-text').val();
        ++num;
        $(this).parents('.cart-btnnum').find('.cart-text').val(num);
        $(".goodsnum,#cartnum").text(num);
        $("#goods_num").val(num);
    });
    $(".cart-text").on('input', function () {
        var inventory = $("#spannshu").text();
        var value = $(this).val();
        if (Number(inventory) < Number(value)) {
            $(this).val(inventory);
            $(".goodsnum,#cartnum").text(inventory);
            $("#goods_num").val(inventory);
        } else if (Number(value) <= 0) {
            $(this).val(1);
            $(".goodsnum,#cartnum").text(1);
            $("#goods_num").val(1);
        } else {
            $(".goodsnum,#cartnum").text(value);
            $("#goods_num").val(value);
        }
    })

    $(".goodguige-btn").click(function () {
        $(".cart-guige").show();
        $(".cart-guige-auto").animate({'top': '24%'});
        var goodsColorId = $("#cartyanse li").eq(0).data('id');
        var goodsId = $("#goods_id").val();
        var activity = $("#activity").val();
        catesList(goodsId, goodsColorId, activity);
    });
    $(".cart-guigeer").click(function () {
        $(".cart-guige").hide();
        $(".cart-guige-auto").animate({'top': '182%'});
        $("#first_member_id").val(0);
        $("#sgm_id").val(0);
    });
    $("#cartyanse li").click(function () {
        var text = $(this).text();
        var goodsColorId = $(this).data('id');
        var goodsId = $("#goods_id").val();
        var activity = $("#activity").val();
        console.log(activity);
        $("#cartyanse li").removeClass('active-lx');
        $(this).addClass('active-lx');
        $(".yansetext").text(text);

        $(".goodsnum,#cartnum").text(1);
        $("#goods_num,.cart-text").val(1);

        catesList(goodsId, goodsColorId, activity);
    });
    var goodsColorId = $("#cartyanse li").eq(0).data('id');
    var goodsId = $("#goods_id").val();
    var activity = $("#activity").val();
    catesList(goodsId, goodsColorId, activity);
    $("#cartbanben").on('click', 'li', function () {
        $("#cartbanben li").removeClass('active-lx');
        $(this).addClass('active-lx');
        var text = $(this).text();
        var cateId = $(this).data('cateid');
        $("#cate_id").val(cateId);
        $(".banbentext").text(text);
        var cate_price = $(this).data('cateprice');
        var inventory = $(this).data('inventory');
        var orgprice = $(this).data('orgprice');
        $("#spannshu").text(inventory);
        $("#spanprice-i").text(cate_price);
        $("#orgprice").text(orgprice);
        $("#goods_price").val(cate_price);
    });
    $(".add_buy").click(function () {
        var type = $(this).data('type');
        var buytype = $(this).data('buytype');
        var setup_norm = $("#setup_norm").val();
        $("#activity").val(buytype);
        if ($(".cart-guige").is(":hidden")) {
            var tops = '24%';
            if (setup_norm == 'off') {
                $(".cart-guigeyx,.cart-yanse").hide();
                var tops = '50%';
            }
            $(".cart-guige").show();
            $(".cart-guige-auto").animate({'top': tops});
            $("#cartyanse li").eq(0).click();
        } else {
            if (!$("#cartbanben li").is('.active-lx') && setup_norm == 'on') {
                layer.msg('请选择版本类型', function () {});
                return false;
            }
            $(this).css({'pointer-events': 'none'});//设置禁止点击
            if (type === 'cart') {//加入购物车
                addCart($(this));
            } else if (type === 'buy') {//购买操作
                if (buytype == 'spell_group') {//拼团购买
                    spellGroupJudge($(this));
                } else if (buytype == 'seconds_kill') {//秒杀购买
                    secondsKillJudge($(this));
                } else if (buytype == 'comdysalesp') {//促销购买
                    comdypJudge($(this));
                } else {//普通购买
                    $("#formsubmit").submit();
                }
            }
        }
        $('#submit_type').val(type);
    });

    $('#givealikeBtn').click(function () {
        $(this).css({'pointer-events': 'none'});//设置禁止点击
        var goodsId = $(this).data('goodsid');
        ajaxMethods({
            url: 'givealike/submitGivealike/',
            type: 'get',
            data: {goods_id: goodsId},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, function () {});
                }
            }
        });
    });
    $(".goodsyhq-lqp").click(function () {
        var copId = $(this).data('copid');
        ajaxMethods({
            url: 'copon_receive/addCoponReceive/',
            type: 'get',
            data: {cop_id: copId},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, function () {});
                }
            }
        });
    });

    $("#socketa").click(function () {
        ajaxMethods({
            url: 'common/isLogin/',
            type: 'get',
            data: {},
            sCallback: function (data) {
                if (data.types === 0) {
                    isLoginas = false;
                }
            }
        });
        if (isLoginas === false) {
            layer.msg("请登录再访问", {icon: 5});
            return;
        }
        var url = $(this).attr('url');
        pageJump(url);
    })

})
function catesList(goodsId, goodsColorId, activity) {
    ajaxMethods({
        url: 'goods/catesList/',
        type: 'get',
        data: {goods_id: goodsId, goodscolor_id: goodsColorId, activity: activity},
        sCallback: function (data) {
            $("#cartbanben li").remove();
            var html = '';
            $.each(data.cates_list, function (index, val) {
                html += '<li class="cart-yanseli" data-orgprice="' + val['orgprice'] + '" data-inventory="' + val['inventory'] + '" data-cateprice="' + val['cate_price'] + '" data-cateid="' + val['cate_id'] + '">' + val['cate_name'] + '</li>';
            });
            $(".cart-guigeimg img").attr('src', staticurl + data.norm_info.default_gallery);
            $("#spanprice-i").text(data.cate_price);
            $("#orgprice").text(data.orgprice);
            $("#spannshu").text(data.inventory);
            $("#goods_price").val(data.cate_price);
            $("#n_id").val(data.norm_info.n_id);
            $("#cartbanben").prepend(html);
        }
    });
}
function spellGroupJudge(obj) {
    var goods_id = $("#goods_id").val();
    var first_member_id = $("#first_member_id").val();
    var sgm_id = $("#sgm_id").val();
    ajaxMethods({
        url: 'spell_group_ordernum/spellGroupJudge',
        type: 'post',
        data: {goods_id: goods_id, first_member_id: first_member_id, sgm_id: sgm_id},
        sCallback: function (data) {
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
            if (data.types === 1) {
                $("#formsubmit").submit();
            } else {
                layer.msg(data.prompt, function () {});
                return false;
            }
        }
    });
}
function comdypJudge(obj) {
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'comdysales_promotion/comdypJudge',
        type: 'get',
        data: {goods_id: goods_id},
        sCallback: function (data) {
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
            if (data.types === 1) {
                $("#formsubmit").submit();
            } else {
                layer.msg(data.prompt, function () {});
                return false;
            }
        }
    });
}
function secondsKillJudge(obj) {
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'seconds_kill/secondsKillJudge',
        type: 'get',
        data: {goods_id: goods_id},
        sCallback: function (data) {
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
            if (data.types === 1) {
                $("#formsubmit").submit();
            } else {
                layer.msg(data.prompt, function () {});
                return false;
            }
        }
    });
}
function addCart(obj) {
    ajaxForm({
        url: 'goods/addCart/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
        }
    });
}
function addCollection(obj) {
    $(obj).css({'pointer-events': 'none'});
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'collection/addCollection',
        type: 'get',
        data: {goods_id: goods_id},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
        }
    });
}

