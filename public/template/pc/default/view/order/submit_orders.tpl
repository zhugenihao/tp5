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
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/submit_orders.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            {include file="public/directory_top" /}
            <div class="goodsdetails-all pcdiv-auto">
                <div class="goodsdetails-title">
                    <ul class="goodsdetails-tul">
                        <li>全部<span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span></li>
                        <li>提交订单信息</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>
                            <div class="churuzhang">
                                <table border="1" class="churuzhang-tb">
                                    <thead class="churuzhang-te">
                                        <tr>
                                            <th>商品信息</th>
                                            <th>数量</th>
                                            <th>小计</th>
                                        </tr>
                                    </thead>
                                    <tbody class="churuzhang-ty">
                                        {volist name="submitOrdersInfo['cart_list']" id="vo"}
                                        <tr class="tbcenter">
                                            <td>
                                                <div class="goods-alls">
                                                    <div class="goods-img floatleft">
                                                        <img src="__STATIC__/{$vo['goods_img']}">
                                                    </div>
                                                    <div class="goods-text floatleft">
                                                        <div class="goods-name">{$vo['goods_name']}</div>
                                                        <div class="goods-price">￥{$vo['goods_price']}
                                                            {if $vo['hasbeenused_copon']}，已优惠￥{$vo['hasbeenused_copon']['cop_price']}{/if}
                                                        </div>
                                                        <div class="goods-guige">
                                                            {if $vo['setup_norm']!='off'}
                                                                <p class="sorder-qitagg floatleft">规格:{$vo['color_name']}{$vo['cate_name']}</p>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <p class="floatfalse floatleft">某某旗舰店</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="goodsnum-text sorder-btnnum">
                                                    <input type="button" value="-" class="goods_num_jian sorder-jian sordernum{$vo.cart_id}" data-price="{$vo.goods_price}" data-cartid="{$vo.cart_id}"/>
                                                    <input type="text" value="{$vo['goods_num']}" class="goods_num sorder-text" oninput="sorderNum(this)" disabled=""/>
                                                    <input type="button" value="+" class="goods_num_jia sorder-jia sordernum{$vo.cart_id}" data-price="{$vo.goods_price}" data-cartid="{$vo.cart_id}"/>
                                                </div>
                                            </td>
                                            <td><div class="goods-price">￥{$vo['total_price']}</div></td>
                                        </tr>
                                        {/volist}
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li class="addressso-all addressso-sh">
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
                                <div class="address-icon floatright" id="shouhuoul_btn"><i class="Hui-iconfont"></i></div>
                            </div>
                            <div class="shouhuo-ul" id="shouhuoul">
                                <div class="windowcont-title"><span>选择收货地址</span>
                                    <a href="{:url('member/member_address')}" class="addressgl floatright">地址管理</a>
                                </div>
                                <ul>
                                    {if $submitOrdersInfo['address_list']}
                                        {volist name="submitOrdersInfo['address_list']" id="vo" key="index"}
                                        <li class="shouhuo-li" data-adsid="{$vo['ads_id']}">{$index}.{$vo['ads_name']} {$vo['ads_mobile']} {$vo['tcgaddress']}</li>
                                            {/volist}
                                        {else}<li class="shouhuo-li">暂无收货地址</li>{/if}

                                </ul>
                            </div>

                        </li>
                        <li class="addressso-all addressso-sh">
                            <div class="floatleft wuliu-1">物流方式</div>
                            <div class="floatleft wuliu-2 wuliu-btn">
                                <p class="floatleft wuliu-2p1 wuliu-text">国际快递</p>
                                <p class="floatright address-icon" id="shouhuoul_btn1"><i class="Hui-iconfont"></i></p>
                            </div>
                            <div class="shouhuo-ul" id="shouhuoul_1">
                                <div class="windowcont-title"><span>请选择快递</span>
                                </div>
                                <ul>
                                    {volist name="submitOrdersInfo['courier_list']" id="vo"}
                                    <li class="shouhuo-li" data-couid="{$vo['id']}">{$vo['cou_name']}</li>
                                        {/volist}
                                </ul>
                            </div>
                        </li>
                        <li class="addressso-all">
                            <div class="mliuyan-1">给卖家留言：</div>
                            <div class="mliuyan-2">
                                <input type="text" value="" name="" class="mliuyan-input" placeholder="输入留言内容" oninput="leaveMessage(this)">
                            </div>
                        </li>
                        <li class="addressso-all gongji">
                            <div class="gongji-one floatright">
                                <p class="gongji-botp">
                                    总运费<span class="color-red">￥{$submitOrdersInfo['totalFreight']}</span>
                                    共<span class="goods_num_all">1</span>件，实付<strong class="total_price">￥{$submitOrdersInfo['cart_total_price']}</strong></p>
                            </div>
                        </li>
                        <li class="addressso-all addressso-sh">
                            <div class="floatleft wuliu-1">优惠券</div>
                            <div class="floatleft wuliu-2 wuliu-btn">
                                <p class="floatleft wuliu-2p1" id="youhuiamount">
                                    {if isset($submitOrdersInfo['copon_receive_mlist'][0])}
                                        有优惠券可用
                                    {else/}
                                        无优惠券可用
                                    {/if}
                                </p>
                                <p class="floatright address-icon" id="shouhuoul_btn2"><i class="Hui-iconfont"></i></p>
                            </div>
                            <div class="shouhuo-ul" id="shouhuoul_2">
                                <div class="windowcont-title"><span>可使用的优惠券</span>
                                </div>
                                <ul>
                                    {if $submitOrdersInfo['copon_receive_mlist']}
                                        {volist name="submitOrdersInfo['copon_receive_mlist']" id="vo"}
                                        <li class="shouhuo-li yoouhui-btn" data-amount="{$vo['cop_price']}" data-type="{$vo['type']}" data-typeid="{$vo['type_id']}"
                                            data-fullamount="{$vo['full_amount']}" data-crid="{$vo['id']}">
                                            ￥{$vo['cop_price']}，满{$vo['full_amount']}可使用此优惠券</li>
                                            {/volist}
                                        {else}<li class="shouhuo-li">暂无优惠券</li>{/if}
                                </ul>
                            </div>
                        </li>
                        <li class="pay-all">
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
                        <li class="addressso-all sorderbot">
                            <div class="sorder-bottom htmlwidth">
                                <div class="sorder-bottext floatleft">
                                    <p class="sorder-botp">共<span class="goods_num_all">1</span>件，实付<strong class="total_price">￥{$submitOrdersInfo['cart_total_price']}</strong></p>
                                </div>
                                <div class="sorder-btn floatright" id="pay_submit">提交订单</div>
                            </div>
                        </li>
                    </ul>
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
                    </div>

                    {include file="public/bottom" /}

                </div>
                <script type="text/javascript" src="__PC__/js/order/submit_orders.js"></script>
            </body>
        </html>
