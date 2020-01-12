layui.use('laydate', function () {
    laydate = layui.laydate;
    //日期时间选择器
    laydate.render({
        elem: '#start_time1'
        , type: 'datetime'
    });
    laydate.render({
        elem: '#end_time1'
        , type: 'datetime'
    });

});
$(function () {
//    $("#start_time2,#end_time2").hide();
})
function cpType(obj) {
    var value = $(obj).val();
    $("#cptypes_title span").hide();
    $("#cptypes_text input").hide();
    if (value == '1') {
        $("#discount_title,#discount").show();
    } else if (value == '2') {
        $("#cpprice_title,#cp_price").show();
    } else {
        $("#discount_title,#discount").show();
    }
}
function goodsList(obj) {
    var goodsulclick = $(".goodsulclick");
    var goodsulclickli = $(".goodsulclick li");
    goodsulclick.show();
    goodsulclickli.remove();
    var goods_where = $(obj).val();
    ajaxMethods({
        type: 'get',
        url: "seller_sales_promotion.comdysales_promotion/getGoodsList",
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
function detailsComdsption(obj) {
    ajaxForm({
        type: 'POST',
        url: "seller_sales_promotion.comdysales_promotion/comdsption_details",
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