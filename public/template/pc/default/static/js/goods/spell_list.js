
$(function () {
    $("#pinyuan-auto2").click(function () {
        $("#pinyuan2").hide();
        $("#first_member_id").val(0);
        $("#sgm_id").val(0);
    })
    $(".spell-buys").click(function () {
        $("#cantuanp").show();
        $("#pinyuan2").hide();
        $(".goods_buy a").text('立即参团');
    });
    layui.use(['laypage', 'layer'], function () {
        var laypage = layui.laypage
                , layer = layui.layer;
        //完整功能
        var splgomcount = $("#splgomcount").attr('splgomcount');
        laypage.render({
            elem: 'spellgroup-page'
            , count: splgomcount
            , layout: ['count', 'prev', 'page', 'next', 'limit', 'refresh', 'skip']
            , jump: function (obj) {
                console.log(obj)
                spellgroupList(obj.curr, obj.limit);
            }
        });
    });

    $("body").on('click', '.splbtna', function () {
        $("#pinyuan2").show();
        var first_member_id = $(this).attr('first_member_id');
        var sgm_id = $(this).attr('sgm_id');
        var poor = $(this).attr('poor');
        var goods_id = $("#goods_id").val();
        $("#first_member_id").val(first_member_id);
        $("#sgm_id").val(sgm_id);
        ajaxMethods({
            url: 'spell_group_ordernum/getsgMemberList/',
            type: 'get',
            data: {first_member_id: first_member_id, goods_id: goods_id},
            sCallback: function (data) {
                var html = '';
                $.each(data, function (index, val) {
                    if (first_member_id == val['id']) {
                        html += `<li class="pinyuan-li">
                                    <div class="pinyuanli-img active-pl"><img src="` + files_url(val['photo']) + `" onerror="imgExists(this)"/></div>
                                    <div class="pinyuanli-name color-red">团长</div>
                                </li>`;
                    } else {
                        html += `<li class="pinyuan-li">
                                    <div class="pinyuanli-img"><img src="` + files_url(val['photo']) + `" onerror="imgExists(this)"/></div>
                                    <div class="pinyuanli-name">成员</div>
                                </li>`;
                    }
                });
                $("#pinyuan-luid").html(html);
                $("#poormember").text(poor);
            }
        });
    });
})
//异步获取数据
function spellgroupList(page, limit) {
    var number = limit;
    var start = number * (page - 1);
    var goods_id = $("#goods_id").val();
    ajaxMethods({
        url: 'spell_group_ordernum/getlist/',
        type: 'get',
        data: {start: start, limit: number, goods_id: goods_id},
        sCallback: function (res) {
            console.log(res['count']);
            $("#splgomcount").attr('splgomcount', res['count']);
            spellgroupHtml(res.list);
        }
    });
}
function spellgroupHtml(data) {
    var html = '';
    $("#spellgroup-list li").remove();
    $.each(data, function (i, val) {
        html += `<li class="goodspl_li">
                        <div class="goodspl_top">
                            <div class="goodspl_photo">
                                <img src="` + files_url(val['photo']) + `"/>
                            </div>
                            <div class="goodspl_uname">` + val['member_name'] + `</div>
                            <div class="goodspl_ts">
                                <div class="goodspl_time">快来拼团，还差` + val['poor_member'] + `人</div>
                                <div class="splbtna" first_member_id="` + val['first_member_id'] + `" 
                                poor="` + val['poor_member'] + `" sgm_id="` + val['id'] + `">参加</div>
                            </div>
                        </div>
                        
                    </li>`;
    });
    $("#spellgroup-list").prepend(html);
}


