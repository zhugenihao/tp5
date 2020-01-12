<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>提交订单</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/order/submit_orders.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="sorder-all allas">
                <div class="sorder-auto">
                    <form class="layui-form" action="" lay-filter="example">
                        <ul class="sorder-ul">
                            {volist name="submitOrdersInfo['cart_list']" id="vo"}
                            <li class="sorder-li">
                                <div class="sorder-lidiv layui-form-item">
                                    <div class="sorder-imgas">
                                        <div class="sorder-img">
                                            <img src="__STATIC__/{$vo['goods_img']}">
                                        </div>
                                        <p>某某旗舰店</p>
                                    </div>
                                    <div class="sorder-title">
                                        <div class="sorder-textas">{$vo['goods_name']}</div>
                                        <div class="sorder-jiage" id="sorder-jiage{$vo['cart_id']}">
                                            ￥{$vo['goods_price']}
                                            {if $vo['hasbeenused_copon']}，已优惠￥{$vo['hasbeenused_copon']['cop_price']}{/if}
                                        </div>
                                        <div class="sorder-qita">
                                            {if $vo['setup_norm']!='off'}
                                                <p class="sorder-qitagg floatleft">规格:{$vo['color_name']}{$vo['cate_name']}</p>
                                            {/if}

                                        </div>
                                        <div class="sorder-btnas floatfalse">
                                            <div class="sorder-num floatleft">数量：<span class="goods_num">{$vo['goods_num']}</span></div>
                                            <div class="sorder-btnnum floatright">
                                                <input type="button" value="-" class="sorder-jian sordernum{$vo.cart_id}" data-price="{$vo.goods_price}" data-cartid="{$vo.cart_id}" >
                                                <input type="text" value="{$vo['goods_num']}" class="sorder-text" oninput="sorderNum(this)">
                                                <input type="button" value="+" class="sorder-jia sordernum{$vo.cart_id}" data-price="{$vo.goods_price}" data-cartid="{$vo.cart_id}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            {/volist}
                            <li class="sorder-li addressso-all">
                                <div class="addressso-1 floatleft">
                                    收货地址
                                </div>
                                <div class="addressso-2 floatleft" id="addressbtns">
                                    <div class="addressso-21 floatleft">
                                        {if isset($submitOrdersInfo['address_default']['ads_name'])}
                                            <p id="addressnamb">{$submitOrdersInfo['address_default']['ads_name']} {$submitOrdersInfo['address_default']['ads_mobile']}</p>
                                            <p id="addresstext">{$submitOrdersInfo['address_default']['tcgaddress']}</p>
                                        {else/}
                                            <p id="addressnamb">暂无收货地址</p>
                                            <p id="addresstext"></p>
                                        {/if}
                                    </div>
                                    <div class="address-icon floatright"><i class="Hui-iconfont"></i></div>
                                </div>
                            </li>
                            <li class="sorder-li wuliu">
                                <div class="floatleft wuliu-1">物流方式</div>
                                <div class="floatleft wuliu-2 wuliu-btn">
                                    <p class="floatleft wuliu-2p1 wuliu-text">申通快递</p>
                                    <p class="floatright"><i class="Hui-iconfont"></i></p>
                                </div>
                            </li>
                            <li class="sorder-li mliuyan">
                                <div class="mliuyan-1">给卖家留言：</div>
                                <div class="mliuyan-2">
                                    <input type="text" value="" name="" class="mliuyan-input" placeholder="输入留言内容" oninput="leaveMessage(this)"/>
                                </div>
                            </li>
                            <li class="sorder-li gongji">
                                <div class="gongji-one floatright">
                                    <p class="gongji-botp">
                                        总运费<span class="color-red">￥{$submitOrdersInfo['totalFreight']}</span>，
                                        共<span class="goods_num_all">{$submitOrdersInfo['cart_goods_num']}</span>件，实付<strong class="total_price">￥{$submitOrdersInfo['cart_total_price']}</strong></p>
                                </div>
                            </li>
                            <li class="sorder-li wuliu">
                                <div class="floatleft wuliu-1">优惠券</div>
                                <div class="floatleft wuliu-2 goodsyouhui-btn">
                                    <p class="floatleft wuliu-2p1" id="youhuiamount">
                                        {if isset($submitOrdersInfo['copon_receive_mlist'][0])}
                                            有优惠券可用
                                        {else/}
                                            无优惠券可用
                                        {/if}
                                    </p>
                                    <p class="floatright"><i class="Hui-iconfont"></i></p>
                                </div>
                            </li>
                            <li class="sorder-li pay-all">
                                <div class="payall-1">
                                    <p class="floatleft">支付方式</p>
                                    <p class="floatright">我的余额：{$submitOrdersInfo['forehead']}</p>
                                </div>
                                <div class="payall-2 floatfalse">
                                    {volist name="submitOrdersInfo['payment_list']" id="vo"}
                                    <div class="payall-2auto {if $vo['payment_mark']=='balance'}paybacg{/if}" data-paytype="{$vo['payment_mark']}">
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
                        </ul>
                    </form>
                </div>

            </div>

            <div class="windowcont">
                <div class="windowcont-bacg"></div>
                <div class="windowcont-div">
                    <div class="windowcont-auto">
                        <div class="windowcont-title">选择收货地址 <a href="{:url('member/member_address')}" class="addressgl floatright">地址管理</a></div>
                        <ul class="windowcont-ul" id="windowcontliid">
                            {volist name="submitOrdersInfo['address_list']" id="vo" key="index"}
                            <li class="windowcont-li" data-adsid="{$vo['ads_id']}"><p>{$index}.{$vo['ads_name']} {$vo['ads_mobile']} {$vo['tcgaddress']}</p>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
            </div>                    

            <div class="wuliuxuan">
                <div class="wuliuxuan-bacg"></div>
                <div class="wuliuxuan-div">
                    <div class="wuliuxuan-auto">
                        <div class="wuliuxuan-title">选择物流方式</div>
                        <ul class="wuliuxuan-ul">
                            {volist name="submitOrdersInfo['courier_list']" id="vo"}
                            <li class="wuliuxuan-li" data-couid="{$vo['id']}"><p>{$vo['cou_name']}</p></li>
                                    {/volist}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="goodsyhq">
                <div class="goodsyhq-wd"></div>
                <div class="goodsyhq-auto">
                    <div class="goodsyhq-title">可使用的优惠券</div>
                    <ul class="goodsyhq-ul">
                        {volist name="submitOrdersInfo['copon_receive_mlist']" id="vo"}
                        <li class="goodsyhq-li">
                            <div class="goodsyhqli-auto">
                                <div class="goodsyhqdiv floatleft">
                                    <p class="goodsyhq-num">￥{$vo['cop_price']}</p>
                                    <p class="goodsyhq-jiage">满{$vo['full_amount']}可使用此优惠券</p>
                                </div>
                                <div class="goodsyhq-lq floatright yoouhui-btn"
                                     data-amount="{$vo['cop_price']}" data-type="{$vo['type']}" data-typeid="{$vo['type_id']}"
                                     data-fullamount="{$vo['full_amount']}" data-crid="{$vo['id']}">
                                    <p class="goodsyhq-lqp">使用</p>
                                </div>
                            </div>
                        </li>
                        {/volist}

                    </ul>
                </div>
                <?php
                $couId = 0;
                if(isset($submitOrdersInfo['courier_list'][0])){
                $couId = $submitOrdersInfo['courier_list'][0]['id'];
                }
                ?>
                <form action="" method="post" name="formsubmit" id="formsubmit">
                    {volist name="submitOrdersInfo['cart_list']" id="vo"}
                    <input type="hidden" value="{$vo['goods_id']}" name="goods_id[]" id="goods_id{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['n_id']}" name="n_id[]" id="n_id" />
                    <input type="hidden" value="{$vo['cate_id']}" name="cate_id[]" id="cate_id{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['goods_num']}" name="goods_num[]" id="goods_num{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['goods_price']}" name="goods_price[]" class="goods_price{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['goods_price']}" name="same_goods_price[]" class="gprice{$vo.goods_id} storeprice{$vo.store_id}" cartid="{$vo.cart_id}"/>
                    <input type="hidden" value="{$vo['total_price']}" name="total_price[]" id="total_price{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['color_name']}{$vo['cate_name']}" name="goods_information[]" id="goods_information{$vo.cart_id}" />
                    <input type="hidden" value="{$vo['activity']}" name="activity[]" id="activity" />
                    <input type="hidden" value="{$vo['setup_norm']}" name="setup_norm[]" id="setup_norm" />
                    <input type="hidden" value="{$vo['spell_list_m_id']}" name="first_member_id[]" id="first_member_id"/>
                    <input type="hidden" value="{$vo['sgm_id']}" name="sgm_id[]" id="sgm_id"/>
                    <input type="hidden" value="{$vo['store_id']}" name="store_id[]" id="store_id"/>
                    <input type="hidden" value="{$vo['cart_id']}" name="cart_id[]" id="cart_id"/>
                    <input type="hidden" value="{$vo['copon_receive_id']}" name="copon_receive_id[]" id="copon_receive_id{$vo.cart_id}" />
                    {/volist}

                    <input type="hidden" value="" name="leave_message" id="leave_message" />
                    <input type="hidden" value="{if isset($submitOrdersInfo['address_default']['ads_id'])}
                           {$submitOrdersInfo['address_default']['ads_id']}{else/}0{/if}" name="ads_id" id="ads_id" />
                               <input type="hidden" value="{$couId}" name="cou_id" id="cou_id" />

                               <input type="hidden" value="balance" name="payment_type" id="payment_type" />
                               <input type="hidden" value="{$submitOrdersInfo['cart_goods_num']}" name="goods_num_all" id="goods_num_all" />
                               <input type="hidden" value="{$submitOrdersInfo['cart_total_price']}" name="cart_total_price" id="cart_total_price" readonly/>
                               <input type="hidden" value="{$submitOrdersInfo['cart_total_price']}" name="same_price" id="same_price" />
                           </form>
                    </div>
                    <div class="sorder-bottom htmlwidth">
                        <div class="sorder-bottext floatleft">
                            <p class="sorder-botp">共<span class="goods_num_all">{$submitOrdersInfo['cart_goods_num']}</span>件，实付<strong class="total_price">￥{$submitOrdersInfo['cart_total_price']}</strong></p>
                        </div>
                        <div class="sorder-btn floatright" id="pay_submit">提交订单</div>
                    </div>
                </div>
                <script type="text/javascript" src="__MOBILE__/js/order/submit_orders.js"></script>
            </body>
        </html>
