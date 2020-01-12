$(function () {
    layui.use(['carousel', 'form'], function () {
        var carousel = layui.carousel
                , form = layui.form;

        carousel.render({
            elem: '#test3'
            , width: '1200px'
            , height: '300px'
            , interval: 4000
        });
        //事件
        carousel.on('change(test4)', function (res) {
            console.log(res)
        });
    });
})
