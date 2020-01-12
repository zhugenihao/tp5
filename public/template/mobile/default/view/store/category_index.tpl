<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>分类商品</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/store/index.css" />

    </head>
    <body>
        {include file="public/store_top" /}
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="home-all allas">

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
                        <li class="cate-li">
                            <a href="{:url('store/index')}" class="storeid_a">
                                <p class="giconp">
                                    <i class="Hui-iconfont">&#xe625;</i> 
                                </p>
                                <p>首页</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="advertsas">
                    <a href="javascript:;"><img src="__STATIC__/{$store['banner']}" class="advertsas-img"/></a>
                </div>
                <div class="goods_type">
                    <div class="goodstype_1">
                        <div class="goodspce_title">商品筛选：</div>
                        <ul class="goodspce_ul" id="goods_type">
                            <li>
                                <a href="javascript:;" type="sales" class="goodstype_btn ">销量</a>
                            </li>
                            <li>
                                <a href="javascript:;" type="goodwill" class="goodstype_btn ">好感</a>
                            </li>
                            <li>
                                <a href="javascript:;" type="high-low" class="goodstype_btn ">从高到低</a>
                            </li>
                            <li>
                                <a href="javascript:;" type="low-high" class="goodstype_btn ">从低到高</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="tejiayouhui-all floatfalse" id="goods_alldiv">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">{$categoryTitle}</div>
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
        <input type="hidden" value="{:input('cat_id')}" id="cat_id" />
        <input type="hidden" value="{:input('directory1_id')}" id="directory1_id" />
        <input type="hidden" value="{:input('directory2_id')}" id="directory2_id" />
        <input type="hidden" value="{:input('directory3_id')}" id="directory3_id" />
        <script type="text/javascript" src="__MOBILE__/js/store/category_index.js"></script>

    </body>
</html>
