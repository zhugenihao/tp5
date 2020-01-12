$(function () {
    layui.use(['form', 'flow'], function () {
        form = layui.form,
                flow = layui.flow;
        var typeclassif = $("#typeclassif").val();
        var dir_id = $("#dir_id").val();
        goodsListFlow('all', '', {typeclassif: typeclassif, dir_id: dir_id});
    })

    $(".anniu-one").click(function () {
        var time = 300;
        if ($(".anniu-ul").is(":hidden")) {
            $(".anniu-ul").show();
            $(".anniuli1").stop().animate({'top': '-115px', 'right': '5px'}, time);
            $(".anniuli2").stop().animate({'top': '-90px', 'right': '55px'}, time);
            $(".anniuli3").stop().animate({'top': '-35px', 'right': '55px'}, time);
            $('.anniu-one i').eq(0).hide();
            $('.anniu-one i').eq(1).show();
        } else {
            $(".anniuli1").stop().animate({'top': '-60px', 'right': '0px'}, time);
            $(".anniuli2").stop().animate({'top': '-60px', 'right': '0px'}, time);
            $(".anniuli3").stop().animate({'top': '-60px', 'right': '0px'}, time);
            setTimeout(function () {
                $(".anniu-ul").hide();
            }, 400);
            $('.anniu-one i').eq(0).show();
            $('.anniu-one i').eq(1).hide();
        }
    });
    $(".goodsalltop-ul li").click(function () {
        $(".goodsalltop-ul li").removeClass('activeall');
        $(this).addClass('activeall');
        var type = $(this).data('type');
        if (type == 'screening')
            return false;
        $("#goods_listul").remove();
        $("#goods_alldiv").append('<ul class="tejiayouhui-ul" id="goods_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            var typeclassif = $("#typeclassif").val();
            var dir_id = $("#dir_id").val();
            goodsListFlow(type, '', {typeclassif: typeclassif, dir_id: dir_id});
        });
    });
    $(".anniuli2").click(function () {
        if ($(".tejiayouhui-li").is('.goodslistcss')) {
            $(".tejiayouhui-li").removeClass('goodslistcss');
            $(".anniuli2 i").eq(0).show();
            $(".anniuli2 i").eq(1).hide();
        } else {
            $(".tejiayouhui-li").addClass('goodslistcss');
            $(".anniuli2 i").eq(0).hide();
            $(".anniuli2 i").eq(1).show();
        }
    });
    $(".goodssxtop-btn").click(function () {
        $(".goodssx").show();
        $(".goodssx-text").stop().animate({'right': '0%'});
    });
    $(".goodssx-bacg,.goodssx-btn1").click(function () {
        $(".goodssx").hide();
        $(".goodssx-text").stop().animate({'right': '-70%'});
    });
    $(".goodssxli1 div").click(function () {
        if ($(this).hasClass('goods_soucolor')) {
            $(this).removeClass('goods_soucolor');
            $("#highandlow").val('');
        } else {
            $(".goodssxli1 div").removeClass('goods_soucolor');
            $(this).addClass('goods_soucolor');
            var type = $(this).data('type');
            $("#highandlow").val(type);
        }
    });
    $(".goodssxli3 div").click(function () {
        if ($(this).hasClass('goods_soucolor')) {
            $(this).removeClass('goods_soucolor');
            $("#pricesegment").val('');
        } else {
            $(".goodssxli3 div").removeClass('goods_soucolor');
            $(this).addClass('goods_soucolor');
            var price = $(this).data('price');
            $("#pricesegment").val(price);
        }
    });

    $(".goodssx-btn2").click(function () {
        var highandlow = $("#highandlow").val();
        var price_low = $("#theinputprice").attr('low');
        var price_high = $("#theinputprice").attr('high');
        var pricesegment = $("#pricesegment").val();
        var typeclassif = $("#typeclassif").val();
        var dir_id = $("#dir_id").val();
        var goods_data = {highandlow: highandlow, price_low: price_low, price_high: price_high, pricesegment: pricesegment
            , typeclassif: typeclassif, dir_id: dir_id};
        $("#goods_listul").remove();
        $("#goods_alldiv").append('<ul class="tejiayouhui-ul" id="goods_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            goodsListFlow('screening', '', goods_data);
        });
        $(".goodssx-bacg").click();
    });

})
function lowInput(obj) {
    var value = $(obj).val();
    $("#theinputprice").attr('low', value);
}
function highInput(obj) {
    var value = $(obj).val();
    console.log(value);
    $("#theinputprice").attr('high', value);
}
function goodsListFlow(type, search, goods_data) {
    flow.load({
        elem: '#goods_listul' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                goodsList(page, next, type, search, goods_data);
            }, 100);
            console.log(type);
        }
    });
}
//异步获取数据
function goodsList(page, next, type, search, goods_data) {
    
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'goods/goods_all/',
        type: 'get',
        data: {type: type, start: start, limit: number, search: search, goods_data},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = goodsListHtml(data.list);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10

        }
    });
}
function goodsListHtml(data) {
    var list = [];
    $.each(data, function (index, val) {
        var arrangement1 = $(".anniuli2 i").eq(1);
        if (!arrangement1.is(':hidden')) {
            var classtext = 'goodslistcss';
        } else {
            var classtext = '';
        }
        var html = `<li class="tejiayouhui-li ` + classtext + ` ">
                        <a href="` + tp5_url('goods/goods_details?goods_id=' + val['goods_id']) + `">
                            <div class="tejiayouhui-img"><img src="` + files_url(val['thecover']) + `" /></div>
                            <div class="goodslistright">
                                <div class="tejiayouhui-title">` + val['goods_name'] + `</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥` + val['goods_price'] + `</span>
                                    <span class="tejiayouhui-xl">` + val['number_payment'] + `人付款</span>
                                </div>
                            </div>
                        </a>
                        <div class="border-botm floatfalse"></div>
                    </li>`;
        list.push(html);
    });
    return list;
}