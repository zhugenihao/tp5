
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>店铺情况</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">

                <span>
                    <label>时间</label>
                    <input type="text" value="{:input('start_time')}" id="start_time" name="start_time" size="15" class="member_text"/>-
                    <input type="text" value="{:input('end_time')}" id="end_time" name="end_time" size="15" class="member_text"/>
                </span>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">

            <div class="floatright">
                <div class="mall_btn goodsbtn_act floatleft">
                    本月订单总额（￥{$benyueOrderTprice}）
                </div>
                <div class="mall_btn bacg-blue floatleft">
                    今日订单总量（{$todayOrderNum}）
                </div>
                <div class="mall_btn goodsbtn_act floatleft">
                    人均客单价（{$guestUnitPrice}）
                </div>
                <div class="mall_btn bacg-blue floatleft">
                    本月取消订单总量（{$quxiaoOrderNum}）
                </div>
            </div>
        </div>
        <div id="main" class="floatleft"></div>
    </div>
</div>
{include file="public/plugin/store_situation" /}
<script type="text/javascript" src="__PC__/js/seller_statselement/situation/store_situation.js"></script>
