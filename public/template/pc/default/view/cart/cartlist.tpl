<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的购物车</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/submit_orders.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/cart/cartlist.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            {include file="public/directory_top" /}
            <div class="goodsdetails-all pcdiv-auto">
                <div class="goodsdetails-title">
                    <ul class="goodsdetails-tul">
                        <li>我的购物车<span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span></li>
                        <li>全部商品({$cartCount})</li>
                    </ul>
                    <div class="empty_cart"><a href="javascript:;" onclick="emptyCart(this)">清空购物车</a></div>
                </div>
                <div class="cart_divall">
                    <form class="layui-form" action="{:url('order/cart_order_submit')}" method="post" lay-filter="example" id="cartlistform" name="cartlistform">
                        <ul class="cart_uls">
                            <li>
                                <div class="churuzhang">
                                    <table border="1" class="churuzhang-tb">
                                        <thead class="churuzhang-te">
                                            <tr>
                                                <th width="100">选择</th>
                                                <th>商品信息</th>
                                                <th>数量</th>
                                                <th>实付</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody class="churuzhang-ty">
                                            {volist name="cartList" id="vo"}
                                            <tr class="tbcenter">
                                                <td>
                                                    <input type="checkbox" name="cartid[]" value="{$vo.cart_id}" lay-skin="primary" lay-filter="c_one" class="cart_id"/>
                                                </td>
                                                <td>
                                                    <div class="goods-alls">
                                                        <div class="goods-img floatleft">
                                                            <img src="__STATIC__{$vo.goods_img}">
                                                        </div>
                                                        <div class="goods-text floatleft">
                                                            {eq name="vo['activity']" value="seconds_kill"}
                                                            <p class="color-green">秒杀商品</p>
                                                            {/eq}
                                                            {eq name="vo['activity']" value="spell_group"}
                                                            <p class="color-green">拼团商品</p>
                                                            {/eq}
                                                            {eq name="vo['activity']" value="comdysalesp"}
                                                            <p class="color-green">促销商品</p>
                                                            {/eq}
                                                            <div class="goods-name">{$vo.goods_name}</div>
                                                            <div class="goods-price">￥{$vo.goods_price}                                                      </div>
                                                            <div class="goods-guige" data-nid="{$vo.n_id}" data-goodsid="{$vo.goods_id}" data-cartid="{$vo.cart_id}">
                                                                <p class="sorder-qitagg floatleft">规格:{$vo.goods_information}</p>
                                                                <p class="cart-qger floatright"><i class="Hui-iconfont">&#xe6d7;</i></p>
                                                            </div>
                                                        </div>
                                                        <p class="floatfalse floatleft">某某旗舰店</p>
                                                    </div>
                                                    <input type="hidden" value="{$vo.goods_num}" id="goods_nums{$vo.cart_id}" />
                                                    <input type="hidden" value="{$vo.goods_price}" id="goods_prices{$vo.cart_id}" />
                                                    <input type="hidden" value="{$vo.total_price}" class="total_price{$vo.cart_id}" />
                                                    <input type="hidden" value="{$vo.courier_price}" class="courier_price{$vo.cart_id}" />
                                                </td>
                                                <td>
                                                    <div class="goodsnum-text cart-btnnum">
                                                        <input type="button" value="-" class="goods_num_jian" data-cartid="{$vo.cart_id}" onclick="cartJian(this)">
                                                        <input type="text" value="{$vo.goods_num}" class="goods_num cgoods_num" oninput="sorderNum(this)" disabled="">
                                                        <input type="button" value="+" class="goods_num_jia" data-cartid="{$vo.cart_id}" onclick="cartJia(this)">
                                                    </div>
                                                </td>
                                                <td><div class="goods-price" id="total_price{$vo.cart_id}">￥<span id="total_prices{$vo.cart_id}">{$vo.total_price}</span></div></td>
                                                <td>
                                                    <input type="button" value="删除" class="cart_del" data-cartid="{$vo.cart_id}" onclick="delCart(this)">
                                                </td>
                                            </tr>
                                            {/volist}

                                        </tbody>
                                    </table>
                                    {if empty($cartList)}
                                        <div class="wushuju_text">购物车暂无数据</div>
                                    {/if}
                                </div>
                            </li>

                        </ul>
                        <div class="addressso-all sorderbot">
                            <div class="sorder-bottom htmlwidth">
                                <div class="cart-quanxuan floatleft">
                                    <input type="checkbox" name="allid" lay-skin="primary" id="c_all" lay-filter="c_all" title="全选"/>
                                </div>
                                <div class="sorder-btn floatright" onclick="cartlistBtn(this)">立即付款</div>
                                <div class="sorder-bottext floatright">
                                    <p class="sorder-botp">
                                        总运费<span class="color-red">￥<i id="courier_price_all">0.00</i></span>，
                                        共<span class="goods_num_all">1</span>件，实付<strong class="total_price">￥<span id="cart_price">0.00</span></strong></p>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form action="" method="post" name="cartoneform">
                <input type="hidden" value="" class="cart_one_id" name="cart_id"/>
                <input type="hidden" value="" class="n_one_id" name="n_id"/>
                <input type="hidden" value="" class="cate_one_id" name="cate_id"/>
                <input type="hidden" value="" class="goods_one_num" name="goods_num"/>
                <input type="hidden" value="" class="goods_one_price" name="goods_price"/>
                <input type="hidden" value="" class="total_one_price" name="total_price"/>
            </form>
            {include file="public/goods/goods_choose" /}
            {include file="public/bottom" /}

        </div>
        <script type="text/javascript" src="__PC__/js/cart/cartlist.js"></script>
        <script type="text/javascript" src="__PC__/js/cart/cartsubmit.js"></script>
    </body>
</html>
