$(function () {
    layui.use(['form'], function () {
        var layer = layui.layer;
        $('.member-photo').click(function () {
            layer.open({
                type: 1,
                title: false,
                offset: 'auto',
                closeBtn: 0,
                scrollbar: false,
                area: [420 + 'px'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: $('.sas')
            });
        });
    });
})
/*更新缓存*/
function updatesCache() {
    layer.confirm('确认要更新缓存吗？', function (index) {
        ajaxMethods({
            type: 'POST',
            url: "seller_common/updatesCache/",
            data: {},
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
}