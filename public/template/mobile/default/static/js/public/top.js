$(function () {
    var title = document.title;
    $(".top_text").text(title);
    layui.use(['form', 'flow'], function () {
        form = layui.form,
                flow = layui.flow;
    })
    $(".search-btn").click(function () {
        var search = $(".search-input").val();
        $(".allas").remove();
        $("#goods_alldivsearch").show();
        $("#goods_listulsearch").remove();
        $("#goods_alldivsearch").append('<ul class="tejiayouhui-ul" id="goods_listulsearch"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            searchGoodsListFlow('all', search, {});
        });
    })
    if ($("#youslieid").is(".youslie")) {
        $("#top_gengduoid").show();
    }
    $("#top_gengduoid").click(function () {
        if ($("#youslieid").is(":hidden")) {
            $("#youslieid").show();
        } else {
            $("#youslieid").hide();
        }
    });
    $(".allas").click(function(){
        $("#youslieid").hide();
    })
});
function searchGoodsListFlow(type, search, goods_data) {
    flow.load({
        elem: '#goods_listulsearch' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                searchGoodsList(page, next, type, search, goods_data);
            }, 500);
        }
    });
}
//异步获取数据
function searchGoodsList(page, next, type, search, goods_data) {
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'goods/goods_all/',
        type: 'get',
        data: {type: type, start: start, limit: number, search: search, goods_data},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = searchGoodsListHtml(data.list);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10

        }
    });
}
function searchGoodsListHtml(data) {
    var list = [];
    $.each(data, function (index, val) {
        var html = `<li class="tejiayouhui-li">
                        <a href="` + tp5_url('goods/goods_details?goods_id=' + val['goods_id']) + `">
                            <div class="tejiayouhui-img"><img src="` + files_url(val['thecover']) + `" /></div>
                            <div class="goodslistright">
                                <div class="tejiayouhui-title">` + val['goods_name'] + `</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥` + val['goods_price'] + `</span>
                                    <span class="tejiayouhui-xl">` + val['number_payment'] + `人付款</span>
                                </div>
                            </div>
                        </a>
                    </li>`;
        list.push(html);
    });
    return list;
}

