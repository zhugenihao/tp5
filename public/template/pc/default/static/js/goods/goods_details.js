function _magnifiers() {
    var magnifierConfig = {
        magnifier: "#magnifier1", //最外层的大容器
        width: 500, //承载容器宽
        height: 500, //承载容器高
        moveWidth: null, //如果设置了移动盒子的宽度，则不计算缩放比例
        zoom: 5//缩放比例
    };

    var _magnifier = magnifier(magnifierConfig);
    console.log(_magnifier);
    /*magnifier的内置函数调用*/
    /*
     //设置magnifier函数的index属性
     _magnifier.setIndex(1);
     
     //重新载入主图,根据magnifier函数的index属性*/
//     _magnifier.eqImg();

}
$(function () {
    var goodsColorId = $("#goodscolor_click div a").eq(0).data('id');
    var goodsId = $("#goods_id").val();
    var activity = $("#activity").val();
    catesList(goodsId, goodsColorId, activity);
    $("#goodsulimg li").hover(function () {
        var src = $(this).find('img').attr('src');
        $("#goodsOneimg").attr('src', src);
        $("#goodsOneimg").attr('rel', src);
    });
    _magnifiers();


    $(".goodsdetails_title div").click(function () {
        var index = $(this).index();
        $(".goodsdetails_title div").removeClass('gdtitle_active');
        $(this).addClass('gdtitle_active');
        $(".goodstext_list").removeClass('show');
        $(".goodstext_list").eq(index).addClass('show');
    });

    $("body").on('click', '.goodspl_img div', function () {
        var goodspl_text = $(this).parents('.goodspl_text');
        var src = $(this).find('img').attr('src');
        var index = $(this).index();
        if (goodspl_text.find('.goodspl_big').is(":hidden")) {
            goodspl_text.find('.goodspl_big').show(300);
            goodspl_text.find('.goodspl_bigshow img').attr('src', src);
            goodspl_text.find('.goodspl_big').attr('lpiindex', index);
        } else {
            goodspl_text.find('.goodspl_big').hide(300);
        }

    })
    $("body").on('click', '.goodspl_left', function () {
        var goodspl_text = $(this).parents('.goodspl_text');
        var index = $(this).parents('.goodspl_big').attr('lpiindex');
        if (index > 0) {
            --index;
            $(this).parents('.goodspl_big').attr('lpiindex', index);
            var src = goodspl_text.find(".goodspl_img div").eq(index).find('img').attr('src');
            $(this).prevAll('.goodspl_bigshow').find('img').attr('src', src);
        }
    });
    $("body").on('click', '.goodspl_right', function () {
        var goodspl_text = $(this).parents('.goodspl_text');
        var index = $(this).parents('.goodspl_big').attr('lpiindex');
        var length = $(this).parents('.goodspl_text').find('.goodspl_img div').length;
        ++index;
        if (index < length) {
            $(this).parents('.goodspl_big').attr('lpiindex', index);
            var src = goodspl_text.find(".goodspl_img div").eq(index).find('img').attr('src');
            $(this).prevAll('.goodspl_bigshow').find('img').attr('src', src);
        }
    });

    $("#goodscolor_click div a").click(function () {

        $("#goodscolor_click div a").removeClass('gcolor_active');
        $(this).addClass('gcolor_active');
        var text = $(this).text();
        var goodsColorId = $(this).data('id');
        var goodsId = $("#goods_id").val();
        var activity = $("#activity").val();
        console.log(activity);
        $("#cartyanse li").removeClass('active-lx');
        $(this).addClass('active-lx');
        $(".yansetext").text(text);
        catesList(goodsId, goodsColorId, activity);
    });

    $("#cartbanben").on('click', 'a', function () {
        $("#cartbanben div a").removeClass('gcolor_active');
        $(this).addClass('gcolor_active');
        var text = $(this).text();
        var cateId = $(this).data('cateid');
        $("#cate_id").val(cateId);
        $(".banbentext").text(text);
        var cate_price = $(this).data('cateprice');
        var inventory = $(this).data('inventory');
        var orgprice = $(this).data('orgprice');
        $("#spannshu").text(inventory);
        $("#spanprice").text(cate_price);
        $("#orgprice").text(orgprice);
        $("#goods_price").val(cate_price);
    });

    //加减商品数量
    $(".goods_num_jian").click(function () {
        var num = $('.goods_num').val();
        --num;
        if (num < 1) {
            $(this).css({'color': '#ccc'});
            return false;
        }
        $(".goodsnum,#cartnum,#goods_num").text(num);
        $(".goods_num,#goods_num").val(num);
    });
    $(".goods_num_jia").click(function () {
        $(".goods_num_jian").css({'color': '#333'});
        var num = $('.goods_num').val();
        var goods_stock = $("#goods_stock").text();
        if (Number(num) >= Number(goods_stock)) {
            layer.msg('库存不足！', {icon: 5});
            return;
        }
        ++num;
        $(".goodsnum,#cartnum").text(num);
        $(".goods_num,#goods_num").val(num);
    });
    //操作
    $(".add_buy a").click(function () {
        var type = $(this).data('type');
        var buytype = $(this).data('buytype');
        var setup_norm = $("#setup_norm").val();
        $("#activity").val(buytype);

        if (!$("#cartbanben a").is('.gcolor_active') && setup_norm == 'on') {
            layer.msg('请选择版本类型！', {icon: 5});
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
                console.log(33);
                isLogin();
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
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
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
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });
    commentsList(1, 10);
    layui.use(['laypage', 'layer'], function () {
        var laypage = layui.laypage
                , layer = layui.layer;
        //完整功能
        var comscount = $("#comscount").data('comscount');
        laypage.render({
            elem: 'comments-page'
            , count: comscount
            , layout: ['count', 'prev', 'page', 'next', 'limit', 'refresh', 'skip']
            , jump: function (obj) {
                console.log(obj)
                commentsList(obj.curr, obj.limit);
            }
        });
    });

})
function catesList(goodsId, goodsColorId, activity) {
    ajaxMethods({
        url: 'goods/catesList/',
        type: 'get',
        data: {goods_id: goodsId, goodscolor_id: goodsColorId, activity: activity},
        sCallback: function (data) {
            $("#cartbanben div,#gallery_list li").remove();
            var html = '';
            var gallery_html = '';
            $.each(data.cates_list, function (index, val) {
                html += '<div><a href="javascript:;" class="cart-yanseli" data-orgprice="' + val['orgprice'] + '" data-inventory="' + val['inventory'] + '" data-cateprice="' + val['cate_price'] + '" data-cateid="' + val['cate_id'] + '">' + val['cate_name'] + '</div></a>';
            });
            $.each(data.norm_info.gallery_list, function (index, val2) {
                if (index === 0) {
                    $(".magnifier-container img").attr('src', files_url(val2['img_big']));
//                    $(".magnifier-container img").css({'left': '0px'});
                }
                gallery_html += `<li>
                                    <div class="small-img">
                                        <img src="` + files_url(val2['img_small']) + `" bigimg="` + files_url(val2['img_big']) + `"/>
                                    </div>
                                </li>`;
            });
            $("#gallery_list").prepend(gallery_html);
            $(".clearfix").css({'left': '0px'});
            $("#spanprice").text(data.cate_price);
            $("#orgprice").text(data.orgprice);
            $("#spannshu").text(data.inventory);
            $("#goods_price").val(data.cate_price);
            $("#n_id").val(data.norm_info.n_id);
            $("#cartbanben").prepend(html);
        }
    });
}
//异步获取数据
function commentsList(page, limit) {
    var number = limit;
    var start = number * (page - 1);
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'comments/index/',
        type: 'get',
        data: {start: start, limit: number, goods_id: goods_id},
        sCallback: function (data) {
            commentsHtml(data.list, data['mid']);
        }
    });
}
function commentsHtml(data, mid) {
    var html = '';
    $("#comments-list li").remove();
    $.each(data, function (i, v) {
        html += `<li class="goodspl_li">
                        <div class="goodspl_top">
                            <div class="goodspl_photo">
                                <img src="` + files_url(v['member']['photo']) + `"/>
                            </div>
                            <div class="goodspl_uname">` + v['member']['member_name'] + `</div>
                            <div class="goodspl_ts">
                                <div class="goodspl_time">` + v['create_time'] + `</div>
                                ` + aDelHtml(v['m_id'], mid, v['id']) + `
                            </div>
                        </div>
                        <div class="goodspl_text">
                            <div class="goodspl_cont">` + v['texts'] + `</div>
                            <div class="goodspl_img">
                                ` + commentsImg(v['comments_img']) + `
                            </div>
                            <div class="goodspl_big" lpiindex="0">
                                <div class="goodspl_bigshow"><img src="" /></div>
                                <div href="javascript:;" class="goodspl_left"><i class="Hui-iconfont">&#xe6d4;</i></div>
                                <div href="javascript:;" class="goodspl_right"><i class="Hui-iconfont">&#xe6d7;</i></div>
                            </div>
                        </div>
                    </li>`;
    });
    $("#comments-list").prepend(html);
}
function aDelHtml(cmid, mid, commid) {
    console.log(cmid + ',' + mid + ',' + commid);
    var html = '';
    if (cmid === mid) {
        var html = `<div class="goodspl_sc" onclick="commentsDel(this)" data-comid="` + commid + `">
                        <a href="javascript:;">删除</a>
                    </div>`;
    }
    return html;
}
function commentsImg(data) {
    var html = '';
    $.each(data, function (i, imgv) {
        html += '<div data-src="' + files_url(imgv['img_url']) + '">';
        html += '<img src="' + files_url(imgv['img_url']) + '"/>';
        html += '</div>';
    });
    return html;
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
                layer.msg(data.prompt, {icon: 5});
                return false;
            }
        }
    });
}
function isLogin(obj) {
    ajaxMethods({
        url: 'common/isLogin/',
        type: 'get',
        data: {},
        sCallback: function (data) {
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
            if (data.types === 1) {
                $("#formsubmit").submit();
            } else {
                layer.msg(data.prompt, {icon: 5});
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
                layer.msg(data.prompt, {icon: 5});
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
                layer.msg(data.prompt, {icon: 5});
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
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
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
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
        }
    });
}
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
function commentsDel(obj) {
    layer.confirm('你确定要删除这条评论么？', {
        btn: ['确认', '取消']
    }, function (index) {
        console.log(222);
        commentsDelAjax(obj);
    });
}
function commentsDelAjax(obj) {
    var comid = $(obj).data('comid');
    ajaxMethods({
        url: 'comments/commentsDel/',
        type: 'get',
        data: {comid: comid},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
var isLoginas = true;
function kefuUrl(obj) {

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
    var url = $(obj).attr('url');
    layer.open({
        type: 2,
        fixed: false, //不固定
        title: '在线客服',
        shadeClose: true,
        shade: 0.2,
        maxmin: true,
        area: ['700px', '700px'],
        content: url //iframe的url
    });
}