$(function () {
    $(".number_title,.heavy_title,.volume_title").hide();
    var billing_way = $("#billing_way option:selected").val();
    if (billing_way == 1) {
        $(".number_title").show();
    } else if (billing_way == 2) {
        $(".heavy_title").show();
    } else if (billing_way == 3) {
        $(".volume_title").show();
    }
    $("#province_id").on('change', function () {
        var province_id = $(this).val();
        regionHtml(province_id, 1);
    })
    $("#city_id").on('change', function () {
        var city_id = $(this).val();
        regionHtml(city_id, 2);
    })
})
function dtionArea(obj) {
    var county_id = $("#county_id option:selected").val();
    var county_text = $("#county_id option:selected").text();
    if (Number(county_id) <= 0) {
        return false;
    }
    var length = $("#dtionarealu li").length;
    for (var i = 0; i < length; i++) {
        var county_id2 = $("#dtionarealu li").eq(i).find('.county_id').val();
        if (Number(county_id) === Number(county_id2)) {
            return false;
        }

    }
    var html = `<li>
                        <span>` + county_text + `</span>
                        <span class="bspanicon" onclick="delDtionArea(this)"><i class="Hui-iconfont">&#xe609;</i></span>
                        <input type="hidden" name="county_id[]" value="` + county_id + `" class="county_id">
                        <input type="hidden" name="county_text[]" value="` + county_text + `" class="county_text">
                    </li>`;
    $("#dtionarealu").append(html);
}
function delDtionArea(obj) {
    $(obj).parents('li').remove();
}
function billingWay(obj) {
    $(".number_title,.heavy_title,.volume_title").hide();
    var value = $(obj).val();
    if (value == '1') {
        $(".number_title").show();
    } else if (value == '2') {
        $(".heavy_title").show();
    } else if (value == '3') {
        $(".volume_title").show();
    }
}

function detailsFreight(obj) {
    var freight_name = $("#freight_name").val();
    if (!trim(freight_name)) {
        layer.msg("运费名称不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_order_logistics.freight/freight_details',
        type: 'post',
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
function regionHtml(id, type) {
    if (Number(id) <= 0) {
        return false;
    }
    ajaxMethods({
        url: 'onethink_district/otDisList/',
        type: 'get',
        data: {upid: id},
        sCallback: function (data) {
            var cityHtml = '<option value="0">请选择市级</option>';
            var countyHtml = '<option value="0">请选择县级</option>';
            if (type === 1) {
                $("#city_id option").remove();
                $("#county_id option").remove();
                $.each(data, function (index, val) {
                    cityHtml += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })

            } else if (type === 2) {
                $("#county_id option").remove();
                $.each(data, function (index, val) {
                    countyHtml += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
            }
            $("#city_id").prepend(cityHtml);
            $("#county_id").prepend(countyHtml);
        }
    });
}