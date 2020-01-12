
$(function () {
    layui.use(['form', 'flow'], function () {
        form = layui.form,
                flow = layui.flow;
        recordBooksListFlow('into');
    })
    $(".record_bookstop-auto div").click(function () {
        $(".record_bookstop-auto div").removeClass('record_books-active');
        $(this).addClass('record_books-active');
        var books_type = $(this).data('bookstype');
        $("#record_books_listul").remove();
        $("#record_bookslist_alldiv").append('<ul class="record_bookslist-ul" id="record_books_listul"></ul>');
        layui.use(['form', 'flow'], function () {//重新加载一次
            var form = layui.form,
                    flow = layui.flow;
            recordBooksListFlow(books_type);
        });
    })
})
function recordBooksListFlow(books_type) {
    flow.load({
        elem: '#record_books_listul' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                recordBooksListList(page, next, books_type);
            }, 100);
        }
    });
}
//异步获取数据
function recordBooksListList(page, next, books_type) {

    var number = 6;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'record_books/index/',
        type: 'get',
        data: {start: start, limit: number, books_type: books_type},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = recordBooksListListHtml(data.list, books_type);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10

        }
    });
}
function recordBooksListListHtml(data, books_type) {
    var list = [];
    $.each(data, function (index, val) {
        var rdbook_type = "其他";
        if (val['rdbook_type'] == 1) {
            var rdbook_type = "余额币";
        } else if (val['rdbook_type'] == 2) {
            var rdbook_type = "积分";
        }
        var amount_text = books_type == 'into' ? "+" + val['amount'] + rdbook_type : "-￥" + val['amount'];
        var amount_class = books_type == 'into' ? "rbooksnum-green" : "color-red";
        var html = `<li class="rbooks-li">
                            <div class="rbooks-liauto">
                                <div class="rbooks-one">
                                    <div class="rbooks-text floatleft">` + val['books_text'] + `</div>
                                    <div class="` + amount_class + ` floatright">` + amount_text + `</div>
                                </div>
                                <div class="rbooks-time">` + val['create_time'] + `</div>
                            </div>
                        </li>`;
        list.push(html);
    });
    return list;
}