<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{$directoryTitle}</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/goods/clothing_store.css" />
        {include file="public/swiper" /}
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="home-all allas">
                <div class="home-lunbo">
                    <div class="lunbo-auto swiper-container">
                        <div class="swiper-wrapper">
                            {volist name="advertList" id="vo"}
                            <div class="swiper-slide"><a href="{$vo['adv_link']}"><img src="__STATIC__/{$vo['dire']}"/></a></div>
                                    {/volist}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="lunbo-rd"></div>
                </div>
                <div class="home-cate">
                    <ul class="cate-ul">
                        {volist name="directoryList" id="vo"}
                        <li class="cate-li">
                            <a href="{:url($vo['home_template_m'],['dir_id'=>$vo['id'],'typeclassif'=>'classification'])}">
                                <p class="giconp">
                                    <i class="Hui-iconfont">
                                        {if $vo['small_icon'] > 0}
                                            {$small_icon[$vo['small_icon']]['icon']}
                                        {/if}
                                    </i> 
                                </p>
                                <p>{$vo.title}</p>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>

                <div class="advertsas">
                    {if $clothing_store_advert20['dire']!=''}
                        <a href="{$clothing_store_advert20['adv_link']}"><img src="__STATIC__/{$clothing_store_advert20['dire']}" class="advertsas-img"/></a>
                        {/if}
                </div>

                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">为你推荐</div>
                            <div class="tejiayouhui-gd">
                                <a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}" >更多<i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul">
                        {volist name="clothingGoodsList" id="vo"}
                        <li class="tejiayouhui-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="tejiayouhui-img"><img src="__STATIC__{$vo['thecover']}" /></div>
                                <div class="tejiayouhui-title">{$vo['goods_name']}</div>
                                <div class="tejiayouhui-bottom">
                                    <span class="tejiayouhui-jiage">￥{$vo['goods_price']}</span>
                                    <span class="tejiayouhui-xl">{$vo['number_payment']}人付款</span>
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>

            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/goods/clothing_store.js"></script>

    </body>
</html>
