var form = '';
$(function () {
    layui.use('flow', function () {
        flow = layui.flow;
        secondsKillCurrentFlow('');
    });

    $("#secondstime").on('click', 'li', function () {
        var index = $(this).index();
        $("#secondstime li").removeClass('active-sec');
        $(this).addClass('active-sec');
        var left = Number(index * 100) - 130;
        $(".seconds-top").stop().animate({'scrollLeft': left}, 500);

        var hours = $(this).data('time');
        $("#rolling-list").remove();
        $("#rolling-listdiv").append('<ul class="secondscont-ul" id="rolling-list"></ul>');
        setTimeout(function () {
            layui.use(['form', 'flow'], function () {//重新加载一次
                var form = layui.form,
                        flow = layui.flow;
                secondsKillCurrentFlow(hours);
            });
        }, 500);


    });

})
function secondsKillCurrentFlow(hours) {
    flow.load({
        elem: '#rolling-list' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                secondsKillCurrent(page, next, hours);
            }, 100);
        }
    });
}
function secondsKillCurrent(page, next, hours) {
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'seconds_kill/secondsKillCurrent/',
        type: 'get',
        data: {hours: hours, start: start, limit: number},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            console.log(pageAll);
            var list = secondsKillCurrentHtml(data, hours);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10
        }
    });
}
function secondsKillCurrentHtml(data, hours2) {
    var list = [];
    $("#test-times span,#secondstime .dagnqianms").remove();
    $.each(data.list, function (index, val) {
        console.log(data.shours + ',' + hours2);
        if (data.shours + ":00:00" == hours2 || hours2 == '') {
            var href = tp5_url('goods/goods_details?goods_id=' + val['goods_id'] + '&activity=seconds_kill');
            var abtnClass = 'goodspay-a';
        } else {
            var href = 'javascript:;';
            var abtnClass = 'goodspay-b';
        }
        var html = `<li class="secondscont-li">
                    <div class="secondscontdiv-auto">
                        <div class="secondscontdiv-img floatleft">
                            <img src="` + files_url(val['thecover']) + `" />
                        </div>
                        <div class="goods-text floatleft">
                            <p class="goods-name">` + val['goods_name'] + `</p>
                            <p class="goods-price">￥` + val['sk_price'] + `</p>
                            <p class="goods-pay floatright">
                                <a href="` + href + `" class="` + abtnClass + `">立即抢购</a>
                            </p>
                        </div>
                    </div>
                </li>`;
        list.push(html);
    });
    $("#test-times").prepend('<span>当前秒杀：<em>' + data.shours + '点抢杀</em></span>');
    $("#secondstime").prepend(`<li data-time="` + data.shours + `:00:00" class="dagnqianms active-sec">
                            <p class="secpone">` + data.shours + `点</p>
                            <p>当前秒杀</p>
                        </li>`);
    $("#timeli" + data.shours).remove();
    return list;
}