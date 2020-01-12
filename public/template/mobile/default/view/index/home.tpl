<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>首页</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
    </head>
    <body>
        <div class="allhtml">
            {include file="public/top" /}
            <div class="home-all allas">
                <div class="home-lunbo">
                    <div class="lunbo-auto swiper-container">
                        <div class="swiper-wrapper">
                            {volist name="advertList" id="vo"}
                            <div class="swiper-slide">
                                <a href="{$vo['adv_link']}"><img src="__STATIC__/{$vo['dire']}"/></a>
                            </div>
                            {/volist}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="lunbo-rd"></div>
                </div>
                <div class="home-cate floatfalse">
                    <ul class="cate-ul">
                        {volist name="category" id="vo"}
                        <li class="cate-li">
                            <a href="{:url($vo['methods'],['dir_id'=>$vo.dir_id])}" {if $vo['is_newwindow']==1}target="_blank"{/if}>
                                <i class="Hui-iconfont">
                                    {if $vo['small_icon'] > 0}
                                        {$small_icon[$vo['small_icon']]['icon']}
                                    {/if}
                                </i>
                                <p>{$vo.cat_name}</p>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>

                <div class="advertsas">
                    {if isset($common_advert[0])}
                        <a href="{$common_advert[0]['adv_link']}" ><img src="__STATIC__{$common_advert[0]['dire']}" class="advertsas-img" /></a>
                        {/if}
                </div>
                <div class="miaosa-all floatfalse">
                    <div class="miaosa-title">
                        <div class="miaosa-auto">
                            <ul class="miaosa-auto1">
                                <li class="miaosa-title1">秒杀活动</li>
                                <li class="miaosa-time" id="test-times"></li>
                            </ul>
                        </div>
                        <div class="miaosa-gd"><a href="{:url('seconds_kill/index')}" class="miaosa-gda">更多<i class="Hui-iconfont">&#xe6d7;</i></a></div>
                    </div>
                    <div class="miaosa-list">
                        <ul class="miaosa-listul" id="miaosaul">

                        </ul>
                        <p class="zanwumiaosha"></p>
                    </div>
                </div>
                <div class="advertsas floatfalse">
                    {if isset($common_advert[1])}
                        <a href="{$common_advert[1]['adv_link']}" ><img src="__STATIC__{$common_advert[1]['dire']}" class="advertsas-img" /></a>
                        {/if}
                </div>
                <div class="pintuan-all">
                    <div class="pintuan-top">
                        <div class="pintuan-topauto">
                            <div class="pintuan-toptitle">拼团特区</div>
                            <div class="pintuan-topgd"><a href="{:url('spell_group/index')}">更多<i class="Hui-iconfont">&#xe6d7;</i></a></div>
                        </div>
                    </div>
                    <ul class="pintuan-list">
                        {volist name="spellGroupList" id="vo"}
                        <li class="pintuan-li">
                            <div class="pintuan-liauto">
                                <div class="pintuan-img">
                                    <img src="__STATIC__{$vo['thecover']}" /> 
                                </div>
                                <div class="pintuan-text">
                                    <div class="pintuan-textauto">
                                        <p class="pintuan-title">{$vo['goods_name']}</p>
                                        <p class="pintuan-jiage">￥{$vo['sg_price']}</p>

                                    </div>
                                    <div class="pintuan-btn">
                                        <span class="pintuan-tishi">{$vo['sg_members_num']}个人就可以成团</span>
                                        <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'spell_group'])}" class="pintuan-btna">立即开团</a>
                                    </div>

                                </div>
                            </div>
                        </li>
                        {/volist}

                    </ul>
                </div>
                <div class="advertsas">
                    {if isset($common_advert[2])}
                        <a href="{$common_advert[2]['adv_link']}" ><img src="__STATIC__{$common_advert[2]['dire']}" class="advertsas-img" />
                        </a>
                    {/if}
                </div>
                <div class="tejiayouhui-all">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">促销优惠</div>
                            <div class="tejiayouhui-gd"><a href="{:url('comdysales_promotion/index')}">更多<i class="Hui-iconfont">&#xe6d7;</i></a></div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul">
                        {volist name="comdysalespList" id="vo"}
                        <li class="tejiayouhui-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'comdysalesp'])}">
                                <div class="tejiayouhui-img"><img src="__STATIC__{$vo['cp_img']}" /></div>
                                <div class="tejiayouhui-title">{$vo['cp_name']}</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥
                                        {eq name="vo['cp_type']" value="1"}{$vo['goods_price']}{/eq}
                                        {eq name="vo['cp_type']" value="2"}{$vo['cp_price']}{/eq}
                                    </span>
                                    <span class="tejiayouhui-xl">{$vo['number_payment']}人付款</span>
                                </div>
                                <div class="discount-g">
                                    {eq name="vo['cp_type']" value="1"}{$vo['discount']}{/eq}
                                    {eq name="vo['cp_type']" value="2"}优{/eq}
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>
                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">猜你喜欢</div>
                            <div class="tejiayouhui-gd"><a href="{:url('guess_you_like/index')}">更多<i class="Hui-iconfont">&#xe6d7;</i></a></div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul">
                        {volist name="salesGoodsList" id="vo"}
                        <li class="tejiayouhui-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="tejiayouhui-img"><img src="__STATIC__{$vo['thecover']}" /></div>
                                <div class="tejiayouhui-title">{$vo['goods_name']}</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥{$vo['goods_price']}</span>
                                    <span class="tejiayouhui-xl">销量:{$vo['sales']}</span>
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>
            </div>
            {include file="public/bottom" /}        
        </div>
        {include file="public/swiper" /}
        <script type="text/javascript" src="__MOBILE__/js/index/home.js"></script>

    </body>
</html>
