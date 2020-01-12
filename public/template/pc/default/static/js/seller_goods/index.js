var g1y_num = 9;
$(function () {
    $("#directory1 li").click(function () {
        var dir1_id = $(this).data('dir1id');
        $("#directory1 li").removeClass('goodscat_active');
        $(this).addClass('goodscat_active');
        goodsBuscategory({type: 'directory1_id', directory1_id: dir1_id}, 1);
        $("#directory1_name").text($(this).text());
        $("#directory2_name").text('');
        $("#directory3_name").text('');
        $(".goods_btn").removeClass('goodsbtn_act');
    })
    $("#directory2").on('click', 'li', function () {
        var dir2_id = $(this).data('dir2id');
        $("#directory2 li").removeClass('goodscat_active');
        $(this).addClass('goodscat_active');
        goodsBuscategory({type: 'directory2_id', directory2_id: dir2_id}, 2);
        $("#directory2_name").text($(this).text());
        $("#directory3_name").text('');
        $(".goods_btn").removeClass('goodsbtn_act');
    })
    $("#directory3").on('click', 'li', function () {
        var dir3_id = $(this).data('dir3id');
        $("#directory3 li").removeClass('goodscat_active');
        $(this).addClass('goodscat_active');
        $("#directory3_name").text($(this).text());
        $(".goods_btn").addClass('goodsbtn_act');
        $("#directory_id").val(dir3_id);
        catesList(dir3_id);
    })
    getKindEditor('#description');
    getKindEditor('#parameter');
    $("#goodsbtn_under1").click(function () {
        var directory1_name = $("#directory1_name").text();
        var directory2_name = $("#directory2_name").text();
        var directory3_name = $("#directory3_name").text();
        var is_showdiv = $("#is_showdiv").val();
        if (trim(directory1_name) && trim(directory2_name) && trim(directory3_name)) {
            console.log(323);
            if (is_showdiv == '1') {
                $("#is_showdiv").val(2);
                $("#goods_title2,#goods_title3").addClass('fabu_active');
                $("#goods-cate").hide();
                $("#goods-details").removeClass('goodsdetails-act');

                $(this).text("立即发布");
            } else if (is_showdiv == '2') {
                addGoods();
            }
        }

    })

    $("#goodsbtn_on1").click(function () {
        var is_showdiv = $("#is_showdiv").val();
        if (is_showdiv == '2') {
            $("#is_showdiv").val(1);
            $("#goods_title2,#goods_title3").removeClass('fabu_active');
            $("#goods-cate").show();
            $("#goods-details").addClass('goodsdetails-act');
            $("#goodsbtn_under1").text("下一步，商品详情");
        }
    })
    $("#detailstitle div").click(function () {
        $("#detailstitle div").removeClass("detls-act");
        $(this).addClass("detls-act");
        var index = $(this).index();
        $(".detlstext-one").hide();
        $(".detlstext-one").eq(index).show();
    })
    $("#add_norm").click(function () {
        var tr_length = $("#norm_lists tr").length;
        if (tr_length >= 10) {
            layer.msg("最多只能添加10个规格", {icon: 5});
            return false;
        }
        var html = `<tr class="tbcenter">
                        <td>2</td>
                        <td>
                            <select name="goodscolor[]" class="goodscolor_list">
                                <option value="0">请选颜色</option>
                            </select>
                        </td>
                        <td>
                            <select name="cates[]" class="cates_list">
                                <option value="0">请选版本</option>
                            </select>
                        </td>
                        <td><input type="text" value="10.00" class="inty_price" name="inty_price[]" size="10"/></td>
                        <td><input type="text" value="10.00" class="orgprice" name="orgprice[]" size="10"/></td>
                        <td><input type="text" value="10" class="inventory" name="inventory[]" size="10"/></td>
                        <td>
                            <select name="type[]">
                                <option value="0">请选择</option>
                                <option value="1">重量(kg)</option>
                                <option value="2">体积(立方米)</option>
                            </select>
                        </td>
                        <td><input type="text" value="10.00" class="type_num" name="type_num[]" size="10"/></td>
                        <td><input type="text" value="10" class="sort" name="sort[]" size="10"/></td>
                        <td>
                            <a href="javascript:;" onclick="delNorm(this)">删除</a>
                        </td>
                    </tr>`;
        $("#norm_lists").append(html);
        var dir3_id = $("#directory_id").val();
        catesList(dir3_id);
    })

    $("#add_goodsimg").click(function () {

        var html = `<li class="goodsimg-li">
                        <div class="goodsimg-auto">
                            <img src="" class="fileimg_g1y` + g1y_num + `"/>
                            <label class="fileimg-btn goodsimgbtn" for="g1y` + g1y_num + `">选择文件</label>
                            <input class="" onchange="getPhoto(this, 'g1y` + g1y_num + `', 140, 140)" id="g1y` + g1y_num + `" style="display: none;" name="gallery[]" type="file">
                        </div>
                        <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)">
                            <i class="Hui-iconfont" title="删除">&#xe609;</i>
                        </a>
                    </li>`;
        g1y_num++;
        $("#goodsimg_list").append(html);
    })
    $("#billing_num").hide();
    $(".billing_way").on('change', function () {
        var value = $(this).val();
        if (Number(value) > 1) {
            $("#billing_num").show();
        } else {
            $("#billing_num").hide();
        }
    })

})
function gimgDela(obj) {
    $(obj).parents('li').remove();
}
function delNorm(obj) {
    $(obj).parents('tr').remove();
}
function goodsBuscategory(data, type) {
    ajaxMethods({
        url: 'business_category/goodsBuscategory/',
        type: 'get',
        data: data,
        sCallback: function (data) {
            var html = '';
            if (type === 1) {
                $("#directory2 li").remove();
                $("#directory3 li").remove();
                $.each(data, function (index, val) {
                    html += '<li data-dir2id="' + val['directory2_id'] + '">' + val['directory2_name'] + '</li>';
                })
                $("#directory2").prepend(html);
            } else if (type === 2) {
                $("#directory3 li").remove();
                $.each(data, function (index, val) {
                    html += '<li data-dir3id="' + val['directory3_id'] + '">' + val['directory3_name'] + '</li>';
                })
                $("#directory3").prepend(html);
            }
        }
    });
}
function catesList(dirId) {
    ajaxMethods({
        url: 'seller_goods/catesList/',
        type: 'get',
        data: {dir_id: dirId},
        sCallback: function (data) {
            $(".cates_list option,.goodscolor_list option").remove();
            var catesHtml = '<option value="0">请选版本</option>';
            var cates_list = data.content.cates_list;
            $.each(cates_list, function (index, val) {
                catesHtml += `<option value="` + val['cate_id'] + `">` + val['cate_name'] + `</option>`;
            })
            var goodsColorHtml = '<option value="0">请选颜色</option>';
            var goods_color_list = data.content.goods_color_list;
            $.each(goods_color_list, function (index, val) {
                goodsColorHtml += `<option value="` + val['id'] + `">` + val['color_name'] + `</option>`;
            })
            $(".cates_list").prepend(catesHtml);
            $(".goodscolor_list").prepend(goodsColorHtml);
        }
    });
}
function addGoods() {
    var goods_name = $("#goods_name").val();
    var goods_price = $("#goods_price").val();
    var goods_stock = $("#goods_stock").val();
    var region = $("#region").val();
    if (!trim(goods_name) || !trim(goods_price) || !trim(goods_stock) || !trim(region)) {
        layer.msg("必填项缺一不可!", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_goods/addGoods/',
        type: 'post',
        formName: 'fabu_from',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('seller_goods/sell_list?top=3&type=2');
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
