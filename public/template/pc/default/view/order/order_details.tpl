<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>订单详情</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/order_details.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="member-all">
                <!--头部栏目-->
                {include file="public/member_top" /}

                <div class="pcdiv-auto">
                    <div class="membertext-all">
                        <!--左部栏目-->
                        {include file="public/member_left" /}

                        <div class="member-right floatleft">
                            <div class="member-text">
                                <div class="member-yue"><span>订单详情</div>
                                <div class="order-det">
                                    <ul class="orderdet-ul">
                                        <li class="orderdet-li">
                                            <div class="orderdet-img floatleft">
                                                <img src="__STATIC__/{$orderGoods['goods_img']}" />
                                            </div>
                                            <div class="orderdet-text floatleft">
                                                <div class="orderdet-name">{$orderGoods['goods_name']}</div>
                                                <div class="orderdet-er">
                                                    <div class="floatleft">
                                                        <div class="goods-price">￥{$orderGoods['goods_price']}</div>
                                                        <div class="goods-guige">规格:{$orderGoods['goods_information']}</div>
                                                    </div>
                                                    <div class="floatright">
                                                        <div>数量：{$orderGoods['goods_num']}</div>
                                                        {eq name="orderGoods['state']" value="10"}
                                                        <div class="color-red">待付款</div>
                                                        {/eq}
                                                        {eq name="orderGoods['state']" value="11"}
                                                        <div class="color-red">交易关闭</div>
                                                        {/eq}
                                                        {eq name="orderGoods['state']" value="20"}
                                                        <div class="color-green">待发货</div>
                                                        {/eq}
                                                        {eq name="orderGoods['state']" value="30"}
                                                        <div class="color-green">待收货</div>
                                                        {/eq}
                                                        {eq name="orderGoods['state']" value="40"}
                                                        <div class="color-green">已完成</div>
                                                        {/eq}

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="floatleft">收货地址：</div>
                                            <div class="adds_name floatleft">
                                                <p>{$orderGoods['ads_name']} {$orderGoods['ads_mobile']}</p>
                                                <p>{$orderGoods['tcgaddress']}</p>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="floatleft">给卖家留言：</div>
                                            <div class="gmly-text floatleft">{$orderGoods['leave_message']}</div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div>
                                                <div class="floatleft">物流信息</div>
                                                <div class="wuliu-gd floatright">
                                                    <a href="{:url('order/logistics',['type'=>4,'order_id'=>$orderGoods['id']])}">更多<i class="Hui-iconfont"></i></a>
                                                </div>
                                            </div>
                                            <div class="wuliu-name">【深圳市】已签收都舍不得结束分部积分备份的借口吧市就不发的九分裤才能放心打开</div>
                                            <div class="yunfei-price">
                                                <div class="floatleft">运费</div>
                                                <div class="goods-price2 floatright">￥{$orderGoods['courier_price']}</div>
                                            </div>
                                            <div class="yunfei-price">
                                                <div class="floatleft">实付（含运费）</div>
                                                <div class="goods-price floatright">￥{$orderGoods['total_price']}</div>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="floatleft">优惠券</div>
                                            <div class="wuliu-gd floatright">
                                                {if $orderGoods['copon_receive_id'] > 0}
                                                    用了一张可低￥{$orderGoods['cop_price']}的优惠券
                                                {else /}
                                                    没有可用优惠券
                                                {/if}
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="floatleft">支付方式</div>
                                            <div class="wuliu-gd floatright">{$orderGoods['payment_name']}</div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="orderdet-times">
                                                <p>订单编号：{$orderGoods['order_no']}</p>
                                                <p>下单时间：{$orderGoods['tord_time']}</p>
                                                <p>付款时间：{$orderGoods['payment_time']}</p>
                                                <p>发货时间：{$orderGoods['delivery_time']}</p>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="orderdet-telm">
                                                <p onclick="datel(this)" data-tel="{$kefu['tel']}"><i class="Hui-iconfont">&#xe6a3;</i>&nbsp;打电话</p>
                                                <p onclick="kefuUrl(this)" url="{:url('socket/index/index',['kefu_id'=>$kefu['id'],'order_no'=>$orderGoods['order_no']])}">
                                                    <i class="Hui-iconfont">&#xe622;</i>&nbsp;联系卖家
                                                </p>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="orderdet-telm">
                                                <p><i class="Hui-iconfont">&#xe6dd;</i>&nbsp;退款</p>
                                                <p><i class="Hui-iconfont">&#xe66c;</i>&nbsp;退货</p>
                                                <p><i class="Hui-iconfont">&#xe6e0;</i>&nbsp;退货退款</p>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <form action="" method="post" name="formsubmit" id="formsubmit">
                                                <input type="hidden" value="{$orderGoods['goods_id']}" name="goods_id[]" />
                                                <input type="hidden" value="{$orderGoods['n_id']}" name="n_id[]" />
                                                <input type="hidden" value="{$orderGoods['cate_id']}" name="cate_id[]" />
                                                <input type="hidden" value="{$orderGoods['total_price']}" name="cart_total_price" />
                                                <input type="hidden" value="{$orderGoods['payment_type']}" name="payment_type" />
                                            </form>
                                            <input type="hidden" value="{$orderGoods['order_no']}" name="order_no" id="order_no" />
                                            <div class="wuliu-btn">
                                                <a href="javascript:;" class="btnlist-a" onclick="returnOnPage();">返回</a>
                                            </div>
                                            {if $orderGoods['state']==10 }
                                                <div class="wuliu-btn" onclick="detPayment(this)"><a href="javascript:;" class="btnlist-a">立即付款</a></div>
                                            {elseif $orderGoods['state']==30 /}
                                                <div class="wuliu-btn" onclick="confirmGoods(this)"><a href="javascript:;" class="btnlist-a">确认收货</a></div>
                                            {/if}
                                            {if $orderGoods['state'] >= 20}
                                                <div class="wuliu-btn"><a href="{:url('order/logistics',['type'=>4,'order_id'=>$orderGoods['id']])}" class="btnlist-a">查看物流</a></div>
                                            {/if}
                                            
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/order/order_details.js"></script>
    </body>
</html>
