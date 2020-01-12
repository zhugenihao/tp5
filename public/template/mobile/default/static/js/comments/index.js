layui.use(['form', 'flow'], function () {
    var flow = layui.flow, layer = layui.layer;
    flow.load({
        elem: '#rolling-list' //流加载容器
        , scrollElem: '' //滚动条所在元素，一般不用填，此处只是演示需要。
        , done: function (page, next) { //执行下一页的回调
            //模拟数据插入
            setTimeout(function () {
                commentsList(page, next);
            }, 100);
        }
    });
});

//异步获取数据
function commentsList(page, next) {
    var number = 6;
    var start = number * (page - 1);
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'comments/index/',
        type: 'get',
        data: {start: start, limit: number, goods_id: goods_id},
        sCallback: function (data) {
            var pageAll = Math.ceil(data.count / number);//向上取整
            var list = commentsHtml(data.list,data['mid']);
            //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
            //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
            next(list.join(''), page < pageAll); //假设总页数为 10
        }
    });
}
function commentsHtml(data,mid) {
    var list = [];
    $.each(data, function (i, v) {
        var html = `<li class="comments-lli">
                        <div class="comments-member">
                            <p class="comments-mimg">
                                <img src="` + files_url(v['member']['photo']) + `"/>
                            </p>
                            <p class="comments-mname">` + v['member']['member_name'] + `</p>
                            <div class="deltimed floatright">`+
                            aDelHtml(v['m_id'],mid,v['id'])
                        +`<div><span class="commentstime">`+v['create_time']+`</span></div></div>
                        </div>
                        <div class="comments-text">
                            <div class="comments-tauto">
                                <p class="comments-cont">` + v['texts'] + `</p>
                                <ul class="comments-imgul" id="lightGallery">` + commentsImg(v['comments_img']) + `</ul>
                            </div>
                        </div>
                    </li>`;
        list.push(html);
    });
    return list;
}
function aDelHtml(cmid,mid,commid){
    console.log(cmid+','+mid+','+commid);
    var html = '';
    if(cmid===mid){
        var html = '<div class="comDeldiv"><a href="javascript:;" class="comDel" onclick="commentsDel(this)" data-comid="' + commid + '">删除</a></div>';
    }
    return html;
}
function commentsImg(data) {
    var html = '';
    $.each(data, function (i, imgv) {
        html += '<li class="comments-imgil" data-src="' + files_url(imgv['img_url']) + '">';
        html += '<img src="' + files_url(imgv['img_url']) + '"/>';
        html += '</li>';
    });
    return html;
}
function commentsDel(obj) {
    layer.msg('你确定要删除这条评论么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            commentsDelAjax(obj);
        }
    });
}
function commentsDelAjax(obj) {
    var comid = $(obj).data('comid');
    ajaxMethods({
        url: 'comments/commentsDel/',
        type: 'get',
        data: {comid: comid},
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
