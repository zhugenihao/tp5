
$(function () {
    $(".dengduo").click(function () {
        $(".cantuanlist").show();
        spellList('#spell_lists2', 0, 15);
    })
    $("#pinyuan").click(function () {
        $("#pinyuan").hide();
    })
    $("#pinyuan-auto2").click(function () {
        $("#pinyuan2").hide();
        $("#first_member_id").val(0);
        $("#sgm_id").val(0);
    })
    $(".spell-buys").click(function () {
        var activity = $("#activity").val();
        $("#pinyuan2").hide();
        $(".sepll_buy").click();
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
    spellList('#spell_lists1', 0, 2);
})
function spellList(_divid, start, limit) {
    var goodsId = $("#goods_id").val();
    ajaxMethods({
        url: 'spell_group_ordernum/getlist/',
        type: 'get',
        data: {goods_id: goodsId, start: start, limit: limit},
        sCallback: function (data) {
            var html = '';
            $.each(data['list'], function (index, val) {
                html += `<li class="spell_list_li">
                            <div class="spell_list_img floatleft">
                                <img src="` + files_url(val['photo']) + `" onerror="imgExists(this)"/>
                            </div>
                            <div class="spell_list_name floatleft">` + val['member_name'] + `</div>
                            <div class="spell_list_btns floatright">
                                <span class="spell_list_span">快来拼团，还差` + val['poor_member'] + `人</span>
                                <a href="javascript:;" class="splbtna" first_member_id="` + val['first_member_id'] + `" 
                                poor="` + val['poor_member'] + `" sgm_id="` + val['id'] + `">参加</a>
                            </div>
                        </li>`;
            });
            $(_divid).html(html);
            $("#spell_member_all").text(data['count']);
        }
    });
}

