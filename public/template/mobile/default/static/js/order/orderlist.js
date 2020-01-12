
var activity = '';
if (getUrlParms('activity') != '') {
    var activity = getUrlParms('activity');
}
layui.use(['form', 'flow'], function () {
    form = layui.form,
            flow = layui.flow;

    var state = getUrlParms('state');
    $(".order-topul li").removeClass('adtactive');
    if (state == 10) {
        $(".order-topul li").eq(1).addClass('adtactive');
    } else if (state == 20) {
        $(".order-topul li").eq(2).addClass('adtactive');
    } else if (state == 30) {
        $(".order-topul li").eq(3).addClass('adtactive');
    } else if (state == 40) {
        $(".order-topul li").eq(4).addClass('adtactive');
    } else {
        var state = 'all';
        $(".order-topul li").eq(0).addClass('adtactive');
    }
    orderListFlow(state, '', activity);
});
$(function () {
    $(".order-topul li").click(function () {
        $(".order-topul li").removeClass('adtactive');
        $(this).addClass('adtactive');
        var state = $(this).data('state');
        $("#stateId").val(state);
        $("#order_listul").remove();
        $("#order-list").append('<ul class="order-listul" id="order_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            orderListFlow(state, '', activity);
        });
    })
    $("#search-btn2").click(function () {
        var state = $("#stateId").val();
        var search = $(".search-input").val();
        $("#order_listul").remove();
        $("#order-list").append('<ul class="order-listul" id="order_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            orderListFlow(state, search, activity);
        });
    });
    $(function () {
        shopWindow({
            selector: ".det_payment",
            top: '14%',
            width: '20rem',
            height: '20rem',
            sCallback: function (obj) {
                var order_no = $(obj).data('orderno');
                var total_price = $(obj).data('totalprice');
                var goods_num = $(obj).data('goodsnum');
                $("#order_no").val(order_no);
                $("#total_price").val(total_price);
                $("#tprice_text").text(total_price);
                $(".goods_num").text(goods_num);
            }
        });
        $("#payment_div div").click(function () {
            $("#payment_div div").removeClass('paybacg');
            $(this).addClass('paybacg');
            var payment_type = $(this).data('paytype');
            $("#payment_type").val(payment_type);
        })
    });
})
function orderListFlow(state, search, activity) {
    flow.load({
        elem: '#order_listul' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                orderList(page, next, state, search, activity);
            }, 100);
            console.log(state);
        }
    });
}
//异步获取数据
function orderList(page, next, state, search, activity) {
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'order/orderList/',
        type: 'get',
        data: {state: state, start: start, limit: number, search: search, activity: activity},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = orderListHtml(data.list, state);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10
            form.val('example', {
                "like[write]": true //复选框选中状态
            })
        }
    });
}
function orderListHtml(data, state) {
    var list = [];
    $.each(data, function (index, val) {
        var buy_text = '';
        var state_text = '';
        var wuliu_text = '';
        var formsubmit = '';
        var activity_html = '';
        switch (Number(val['state']))
        {
            case 10:
                var state_text = '待付款';
                var buy_text = '<a href="javascript:;" class="order-shouhuo det_payment" data-orderno="' + val['order_no'] + '" data-totalprice="' + val['total_price'] + '" data-goodsnum="' + val['goods_num'] + '">立即付款</a>';
                var wuliu_text = '<a href="javascript:;" class="order-wuliu" onclick="orderDel(this)" data-orderid="' + val['id'] + '">取消订单</a>';

                break;
            case 11:
                var state_text = '交易关闭';
                break;
            case 20:
                var state_text = '待发货';
//                var buy_text = '<a href="javascript:;" class="order-shouhuo" onclick="confirmGoods(this)" data-orderno="' + val['order_no'] + '">确认收货</a>';
                var wuliu_text = '<a href="' + tp5_url('order/logistics?order_id=' + val['id']) + '" class="order-wuliu">查看物流</a>';
                break;
            case 30:
                var state_text = '卖家已发货';
                var buy_text = '<a href="javascript:;" class="order-shouhuo" onclick="confirmGoods(this)" data-orderno="' + val['order_no'] + '">确认收货</a>';
                var wuliu_text = '<a href="' + tp5_url('order/logistics?order_id=' + val['id']) + '" class="order-wuliu">查看物流</a>';
                break;
            case 40:
                var state_text = '交易成功';
                if (!val['comt_is']) {
                    var wuliu_text = '<a href="' + tp5_url('comments/add?order_id=' + val['id']) + '" class="order-wuliu">待评价</a>';
                }

                break;
            default:

                break;
        }
        var setup_norm_html = `<div class="order-qita">规格:` + val['color_name'] + val['cate_name'] + `</div>`;
        if (val['setup_norm'] == 'off') {
            var setup_norm_html = '<div style="height:30px;"></div>';
        }
        if (val['activity'] == 'comdysalesp') {
            var activity_html = '<div class="activitytext">促销商品</div>';
        }
        if (val['activity'] == 'seconds_kill') {
            var activity_html = '<div class="activitytext">秒杀商品</div>';
        }
        if (val['activity'] == 'spell_group') {
            if (val['sgm_member_poor'] > 0) {
                var poor_html = "还差" + val['sgm_member_poor'] + "人";
            } else {
                var poor_html = "人数已满";
            }
            if (val['sgm_member_list']) {

            }
            var activity_html = `<div class="activitytext">拼团订单:` + val['sg_members_num'] + `人成团，` + poor_html + `</div>`;
            if (val['sgm_member_list'] != '') {
                activity_html += `<div class="spellmember">团员:`;
                $.each(val['sgm_member_list'], function (sgm_index, sgm_val) {
                    var headoftheClass = sgm_index == 0 ? "selactive" : "";
                    activity_html += '<img class="' + headoftheClass + '" src="' + files_url(sgm_val['photo']) + '" />';
                })
                activity_html += '</div>';
            }


        }
        var html = `<li class="order-listli">
                        ` + activity_html + `
                        <div class="order-listli-auto">
                            <div class="order-img">
                                <a href="` + module + 'order/order_details?order_id=' + val['id'] + `" >
                                   <img src="` + staticurl + val['goods_img'] + `" />
                               </a>
                            </div>
                            <div class="order-text">
                                <a href="` + module + 'order/order_details?order_id=' + val['id'] + `" >
                                    <p class="tord_time">下单时间：` + val['tord_time'] + `</p>
                                    <div class="order-title">
                                        ` + val['goods_name'] + `
                                    </div>
                                    <div class="order-text2">
                                        <div class="order-text21 floatleft">
                                            <div class="order-jiage">￥` + val['total_price'] + `</div>
                                            ` + setup_norm_html + `
                                        </div>
                                        <div class="floatright">
                                            <div class="order-num">数量：` + val['goods_num'] + `</div>
                                            <div class="order-state">` + state_text + `</div>
                                       </div>
                                        
                                    </div>
                                </a>
                                <div class="order-btn">
                                    ` + buy_text + wuliu_text + `
                                </div>
                            </div>
                        </div>
                        ` + formsubmit + `
                    </li>`;
        list.push(html);
    });
    return list;
}
function orderDel(obj) {
    layer.msg('确定要删除么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            orderDelAjax(obj);
        }
    });

}
function orderDelAjax(obj) {
    var order_id = $(obj).data('orderid');
    ajaxMethods({
        url: 'order/orderDel/',
        type: 'get',
        data: {order_id: order_id},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}

function detPayment(obj) {
    var payment_type = $("#payment_type").val();
    if (payment_type != 'balance') {
        layer.msg("该支付暂未开放！", function () {});
        return;
    }
    layer.msg('确认支付', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            payUpdate(obj);
        }
        , btn2: function () {
        }
    });
}

function payUpdate(obj) {
    layer.load(1);
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    ajaxForm({
        url: 'pay/payUpdateOne/',
        type: 'post',
        formName: 'pay_submit',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }

        }
    });
}
function confirmGoods(obj) {
    var order_no = $(obj).data('orderno');
    layer.msg('你确定要确认收货么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            confirmGoodsAjax(order_no);
        }
    });
}
function confirmGoodsAjax(order_no) {
    ajaxMethods({
        url: 'order/confirmGoods/',
        type: 'get',
        data: {order_no: order_no},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
