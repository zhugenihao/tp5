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
        <meta name="format-detection" content="telephone=yes"/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/order/order_details.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="sorder-all allas">
                <div class="sorder-auto">
                    <form class="layui-form" action="" lay-filter="example">
                        <ul class="sorder-ul">
                            <li class="sorder-li">
                                <div class="sorder-lidiv layui-form-item">
                                    <div class="sorder-imgas">
                                        <div class="sorder-img">
                                            <img src="__STATIC__/{$orderGoods['goods_img']}">
                                        </div>
                                        <p>某某旗舰店</p>
                                    </div>
                                    <div class="sorder-title">
                                        <div class="sorder-textas">{$orderGoods['goods_name']}</div>
                                        <div class=""><span class="sorder-jiage">￥{$orderGoods['goods_price']}</span>
                                            <div class="sorder-num floatright">数量：<span class="goods_num">{$orderGoods['goods_num']}</span></div>
                                        </div>
                                        <div class="sorder-qita">
                                            <p class="sorder-qitagg floatleft">规格:{$orderGoods['goods_information']}</p>
                                        </div>
                                        <div class="sorder-btnas floatright">
                                            {if $orderGoods['state']==10 }
                                                <span class="color-red">待付款</span>
                                            {elseif $orderGoods['state']==11 /}
                                                <span class="color-red">订单已关闭</span>
                                            {elseif $orderGoods['state']==20 /}
                                                <span class="color-red">待卖家发货</span>
                                            {elseif $orderGoods['state']==30 /}
                                                <span class="color-red">待收货</span>
                                            {elseif $orderGoods['state']==40 /}
                                                <span class="color-red">已完成</span>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="sorder-li addressso-all">
                                <div class="addressso-1 floatleft">
                                    收货地址
                                </div>
                                <div class="addressso-2 floatleft" id="addressbtns">
                                    <div class="addressso-21 floatleft">
                                        <p id="addressnamb">{$orderGoods['ads_name']} {$orderGoods['ads_mobile']}</p>
                                        <p id="addresstext">{$orderGoods['tcgaddress']}</p>
                                    </div>

                                </div>
                            </li>

                            <li class="sorder-li mliuyan">
                                <div class="mliuyan-1">给卖家留言：</div>
                                <div class="mliuyan-2">
                                    <p class="mliuyan-p">{$orderGoods['leave_message']}</p>
                                </div>
                            </li>
                            <li class="sorder-li wuliu">
                                <div class="floatleft wuliu-1">物流信息</div>
                                <div class="floatleft wuliu-2 wuliu-btn">
                                    <p class="floatright"><a href="{:url('order/logistics',['order_id'=>$orderGoods['id']])}">更多<i class="Hui-iconfont"></i></a></p>
                                </div>
                                <div class="wuliu-cont">
                                    <p class="wuliucont-p">【深圳市】已签收都舍不得结束分部积分备份的借口吧市就不发的九分裤才能放心打开</p>
                                    <div class="wuliucont-div">
                                        <p class="floatleft">运费</p>
                                        <p class="color-red floatright">￥{$orderGoods['courier_price']}</p>
                                    </div>
                                    <div class="wuliucont-div">
                                        <p class="floatleft">实付（含运费）</p>
                                        <p class="color-red total_price floatright"><strong>￥{$orderGoods['total_price']}</strong></p>
                                    </div>
                                </div>
                            </li>
                            <li class="sorder-li wuliu">
                                <div class="floatleft wuliu-1">优惠券</div>
                                <div class="floatleft wuliu-2 goodsyouhui-btn">
                                    <p class="floatleft wuliu-2p1" id="youhuiamount">
                                        {if $orderGoods['copon_receive_id'] > 0}
                                            用了一张可低￥{$orderGoods['cop_price']}的优惠券
                                        {else /}
                                            没有可用优惠券
                                        {/if}
                                    </p>
                                </div>
                            </li>
                            <li class="sorder-li pay-all">
                                <div class="payall-1">
                                    <p class="floatleft">支付方式</p>
                                    <p class="floatright">{$orderGoods['payment_name']}</p>
                                </div>
                            </li>
                            <li class="sorder-li">
                                <div class="order-xinxi">
                                    <p>订单编号：{$orderGoods['order_no']}</p>
                                    <p>下单时间：{$orderGoods['tord_time']}</p>
                                    <p>付款时间：{$orderGoods['payment_time']}</p>
                                    <p>发货时间：{$orderGoods['delivery_time']}</p>
                                </div>
                            </li>
                            <li class="sorder-li xinxiasli">
                                <div class="order-xinxias">
                                    <p><a href="tel:{$kefu['tel']}"><i class="Hui-iconfont">&#xe6a3;</i>&nbsp;打电话</a></p>
                                    <p><a href="javascript:;" id="socketa" url="{:url('socket/index/index',['kefu_id'=>$kefu['id'],'order_no'=>$orderGoods['order_no']])}">
                                            <i class="Hui-iconfont">&#xe622;</i>&nbsp;联系卖家</a>
                                    </p>
                                </div>
                            </li>
                            <li class="sorder-li xinxiasli">
                                <div class="order-xinxias">
                                    <p><i class="Hui-iconfont">&#xe6dd;</i>&nbsp;退款</p>
                                    <p><i class="Hui-iconfont">&#xe66c;</i>&nbsp;退货</p>
                                    <p><i class="Hui-iconfont">&#xe6e0;</i>&nbsp;退货退款</p>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <form action="" method="post" name="formsubmit" id="formsubmit">
                <input type="hidden" value="{$orderGoods['goods_id']}" name="goods_id[]" />
                <input type="hidden" value="{$orderGoods['n_id']}" name="n_id[]" />
                <input type="hidden" value="{$orderGoods['cate_id']}" name="cate_id[]" />
                <input type="hidden" value="{$orderGoods['total_price']}" name="cart_total_price" />
                <input type="hidden" value="{$orderGoods['payment_type']}" name="payment_type" />
            </form>

            <input type="hidden" value="{$orderGoods['order_no']}" name="order_no" id="order_no" />
            <div class="sorder-bottom">
                {if $orderGoods['state']==10 }
                    <div class="sorder-btn floatright" onclick="detPayment(this)">立即付款</div>
                {elseif $orderGoods['state']==30 /}
                    <div class="sorder-btn floatright" onclick="confirmGoods(this)">确认收货</div>
                {/if}
                {if $orderGoods['state'] >= 20}
                    <div class="sorder-btn1 floatright" ><a href="{:url('order/logistics',['order_id'=>$orderGoods['id']])}">查看物流</a></div>
                {/if}
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/order/order_details.js"></script>
    </body>
</html>
