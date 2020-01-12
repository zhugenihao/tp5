<link rel="stylesheet" type="text/css" href="__MOBILE__/css/public/window.css" />
<script type="text/javascript" src="__MOBILE__/js/public/window.js"></script>
<div class="window_cos">
    <div class="windowcos_bacg"></div>
    <div class="windowcos_det">
        <div class="windowcos_auto">
            <div class="windowcos_auto2">
                <div class="windowcos_guanbi">X</div>
                <div class="window-text1">
                    <ul>
                        <li class="pay-all">
                            <div class="payall-1">
                                <p class="floatleft">支付方式</p>
                                <p class="floatright">我的余额：{$forehead}</p>
                            </div>
                            <div class="payall-2 floatfalse" id="payment_div">
                                {volist name="payment_list" id="vo"}
                                <div class="payall-2auto {eq name="vo['payment_mark']" value="balance"} paybacg{/eq}"
                                     data-paytype="{$vo['payment_mark']}">
                                    <p class="payall-21 {eq name="vo['payment_mark']" value="balance"} yuezf{/eq}
                                       {eq name="vo['payment_mark']" value="wechat"} weixinzf{/eq}
                                       {eq name="vo['payment_mark']" value="pay_treasure"} zhifubaozf{/eq}
                                       {eq name="vo['payment_mark']" value="friend_paid"} fengyoudf{/eq}">
                                       <i class="Hui-iconfont">{$small_icon[$vo['small_icon']]['icon']}</i>
                                    </p>
                                    <p class="payall-22">{$vo['payment_name']}</p>
                                </div>
                                {/volist}
                            </div>
                        </li>
                        <li class="addressso-all sorderbot">
                            <div class="sorder-bottom htmlwidth">
                                <div class="sorder-bottext">
                                    <p class="sorder-botp">共<span class="goods_num">10</span>件，实付<strong class="total_price">￥<span id="tprice_text">0.00</span></strong></p>
                                </div>
                                <div class="sorder-btn" onclick="detPayment(this)">立即付款</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
