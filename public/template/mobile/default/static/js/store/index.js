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
    var store_id = $("#store_id").val();
    ajaxMethods({
        url: 'store/storeGoodsAll/',
        type: 'get',
        data: {start: start, limit: number, store_id: store_id},
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
                                <span class="tejiayouhui-xl">` + v['number_payment'] + `人付款</span>
                            </div>
                        </a>
                    </li>`;
        list.push(html);
    });
    return list;
}