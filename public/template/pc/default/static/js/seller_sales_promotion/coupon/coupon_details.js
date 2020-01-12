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
    var cop_type = $("#cop_type").val();
    copType(this, cop_type);
})
function copType(obj, cop_type) {
    var value = $(obj).val();
    $("#cptypes_title span").hide();
    $("#cptypes_text input").hide();
    if (value == '1' || cop_type == '1') {
        $("#copgoods_title").show();
        var goods_text = $(".goods_text").val();
        $("#type_text").val(goods_text);
        $("#type_text").attr('disabled', false);

    } else if (value == '2' || cop_type == '2') {
        $("#copstore_title").show();
        $("#type_text").val('本店铺');
        $("#type_text").attr('disabled', true);
    } else {
        $("#copgoods_title").show();
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
        url: "seller_sales_promotion.coupon/getGoodsList",
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
    $("#type_text").val(goodsname);
    $(".goods_id").val(goodsid);
    $(".goodsulclick").hide();
}
function detailsCoupon(obj) {
    ajaxForm({
        type: 'POST',
        url: "seller_sales_promotion.coupon/coupon_details",
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