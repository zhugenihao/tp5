<div class="kejia-all">
    <div class="kejia-top">
        <div class="index-title floatleft">热门商品</div>
       <!-- <div class="floatright"><a href="{:url('guess_you_like/index')}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>-->
    </div>
    <div class="kejia-list">
        <ul class="kejia-ul">
            {volist name="paymentGoodsList" id="vo"}
            <li class="kejia-li">
                <a href="{:url('goods/goods_details',['goods_id'=>$vo.goods_id])}">
                    <div class="kejia-img">
                        <img src="__STATIC__{$vo['thecover']}" />
                    </div>
                    <div class="kejia-name">{$vo['goods_name']}</div>
                    <div class="kejia-jiagerf">
                        <div class="kejia-jiage floatleft">￥{$vo['goods_price']}</div>
                        <div class="floatright">{$vo['number_payment']}人付款</div>
                    </div>
                </a>
            </li>
            {/volist}
        </ul>
    </div>
</div>