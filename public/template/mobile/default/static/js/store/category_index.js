
$(function () {
    $("#goods_type li a").click(function () {
        var type = $(this).attr('type');
        $("#rolling-list").remove();
        $("#goods_alldiv").append('<ul class="tejiayouhui-ul" id="rolling-list"></ul>');
        layui.use('flow', function () {
            var flow = layui.flow;
            flow.load({
                elem: '#rolling-list' //流加载容器
                , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
                , done: function (page, next) { //执行下一页的回调
                    //模拟数据插入
                    setTimeout(function () {
                        reGoodsList(page, next, type);
                    }, 100);
                }
            });
        });
    })
})
layui.use('flow', function () {
    var flow = layui.flow;
    flow.load({
        elem: '#rolling-list' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                reGoodsList(page, next);
            }, 100);
        }
    });
});

//异步获取数据
function reGoodsList(page, next, type) {
    var number = 6;
    var start = number * (page - 1);
    var store_id = $("#store_id").val();
    var cat_id = $("#cat_id").val();
    var directory1_id = $("#directory1_id").val();
    var directory2_id = $("#directory2_id").val();
    var directory3_id = $("#directory3_id").val();
    var type = type != undefined ? type : '';
    ajaxMethods({
        url: 'store/category_index/',
        type: 'post',
        data: {
            start: start, limit: number, store_id: store_id, cat_id: cat_id,
            directory1_id: directory1_id, directory2_id: directory2_id,
            directory3_id: directory3_id, type: type,
        },
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = reGoodsHtml(data.list);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10
        }
    });
}
function reGoodsHtml(data) {
    var list = [];
    $.each(data, function (i, v) {
        var html = `<li class="tejiayouhui-li">
                        <a href="` + module + `goods/goods_details?goods_id=` + v['goods_id'] + `">
                            <div class="tejiayouhui-img"><img src="` + staticurl + v['thecover'] + `"></div>
                            <div class="tejiayouhui-title">` + v['goods_name'] + `</div>
                            <div class="tejiayouhui-bottom">
                                <span class="tejiayouhui-jiage">￥` + v['goods_price'] + `</span>
                                <span class="tejiayouhui-xl">销量` + v['sales'] + `</span>
                            </div>
                        </a>
                    </li>`;
        list.push(html);
    });
    return list;
}