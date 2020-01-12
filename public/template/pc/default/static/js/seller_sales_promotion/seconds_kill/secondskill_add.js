layui.use('laydate', function () {
    laydate = layui.laydate;
    //日期时间选择器
    laydate.render({
        elem: '#start_time1'
        , type: 'time'
    });
    laydate.render({
        elem: '#end_time1'
        , type: 'time'
    });

});
$(function () {
    $("#start_time2,#end_time2").hide();
})
function goodsList(obj) {
    var goodsulclick = $(".goodsulclick");
    var goodsulclickli = $(".goodsulclick li");
    goodsulclick.show();
    goodsulclickli.remove();
    var goods_where = $(obj).val();
    ajaxMethods({
        type: 'get',
        url: "seller_sales_promotion.seconds_kill/getGoodsList",
        data: {'goods_where': goods_where},
        sCallback: function (data) {
            var html = '';
            $.each(data, function (index, val) {
                html += ' <li data-goodsid="' + val['goods_id'] + '" onClick="goodsulli(this)">￥' + val['goods_price'] + '，' + val['goods_name'] + '</li>';
            })
            goodsulclick.append(html);
        }
    });
}
function goodsulli(obj) {
    var goodsid = $(obj).data('goodsid');
    var goodsname = $(obj).text();
    $("#goods_id").val(goodsname);
    $(".goods_id").val(goodsid);
    $(".goodsulclick").hide();
}
function everyDay(obj) {
    var value = $(obj).val();
    if (value == 1) {
        $("#start_time2,#end_time2").remove();
        var startHtml = '<input type="text" value="" name="start_time" class="mall_input" id="start_time1" placeholder="HH:mm:ss" size="40">';
        var endHtml = '<input type="text" value="" name="end_time" class="mall_input" id="end_time1" placeholder="HH:mm:ss" size="40">';
        $("#start_timediv").prepend(startHtml);
        $("#end_timediv").prepend(endHtml);
        laydate.render({
            elem: '#start_time1'
            , type: 'time'
        });
        laydate.render({
            elem: '#end_time1'
            , type: 'time'
        });
    } else {
        $("#start_time1,#end_time1").remove();
        var startHtml = '<input type="text" value="" name="start_time" class="mall_input" id="start_time2" placeholder="yyyy-MM-dd HH:mm:ss" size="40">';
        var endHtml = '<input type="text" value="" name="end_time" class="mall_input" id="end_time2" placeholder="yyyy-MM-dd HH:mm:ss" size="40">';
        $("#start_timediv").prepend(startHtml);
        $("#end_timediv").prepend(endHtml);
        laydate.render({
            elem: '#start_time2'
            , type: 'datetime'
        });
        laydate.render({
            elem: '#end_time2'
            , type: 'datetime'
        });
    }
}
function addSecondskill(obj) {
    ajaxForm({
        type: 'POST',
        url: "seller_sales_promotion.seconds_kill/secondskill_add",
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    returnOnPage();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}