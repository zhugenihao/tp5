
$(function () {
    layui.use(['form', 'flow'], function () {
        form = layui.form,
                flow = layui.flow;
        var typeclassif = $("#typeclassif").val();
        var dir_id = $("#dir_id").val();
        couponListFlow('1');
    })
    $(".coupontop-auto div").click(function () {
        $(".coupontop-auto div").removeClass('coupon-active');
        $(this).addClass('coupon-active');
        var state = $(this).data('state');
        $("#coupon_listul").remove();
        $("#couponlist_alldiv").append('<ul class="couponlist-ul" id="coupon_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            couponListFlow(state);
        });
    })
})
function couponListFlow(state) {
    flow.load({
        elem: '#coupon_listul' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                couponListList(page, next, state);
            }, 100);
        }
    });
}
//异步获取数据
function couponListList(page, next, state) {

    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'coupon/index/',
        type: 'get',
        data: {start: start, limit: number, state: state},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = couponListListHtml(data.list, state);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10

        }
    });
}
function couponListListHtml(data, state) {
    var list = [];
    $.each(data, function (index, val) {
        var type_name = '';
        var a_href = '';
        var a_text = '';
        var record_html = '';
        if (val['type'] == 1) {
            var type_name = '商品：' + val['goods_name'];
            var a_href = tp5_url('goods/goods_details?goods_id=' + val['type_id']);
        } else if (val['type'] == 2) {
            var type_name = '店铺：' + val['store_name'];
            var a_href = tp5_url('stroe/index?stroe_id=' + val['type_id']);
        }

        if (state == 1) {
            var a_text = '<div class="floatright coup-btn"><a href="' + a_href + '" class="backga1">立即使用</a></div>';
        } else if (state == 2) {
            var a_href = "javascript:;";
            var a_text = '<div class="floatright coup-btn"><a href="' + a_href + '" class="backga2">已过期</a></div>';
        } else {
            var a_href = "javascript:;";
            var a_text = '<div class="floatright coup-btn"><a href="' + a_href + '" class="backga3">已使用</a></div>';
            var record_html = `<div class="record_div floatfalse">
                                    <p class="coupongoodsn">使用的商品：`+val['use_goods_name']+`</p>
                                    <p>使用的时间：`+val['create_time']+`</p>
                                </div>`;
        }
        var html = `<li class="couponlist-li">
                        <div class="couponlistone">
                            <p class="coup-price">￥` + val['cop_price'] + `</p>
                            <p class="coup-text">满` + val['full_amount'] + `元方可使用</p>
                        </div>
                        <div class="couponlisttwo">
                            <div class="coupnametime floatleft">
                                <p class="coupname">` + type_name + `</p>
                                <p class="couptime">有效期：` + val['copb_time'] + `</p>
                            </div>
                            ` + a_text + `
                        </div>` + record_html + `
                    </li>`;
        list.push(html);
    });
    return list;
}