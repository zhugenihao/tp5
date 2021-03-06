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
function reGoodsList(page, next) {
    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'member/collection',
        type: 'get',
        data: {start: start, limit: number},
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
                            <a href="` + tp5_url('goods/goods_details?goods_id=' + v['goods_id']) + `">
                                <div class="tejiayouhui-img"><img src="` + files_url(v['thecover']) + `"></div>
                                <div class="tejiayouhui-title">` + v['goods_name'] + `</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥` + v['goods_price'] + `</span>
                                    <span class="tejiayouhui-xl">` + v['number_payment'] + `人付款</span>
                                </div>
                            </a>
                        </li>`;
        list.push(html);
    });
    return list;
}
function deleteCollection(obj) {
    layer.msg('确定清空么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            deleteCollectionAjax(obj);
        }
    });
}
function deleteCollectionAjax(obj) {
    ajaxMethods({
        url: 'collection/deleteCollection',
        type: 'get',
        data: {},
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