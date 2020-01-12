
$(function () {
    layui.use(['form', 'flow'], function () {
        form = layui.form,
                flow = layui.flow;
        singnInListFlow();
    })
    $(".singintop-text").click(function () {
        $(".qiandaoguize").show();
    });
    $(".qiandaoguize-bag,.qiandaoguize-auto").click(function (e) {
        if($(e.target).closest(".qiandaoguizea-2").length == 0){
            $(".qiandaoguize").hide();
        }
    });
    
})
function singnInListFlow() {
    flow.load({
        elem: '#singinjilu-list' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                singnInListList(page, next);
            }, 100);
        }
    });
}
//异步获取数据
function singnInListList(page, next) {

    var number = 20;
    var start = number * (page - 1);
    ajaxMethods({
        url: 'sign_in/index/',
        type: 'get',
        data: {start: start, limit: number},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = singnInListListHtml(data.list);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10

        }
    });
}
function singnInListListHtml(data) {
    var list = [];
    $.each(data, function (index, val) {
        var html = `<li class="singinjl-li">
                        <div class="width10">` + (index + Number(1)) + `</div>
                        <div class="width30">` + val['signin_time'] + `</div>
                        <div class="width30">` + val['gold_coins'] + `</div>
                        <div class="width30">` + val['continuous_day'] + `</div>
                    </li>`;
        list.push(html);
    });
    return list;
}
function singinClick(obj) {
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    ajaxMethods({
        url: 'sign_in/addSignIn',
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
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'});
            }, 2000);
        }
    });
}