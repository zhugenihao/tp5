$(function () {
    layui.use(['form'], function () {
        var layer = layui.layer;
        $('.member-img').click(function () {
            layer.open({
                type: 1,
                title: false,
                offset: 'auto',
                closeBtn: 0,
                scrollbar: false,
                area: [220 + 'px'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: $('.sas')

            });
        });

    });

})