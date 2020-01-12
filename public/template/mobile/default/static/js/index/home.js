var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    loop: true,
    autoplay: 2000,
    paginationClickable: true,
    //控制左右按钮
    nextEl: '.swiper-button-next', //对应左边按钮类名
    prevEl: '.swiper-button-prev', //对应右边按钮类名
    autoplayDisableOnInteraction: false, //用户操作后不停止

});
layui.use(['util', 'laydate', 'layer'], function () {
    var util = layui.util
            , laydate = layui.laydate
            , layer = layui.layer;

    //倒计时
    var thisTimer, setCountdown = function (y, M, d, H, m, s) {
        var endTime = new Date(y, M || 0, d || 1, H || 0, m || 0, s || 0) //结束日期
                , serverTime = new Date(); //假设为当前服务器时间，这里采用的是本地时间，实际使用一般是取服务端的
        console.log(serverTime);
        clearTimeout(thisTimer);
        util.countdown(endTime, serverTime, function (date, serverTime, timer) {
            var str = '时间(当前秒杀)：' + date[0] + '天' + date[1] + '时' + date[2] + '分' + date[3] + '秒';
            lay('#test-time').html(str);
            thisTimer = timer;
        });
    };
    setCountdown(2019, 4 - 1, 16);

});
$(function () {
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
        html += `<li class="miaosa-listli">
                    <a href="` + tp5_url('goods/goods_details?goods_id=' + val['goods_id']+'&activity=seconds_kill') + `">
                        <div class="miaosa-img">
                            <img src="` + files_url(val['thecover']) + `" />
                        </div>
                        <div class="miaosa-jiage">￥` + val['sk_price'] + `</div>
                        <div class="miaosa-yuanjia">￥` + val['goods_price'] + `</div>
                    </a>
                </li>`;
    });
    $("#test-times").prepend('<span>当前秒杀：<em>' + data.shours + '点抢杀</em></span>');
    $(".miaosa-list p").text("");
    if(data.list==''){
        $(".miaosa-list p").text("暂无秒杀");
    }
    $("#miaosaul").prepend(html);
}