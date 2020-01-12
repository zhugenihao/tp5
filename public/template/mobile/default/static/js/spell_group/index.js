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
        url: 'spell_group/index/',
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
        var html = `<li class="pintuan-li">
                        <div class="pintuan-liauto">
                            <div class="pintuan-img">
                                <img src="` + staticurl + v['thecover'] + `"> 
                            </div>
                            <div class="pintuan-text">
                                <div class="pintuan-textauto">
                                    <p class="pintuan-title">` + v['goods_name'] + `</p>
                                    <p class="pintuan-jiage">￥` + v['goods_price'] + `</p>
                                </div>
                                <div class="pintuan-btn">
                                    <span class="pintuan-tishi">` + v['sg_members_num'] + `个人就可以成团</span>
                                    <a href="` + tp5_url('goods/goods_details?goods_id=' + v['goods_id']+'&activity=spell_group') + `" class="pintuan-btna">立即开团</a>
                                </div>

                            </div>
                        </div>
                    </li>`;
        list.push(html);
    });
    return list;
}