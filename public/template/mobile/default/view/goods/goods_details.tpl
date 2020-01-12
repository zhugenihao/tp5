<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商品详情</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/goods/goods_details.css" />
        {include file="public/swiper" /}
    </head>
    <body>
        <div class="youslie" id="youslieid">
            <ul class="youslie-ul">
                <li class="youslie-li">
                    <a href="{:url('index/index')}">
                        <i class="Hui-iconfont">&#xe625;</i>
                        <span>首页</span>
                    </a>
                </li>
                <li class="youslie-li">
                    <a href="">
                        <i class="Hui-iconfont">&#xe6ab;</i>
                        <span>分享</span>
                    </a>
                </li>
                <li class="youslie-li">
                    <a href="javascript:;" onclick="addCollection(this)">
                        {if $goodsInfo['is_collection']}
                            <i class="Hui-iconfont color-red">&#xe69d;</i>
                        {else/}
                            <i class="Hui-iconfont">&#xe69e;</i>
                        {/if}
                        <span>收藏</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="details-all allas">
                <div class="details-lunbo">
                    <div class="swiper-container lunboauto">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><a href="javascript:;"><img src="__STATIC__{$goodsInfo['thecover']}"/></a></div>
                                    {volist name="goodsInfo['gallery_list']" id="vo"}
                            <div class="swiper-slide"><a href="javascript:;"><img src="__STATIC__{$vo['img_big']}"/></a></div>
                                    {/volist}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="goodstext1">
                    <div class="goodstext1-auto">
                        <div class="goodstext1-title floatleft">
                            <p class="goodstext1-text">{$goodsInfo['goods_name']}</p>
                            <p class="goods-jisge">
                                {if input('activity')=='seconds_kill'}
                                    秒杀商品 ￥{$secondsKillInfo['sk_price']}
                                {elseif input('activity')=='spell_group' /} 
                                    拼团商品 ￥{$spellGroupInfo['sg_price']}
                                {elseif input('activity')=='comdysalesp' /} 
                                    {if $comdysalespInfo['cp_type']==1}
                                        打折商品({$comdysalespInfo['discount']}折) ￥{$goodsInfo['goods_price']*($comdysalespInfo['discount']/10)}
                                        <br/><span class="color-hui">原价：{$goodsInfo['goods_price']}</span>
                                    {elseif $comdysalespInfo['cp_type']==2}
                                        降价商品 ￥{$comdysalespInfo['cp_price']}
                                        <br/><span class="color-hui">原价：{$goodsInfo['goods_price']}</span>
                                    {else/}
                                        其他
                                    {/if}
                                {else /}
                                    ￥{$goodsInfo['goods_price']}
                                {/if}

                            </p>
                        </div>
                        <div class="goodstext1-dianzan floatright" id="givealikeBtn" data-goodsid="{$goodsInfo['goods_id']}">
                            <p class="goodstext1-icon">
                                {if $goodsInfo['is_givealike'] > 0}
                                    <i class="Hui-iconfont">&#xe648;</i>
                                {else/}
                                    <i class="Hui-iconfont">&#xe649;</i>
                                {/if}
                            </p>
                            <p class="goodstext1-icont">喜欢</p>
                        </div>
                    </div>
                    <div class="goodstext1-sd floatfalse">

                        <div class="goodstext1-num floatleft">月销量{$goodsInfo['sales']}件</div>

                        <div class="goodstext1-diqu floatright">{$goodsInfo['region']}</div>
                    </div>
                </div>
                {if input('activity')==''}
                    <div class="goodsyouhui">
                        <div class="goodsyouhui-auto">
                            <div class="goodsyouhui-title floatleft">领取优惠券</div>
                            <div class="goodsyouhui-icon floatright goodsyouhui-btn"><i class="Hui-iconfont">&#xe6f9;</i></div>
                        </div>
                    </div>
                {/if}
                {if $goodsInfo['setup_norm']=='on'}
                    <div class="goodsyouhui">
                        <div class="goodsyouhui-auto">
                            <div class="goodsyouhui-title floatleft">选择规格</div>
                            <div class="goodsyouhui-icon floatright goodguige-btn"><i class="Hui-iconfont">&#xe6f9;</i></div>
                        </div>
                    </div>
                {/if}

                {if input('activity')=='spell_group'}
                    {include file="public/goods/spell_list" /}
                {/if}
                <div class="goodspinjia">
                    <div class="goodspinjia-auto">
                        <div class="goodspinjia-top">
                            <div class="goodspinjia-title floatleft">商品评价</div>
                            <div class="goodspinjia-gengduo floatright">
                                <a href="{:url('comments/index',['goods_id'=>$goodsInfo['goods_id']])}">更多&nbsp;<i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>
                        </div>
                        <ul class="goodspinjia-ul floatfalse">
                            {volist name="goodsInfo['comments_list']['list']" id="vo"}
                            <li class="goodspinjia-li">
                                <div class="goodspinjia-member">
                                    <div class="goodspinjia-mauto floatleft">
                                        <div class="goodspinjia-mimg floatleft"><img src="__STATIC__/{$vo['member']['photo']}" /></div>
                                        <div class="goodspinjia-mname floatleft">{$vo['member']['member_name']}</div>
                                    </div>
                                    <div class="goodspinjia-mtime floatright">{$vo['create_time']}</div>
                                </div>
                                <div class="goodspinjia-mtext floatfalse">{$vo['texts']}</div>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
                <div class="goodsnixi floatfalse">
                    <div class="goodsnixi-auto">
                        <div class="goodsnixi-title">猜你喜欢</div>
                        <ul class="goodsnixi-ul">
                            {volist name="goodsInfo['sales_goods_list']['list']" id="vo"}
                            <li class="goodsnixi-li">
                                <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                    <div class="goodsnixi-img"><img src="__STATIC__{$vo['thecover']}" /></div>
                                    <div class="goods-name">{$vo['goods_name']}</div>
                                    <div class="goods-jisge">￥{$vo['goods_price']}</div>
                                </a>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
                <div class="goodsintroduce floatfalse">
                    <div class="goodsintroduce-title">
                        <div class="goodsintroducet-auto">
                            <div class="goodsintroduce-t1 activein">商品介绍</div>
                            <div class="goodsintroduce-t2">商品参数</div>
                        </div>

                    </div>
                    <div class="goodsintroduce-text">
                        <div class="goodsintroduce-tex1" style="display: block">
                            {$goodsInfo['goods_desc']|htmlspecialchars_decode}
                        </div>
                        <div class="goodsintroduce-tex2">{$goodsInfo['goods_desc2']|htmlspecialchars_decode}</div>
                    </div>
                </div>
            </div>
            {if input('activity')==''}       
                <div class="goodsyhq">
                    <div class="goodsyhq-wd"></div>
                    <div class="goodsyhq-auto">
                        <div class="goodsyhq-title">可领取优惠券</div>
                        <ul class="goodsyhq-ul">
                            {volist name="goodsInfo['coupon_list']" id="vo"}
                            <li class="goodsyhq-li">
                                <div class="goodsyhqli-auto">
                                    <div class="goodsyhqdiv floatleft">
                                        <p class="goodsyhq-num">￥{$vo['cop_price']}</p>
                                        <p class="goodsyhq-jiage">满{$vo['full_amount']}可使用此优惠券(还有{$vo['cop_num']}张)</p>
                                    </div>
                                    <div class="goodsyhq-lq floatright" data-copid="{$vo['cop_id']}">
                                        <p class="goodsyhq-lqp" data-copid="{$vo['cop_id']}">领取</p>
                                    </div>
                                </div>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
            {/if}
            <div class="cart-guige htmlwidth">
                <div class="cart-guigeer"></div>
                <div class="cart-guige-auto">
                    <div class="cart-guigetop">
                        <div class="cart-guigetaut">
                            <div class="cart-guigeimg floatleft">
                                <img src="__STATIC__/{$goodsInfo['thecover']}" />
                            </div>
                            <div class="cart-guigeshuj floatleft">
                                <div class="cart-guigejiage">
                                    <div id="spanprice">
                                        {if input('activity')=='seconds_kill'}
                                            秒杀商品 ￥<span id="spanprice-i">{$secondsKillInfo['sk_price']}</span>
                                        {elseif input('activity')=='spell_group' /} 
                                            拼团商品 ￥<span id="spanprice-i">{$spellGroupInfo['sg_price']}</span>
                                        {elseif input('activity')=='comdysalesp' /} 
                                            {if $comdysalespInfo['cp_type']==1}
                                                打折商品({$comdysalespInfo['discount']}折) ￥
                                                <span id="spanprice-i">{$goodsInfo['goods_price']*($comdysalespInfo['discount']/10)}</span>
                                                <p class="color-hui">原价：￥<span id="orgprice">{$goodsInfo['goods_price']}</span></p>
                                                {elseif $comdysalespInfo['cp_type']==2}
                                                降价商品 ￥{$comdysalespInfo['cp_price']}
                                                <p class="color-hui">原价：￥<span id="orgprice">{$goodsInfo['goods_price']}</span></p>
                                                {else/}
                                                其他
                                            {/if}
                                        {else /}
                                            ￥<span id="spanprice-i">{$goodsInfo['goods_price']}</span>
                                        {/if}
                                    </div>
                                </div>
                                <p class="cart-guigekc">库存<span id="spannshu">{$goodsInfo['goods_stock']}</span>件</p>
                            </div>
                            <p class="cart-guigeyx floatfalse">已选：
                                <span class="yansetext">
                                    {if isset($goodsInfo['goods_color_list'][0])}
                                        {$goodsInfo['goods_color_list'][0]['color_name']}
                                    {/if}
                                </span>，
                                <span class="banbentext">
                                    {if isset($goodsInfo['cates_list'][0])}
                                        {$goodsInfo['cates_list'][0]['cate_name']}
                                    {/if}
                                </span>，
                                <span class="goodsnum">1</span>个
                            </p>
                        </div>
                    </div>
                    <div class="cart-yanse">
                        <div class="cart-yanseauto">
                            <div class="cart-ystitle">颜色类型</div>
                            <ul class="cart-yanseul" id="cartyanse">
                                {volist name="goodsInfo['goods_color_list']" id="vo" key="index"}
                                <li class="cart-yanseli {if $index==1}active-lx {/if}" data-id="{$vo['id']}">{$vo['color_name']}</li>
                                    {/volist}
                            </ul>
                        </div>
                    </div>
                    <div class="cart-yanse">
                        <div class="cart-yanseauto">
                            <div class="cart-ystitle">版本类型</div>
                            <ul class="cart-yanseul" id="cartbanben">
                            </ul>
                        </div>
                    </div>
                    <div class="cart-btnas floatfalse">
                        <div class="cart-guigenum">
                            <div class="cart-num floatleft">数量：<span id="cartnum">1</span></div>
                            <div class="cart-btnnum floatright">
                                <input type="button" value="-" name="cart-jian" class="cart-jian"/>
                                <input type="text" value="1" name="cart-text" class="cart-text" oninput="cartText(this)"/>
                                <input type="button" value="+" name="cart-jia" class="cart-jia"/>
                            </div>
                        </div>

                    </div>
                </div>
                <?php 
                $cateId = '';
                if(isset($goodsInfo['cates_list'][0])){
                $cateId = $goodsInfo['cates_list'][0]['cate_id'];
                }
                ?>
                <form action="{:url('order/submit_orders')}" method="post" name="formsubmit" id="formsubmit">
                    <input type="hidden" value="{$goodsInfo['goods_id']}" id="goods_id" name="goods_id" />
                    <input type="hidden" value="{$goodsInfo['default_norm_info']['n_id']}" id="n_id" name="n_id" />
                    <input type="hidden" value="{$cateId}" id="cate_id" name="cate_id" />
                    <input type="hidden" value="{$goodsInfo['goods_price']}" id="goods_price" name="goods_price" />
                    <input type="hidden" value="1" id="goods_num" name="goods_num" />
                    <input type="hidden" value="buy" id="submit_type" name="submit_type" />
                    <input type="hidden" value="{:input('activity')}" name="activity" id="activity"/>
                    <input type="hidden" value="{$goodsInfo['setup_norm']}" name="setup_norm" id="setup_norm"/>
                    <input type="hidden" value="{$goodsInfo['store_id']}" name="store_id" id="store_id"/>
                    <input type="hidden" value="0" name="first_member_id" id="first_member_id"/>
                    <input type="hidden" value="0" name="sgm_id" id="sgm_id"/>
                </form>
            </div>
            <div class="goodsbtn htmlwidth">
                <div class="goodsbtn-auto">
                    <ul class="goodsbtn-ul">
                        <li class="goodsbtn-li goodsbtn-sgk">
                            <div class="goodsbtnsgk-1">
                                {if $goodsInfo['store_id']>0}
                                    <a href="{:url('store/index',['store_id'=>$goodsInfo['store_id']])}">
                                        <p class="goodsbtnsgk-icon"><i class="Hui-iconfont">&#xe66a;</i></p>
                                        <p class="goodsbtnsgk-name">商铺</p>
                                    </a>    
                                {else/}
                                    <a href="javascript:;">
                                        <p class="goodsbtnsgk-icon"><i class="Hui-iconfont">&#xe66a;</i></p>
                                        <p class="goodsbtnsgk-name">自营</p>
                                    </a>
                                {/if}
                            </div>
                            <div class="goodsbtnsgk-1 cartshuliangall">
                                <a href="{:url('cart/cartlist')}?type=cart">
                                    <p class="cartshuliang">{$cartCount}</p>
                                    <p class="goodsbtnsgk-icon"><i class="Hui-iconfont">&#xe670;</i></p>
                                    <p class="goodsbtnsgk-name">购物车</p>
                                </a>
                            </div>
                            <div class="goodsbtnsgk-1">
                                <a href='javascript:;' id="socketa" url="{:url('socket/index/index',['kefu_id'=>$kefu['id'],'goods_id'=>$goodsInfo['goods_id']])}">
                                    <p class="goodsbtnsgk-icon"><i class="Hui-iconfont">&#xe6d0;</i></p>
                                    <p class="goodsbtnsgk-name">客服</p>
                                </a>
                            </div>
                        </li>
                        <!--商品秒杀-->
                        {if input('activity')=='seconds_kill'}
                            <li class="goodsbtn-li goodsbtn-gwc add_buy" data-type="cart" data-buytype="seconds_kill">加入购物车</li>
                            <li class="goodsbtn-li goodsbtn-ljgm add_buy" data-type="buy" data-buytype="seconds_kill">立即抢购</li>
                            <!--商品拼团-->
                        {elseif input('activity')=='spell_group'}
                            <li class="goodsbtn-li goodsbtn-gwc2 add_buy" data-type="buy" data-buytype="a_separate_buy">单独购买</li>
                            <li class="goodsbtn-li goodsbtn-ljgm add_buy sepll_buy" data-type="buy" data-buytype="spell_group">立即拼团</li>
                            <!--促销商品-->
                        {elseif input('activity')=='comdysalesp'}
                            <li class="goodsbtn-li goodsbtn-gwc add_buy" data-type="cart" data-buytype="comdysalesp">加入购物车</li>
                            <li class="goodsbtn-li goodsbtn-ljgm add_buy" data-type="buy" data-buytype="comdysalesp">立即抢购</li>
                            <!--普通购买-->
                        {else /}
                            <li class="goodsbtn-li goodsbtn-gwc add_buy" data-type="cart" data-buytype="a_separate_buy">加入购物车</li>
                            <li class="goodsbtn-li goodsbtn-ljgm add_buy" data-type="buy" data-buytype="a_separate_buy">立即购买</li>
                            {/if}
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/goods/goods_details.js"></script>
    </body>
</html>
