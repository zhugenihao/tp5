$(function () {
    layui.use(['carousel', 'form'], function () {
        var carousel = layui.carousel
                , form = layui.form;
        carousel.render({
            elem: '#advert_pc'
            , arrow: 'always'
            , width: '1000px'
            , height: '300px'
            , interval: 4000
        });
        carousel.render({
            elem: '#advert_mobile'
            , arrow: 'always'
            , width: '700px'
            , height: '300px'
            , interval: 4000
        });
        //事件
        carousel.on('change(advert)', function (res) {
            console.log(res);
        });
        var layer = layui.layer;
        $('.yulianimg').click(function () {
            var id = $(this).data('id');
            var title = $(this).data('title');
            layer.open({
                type: 1,
                title: title,
                offset: '100px',
                closeBtn: 1,
                scrollbar: false,
                area: ['500px', '700px'],
                skin: 'layui-layer-rim', //没有背景色
                shadeClose: false,
                content: $('.tlpimgw_' + id)

            });
        });

    });
    $(".shanchuimg").click(function () {
        var index = $(this).parents('li').index();
        var type = $(this).data('type');
        var find_class = '';
        if (index === 0) {
            var find_class = "input[name='advert1']";
        } else if (index === 1) {
            var find_class = "input[name='advert2']";
        } else if (index === 2) {
            var find_class = "input[name='advert3']";
        } else if (index === 3) {
            var find_class = "input[name='advert4']";
        } else if (index === 4) {
            var find_class = "input[name='advert5']";
        }
        console.log(index);
        if (type == 'mobile') {
            $("#imglist-ul2 li").eq(index).find(find_class).val('');
            $("#imglist-ul2 li").eq(index).find('img').attr('src', '');
        } else {
            $("#imglist-ul li").eq(index).find(find_class).val('');
            $("#imglist-ul li").eq(index).find('img').attr('src', '');
        }


    })
})
/**
 * 店铺设置
 * @param {type} obj
 * @returns {undefined}
 */
function storeModify(obj) {
    var store_name = $("#store_name").val();
    if (!trim(store_name)) {
        layer.msg("店铺名称不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_store.store/storeModify/',
        type: 'post',
        formName: 'store_from',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
/**
 * 电脑幻灯片修改
 * @param {type} obj
 * @returns {undefined}
 */
function advertPcModify(obj) {
    ajaxForm({
        url: 'seller_store.store/advertPcModify/',
        type: 'post',
        formName: 'advert_pc_from',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
/**
 * 手机幻灯片修改
 * @param {type} obj
 * @returns {undefined}
 */
function advertMobileModify(obj) {
    ajaxForm({
        url: 'seller_store.store/advertMobileModify/',
        type: 'post',
        formName: 'advert_mobile_from',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function templateUse(obj) {
    var tpl_id = $(obj).data('id');
    layer.confirm('确定要使用该模板么？', {
        btn: ['确认', '取消']
    }, function () {
        layer.load(2);
        ajaxMethods({
            url: 'seller_store.store/templateUse/',
            type: 'get',
            data: {tpl_id: tpl_id},
            sCallback: function (data) {
                layer.closeAll();
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
}
