<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>店铺首页</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/store/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/store_top" /}

            <div class="lunbo-dadiv">
                <div class="lunbo-imglist">
                    <div class="layui-carousel" id="test3" lay-filter="test4">
                        <div carousel-item="">
                            {volist name="advert" id="vo"}
                            <div>
                                <a href="{$vo['adv_link']}" target="_blank"><img src="__STATIC__/{$vo['dire']}" /></a>
                            </div>
                            {/volist}
                        </div>
                    </div> 
                </div>
                <div class="lunbo-div pcdiv-auto">
                    <div class="categ-list">
                        <ul class="categlist-ul">
                            {volist name="bCategory" id="vo"}
                            <li class="categlist-li">
                                <a href="{:url('store/category_index',['directory1_id'=>$vo.directory1_id])}" class="categlistli-a storeid_a">{$vo.directory1_name}</a>
                                <ul class="categlister-ul">
                                    {volist name="vo['bCategory2']" id="vo2"}
                                    <li class="categlister-li">
                                        <div class="categlister-div">
                                            <a href="{:url('store/category_index',['directory2_id'=>$vo2.directory2_id])}" class="categlisterli-a storeid_a">{$vo2.directory2_name}</a></div>
                                        <div class="categlister-div2">
                                            <ul class="categlistsan-ul {if $vo2['bCategory3']}categlistsan-ulpd{/if}">
                                                {volist name="vo2['bCategory3']" id="vo3"}
                                                <li class="categlistsan-li">
                                                    <a href="{:url('store/category_index',['directory3_id'=>$vo3.directory3_id])}" class="categlistsanli-a storeid_a">{$vo3.directory3_name}</a>
                                                </li>
                                                {/volist}
                                            </ul>
                                        </div>
                                    </li>
                                    {/volist}
                                </ul>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>

            </div>


            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top floatfalse">
                    <div class="index-title floatleft">为你推荐</div>
                    <!--<div class="floatright"><a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}">
                    <span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>-->
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="recommendGoods" id="vo"}
                        <li class="kejia-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['thecover']}" />
                                </div>
                                <div class="kejia-name">{$vo['goods_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥{$vo['goods_price']}</div>
                                    <div class="floatright">{$vo['number_payment']}人付款</div>
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>

            </div>
            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top floatfalse">
                    <div class="index-title floatleft">全部商品</div>
                    <!--<div class="floatright"><a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}">
                    <span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>-->
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="goods" id="vo"}
                        <li class="kejia-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['thecover']}" />
                                </div>
                                <div class="kejia-name">{$vo['goods_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥{$vo['goods_price']}</div>
                                    <div class="floatright">{$vo['number_payment']}人付款</div>
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                    <div class="page-div">{$page}</div>
                </div>

            </div>

            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/store/index.js"></script>
    </body>
</html>
