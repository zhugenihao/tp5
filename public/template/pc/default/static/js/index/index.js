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
            console.log(res);
        });
    });
    $(".categlist-li").hover(function () {
        $(this).find('.categlister-ul').show();
    }, function () {
        $(this).find('.categlister-ul').hide();
    })
    
    secondsKillCurrent();
    window.setInterval(secondsKillCurrent, 5000);
})



function secondsKillCurrent() {
    $(".miaosa-list p").text("正在加载中...");
    ajaxMethods({
        url: 'index/secondsKillCurrent/',
        type: 'get',
        data: {},
        sCallback: function (data) {
            secondsKillCurrentHtml(data);
        }
    });
}
function secondsKillCurrentHtml(data) {
    var html = '';
    $("#test-times span").remove();
    $("#miaosaul li").remove();
    $.each(data.list, function (index, val) {
        html +=`<li class="miaosha-li">
                    <a href="` + tp5_url('goods/goods_details?goods_id=' + val['goods_id']+'&activity=seconds_kill') + `">
                        <div class="miaosha-img">
                            <img src="` + files_url(val['thecover']) + `"/>
                        </div>
                        <div class="miaosha-xjiage">￥` + val['sk_price'] + `</div>
                        <div class="miaosha-yjiage">￥` + val['goods_price'] + `</div>
                    </a>
                </li>`;
    });
    $("#test-times").prepend('<span>当前秒杀：<em>' + data.shours + '点抢杀</em></span>');
    $("#miaosaul p").text("");
    if(data.list==''){
        $("#miaosaul p").text("暂无秒杀");
    }
    $("#miaosaul").prepend(html);
}