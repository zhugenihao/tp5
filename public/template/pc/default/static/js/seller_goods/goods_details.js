var g1y_num = 9;
var no_num = 1;
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

                $(this).text("立即编辑");
            } else if (is_showdiv == '2') {
                editGoods();
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
        addInventory(no_num);
        var dir3_id = $("#directory_id").val();
        catesList(dir3_id, no_num);

        no_num++;
    })

    $("#add_goodsimg").click(function () {
        var goods_id = $("#goods_id").val();
        ajaxMethods({
            url: 'gallery/addGallery/',
            type: 'get',
            data: {goods_id: goods_id},
            sCallback: function (data) {
                var gallery_id = data.content;
                var html = `<li class="goodsimg-li">
                        <form class="gallery_from" action="" name="gallery_from` + gallery_id + `">
                            <div class="goodsimg-auto">

                                <img src="" class="fileimg_g1y` + g1y_num + `"/>
                                <label class="fileimg-btn goodsimgbtn" for="g1y` + g1y_num + `">选择文件</label>
                                <input class="" onchange="editGallery(this, ` + gallery_id + `)" id="g1y` + g1y_num + `" style="display: none;" name="gallery" type="file"/>
                                <input type="hidden" value="` + gallery_id + `" name="gallery_id" />

                            </div>
                        </form>
                        <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)" data-galleryid="` + gallery_id + `">
                            <i class="Hui-iconfont" title="删除">&#xe609;</i>
                        </a>
                    </li>`;
                g1y_num++;
                $("#goodsimg_list").prepend(html);
            }
        })
    })
    $("body").on('click', '.nduotu', function () {
        $(".goods_cos").show();
        $(".goods_cos").animate({'opacity': 1}, 300);
        getGallery(this);
    });
    $(".goodscos_guanbi").click(function () {
        $(".goods_cos").animate({'opacity': 0}, 300);
        setTimeout(function () {
            $(".goods_cos").hide();
        }, 300);
    });
    $("#goodsbens-ul2").on('click', 'li', function () {
        var gallery_id = $(this).data('galleryid');
        if ($(this).is(".duotu_act")) {
            $(this).removeClass("duotu_act");
            $(this).find('#ngallery_id').val('');
        } else {
            $(this).addClass("duotu_act");
            $(this).find('#ngallery_id').val(gallery_id);
        }
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
    var billing_way = $(".billing_way").val();
    if (Number(billing_way) > 1) {
        $("#billing_num").show();
    } else {
        $("#billing_num").hide();
    }
})
function cartCancel(obj) {
    $(".goodscos_guanbi").click();
}
function gimgDela(obj) {
    $(obj).parents('li').remove();
    var gallery_id = $(obj).data('galleryid');
    ajaxMethods({
        url: 'gallery/delGallery/',
        type: 'get',
        data: {gallery_id: gallery_id},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    })
}
var in_num = $("#norm_lists tr").length;
function addInventory(no_num) {
    var goods_id = $("#goods_id").val();

    ajaxMethods({
        url: 'inventory/addInventory/',
        type: 'get',
        data: {goods_id: goods_id},
        sCallback: function (data) {
            if (data.types === 1) {
                in_num++;
                layer.msg(data.prompt, {icon: 1});
                var html = `<tr class="tbcenter" id="tbcenter_` + no_num + `">
                                <td>` + in_num + `</td>
                                <td>
                                    <select name="goodscolor[]" class="goodscolor_list" onchange="editInventory(this,` + data.content + `, 'goodscolor_id')">
                                        <option value="0">请选颜色</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="cates[]" class="cates_list" onchange="editInventory(this,` + data.content + `, 'cate_id')">
                                        <option value="0">请选版本</option>
                                    </select>
                                </td>
                                <td><input type="text" class="inty_price" value="0.00" name="inty_price[]" size="10" onchange="editInventory(this,` + data.content + `, 'inty_price')"/></td>
                                <td><input type="text" class="orgprice" value="0.00" name="orgprice[]" size="10" onchange="editInventory(this,` + data.content + `, 'orgprice')"/></td>
                                <td><input type="text" class="inventory" value="10" name="inventory[]" size="10" onchange="editInventory(this,` + data.content + `, 'inventory')"/></td>
                                <td>
                                    <select name="type[]" onchange="editInventory(this,` + data.content + `,'type')">
                                        <option value="0">请选择</option>
                                        <option value="1">重量(kg)</option>
                                        <option value="2">体积(立方米)</option>
                                    </select>
                                </td>
                                <td><input type="text" class="type_num" value="0.00" name="type_num[]" size="10" onchange="editInventory(this,` + data.content + `, 'type_num')"/></td>
                                <td><input type="text" class="sort" value="10" size="10" onchange="editInventory(this,` + data.content + `, 'sort')"/></td>
                                <td>
                                    <input type="hidden" value="` + data.content + `" name="inventory_id[]" />
                                    <a href="javascript:;" data-inventoryid="` + data.content + `" class="nduotu">多图</a>
                                    <a href="javascript:;" data-inventoryid="` + data.content + `" onclick="delInventory(this)" >删除</a>
                                </td>
                            </tr>`;
                $("#norm_lists").append(html);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    })
}
function editInventory(obj, inventory_id, type) {
    layer.load(2);
    var text = $(obj).val();
    var data = [];
    if (type == 'inty_price') {
        var data = {inventory_id: inventory_id, type: type, inty_price: text}
    }
    if (type == 'orgprice') {
        var data = {inventory_id: inventory_id, type: type, orgprice: text};
    }
    if (type == 'inventory') {
        var data = {inventory_id: inventory_id, type: type, inventory: text};
    }
    if (type == 'type_num') {
        var data = {inventory_id: inventory_id, type: type, type_num: text};
    }
    if (type == 'type') {
        var data = {inventory_id: inventory_id, type: type, type_i: text};
    }
    if (type == 'sort') {
        var data = {inventory_id: inventory_id, type: type, sort: text};
    }
    if (type == 'cate_id') {
        var data = {inventory_id: inventory_id, type: type, cate_id: text};
    }
    if (type == 'goodscolor_id') {
        var data = {inventory_id: inventory_id, type: type, goodscolor_id: text};
    }
    ajaxMethods({
        url: 'inventory/editInventory/',
        type: 'get',
        data: data,
        sCallback: function (data) {
            layer.closeAll();
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    })
}
function delInventory(obj) {
    layer.load(2);
    $(obj).parents('tr').remove();
    var inventory_id = $(obj).data("inventoryid");
    ajaxMethods({
        url: 'inventory/delInventory/',
        type: 'get',
        data: {inventory_id: inventory_id},
        sCallback: function (data) {
            layer.closeAll();
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    })
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
function catesList(dirId, no_num) {
    ajaxMethods({
        url: 'seller_goods/catesList/',
        type: 'get',
        data: {dir_id: dirId},
        sCallback: function (data) {
            $("#tbcenter_" + no_num).find(".cates_list option").remove();
            $("#tbcenter_" + no_num).find(".goodscolor_list option").remove();
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
            $("#tbcenter_" + no_num).find(".cates_list").prepend(catesHtml);
            $("#tbcenter_" + no_num).find(".goodscolor_list").prepend(goodsColorHtml);
        }
    });
}
function editGoods() {
    var goods_name = $("#goods_name").val();
    var goods_price = $("#goods_price").val();
    var goods_stock = $("#goods_stock").val();
    var region = $("#region").val();
    if (!trim(goods_name) || !trim(goods_price) || !trim(goods_stock) || !trim(region)) {
        layer.msg("必填项缺一不可!", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_goods/editGoods/',
        type: 'post',
        formName: 'fabu_from',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    returnOnPageReload();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function editGallery(obj, gallery_id) {
    ajaxForm({
        url: 'gallery/editGallery/',
        type: 'post',
        formName: 'gallery_from' + gallery_id,
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                $(obj).parents('.gallery_from').find('img').attr('src', staticurl + data.content);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function getGallery(obj) {
    var goods_id = $("#goods_id").val();
    var inventory_id = $(obj).data('inventoryid');
    $("#inventory2_id").val(inventory_id);
    ajaxMethods({
        url: 'gallery/getGallery/',
        type: 'get',
        data: {goods_id: goods_id, inventory_id: inventory_id},
        sCallback: function (data) {
            var html = '';
            $("#goodsbens-ul2 li").remove();
            $.each(data, function (index, val) {
                var duotu_act = '';
                if (val['is_there'] === 1) {
                    var duotu_act = 'duotu_act';
                }
                html += `<li class="goodsimg-li2 ` + duotu_act + `" data-galleryid="` + val['gallery_id'] + `">
                            <div class="goodsimg-auto">
                                <img src="` + files_url(val['img_big']) + `" class="img_big">
                            </div>
                            <input type="hidden" value="" name="ngallery_id[]" id="ngallery_id" />
                        </li>`;
            })
            $("#goodsbens-ul2").prepend(html);
        }
    })
}
function submitDuotu(obj) {
    ajaxForm({
        url: 'gallery/submitGallery/',
        type: 'post',
        formName: 'gallery_from2',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                cartCancel(obj);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
