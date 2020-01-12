<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>店铺【{$store['store_name']}-{$store['level_name']}】</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/store/index.css" />

        {include file="public/swiper" /}
    </head>
    <body>
        {include file="public/store_top" /}
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="home-all allas">
                <div class="home-lunbo">
                    <div class="lunbo-auto swiper-container">
                        <div class="swiper-wrapper">
                            {volist name="advert" id="vo"}
                            <div class="swiper-slide">
                                <a href="{$vo['adv_link']}"><img src="__STATIC__/{$vo['dire']}"/></a>
                            </div>
                            {/volist}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="lunbo-rd"></div>
                </div>
                <div class="home-cate">
                    <ul class="cate-ul">
                        {volist name="category" id="vo"}
                        <li class="cate-li">
                            <a href="{:url('store/category_index',['cat_id'=>$vo['cat_id']])}" class="storeid_a">
                                <p class="giconp">
                                    <i class="Hui-iconfont">&#xe620;</i> 
                                </p>
                                <p>{$vo.cat_name}</p>
                            </a>
                        </li>
                        {/volist}
                        <li class="cate-li">
                            <a href="{:url('store/bcategory_index')}" class="storeid_a">
                                <p class="giconp">
                                    <i class="Hui-iconfont">&#xe681;</i> 
                                </p>
                                <p>全部分类</p>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="advertsas">
                    <a href="javascript:;"><img src="__STATIC__/{$store['banner']}" class="advertsas-img"/></a>
                </div>

                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">为你推荐</div>
                            <!--<div class="tejiayouhui-gd">
                                <a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}" >更多<i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>-->
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul">
                        {volist name="recommendGoods" id="vo"}
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
                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">全部商品</div>
                            <!--<div class="tejiayouhui-gd">
                                <a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}" >更多<i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>-->
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul" id="rolling-list">
                    </ul>
                </div>

            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/store/index.js"></script>

    </body>
</html>
