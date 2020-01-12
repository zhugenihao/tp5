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
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/store/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/store_top" /}


            <div class="kejia-all pcdiv-auto">
                <div class="goods_type">
                    <div class="goodstype_1">
                        <div class="goodspce_title">商品筛选：</div>
                        <ul class="goodspce_ul">
                            <li>
                                <a href="{:url('store/category_index',['type'=>'sales'])}" class="storeid_a goodstype_btn {if $type=='sales'}goodstype_active{/if}">销量</a>
                            </li>
                            <li>
                                <a href="{:url('store/category_index',['type'=>'goodwill'])}" class="storeid_a goodstype_btn {if $type=='goodwill'}goodstype_active{/if}">好感</a>
                            </li>
                            <li>
                                <a href="{:url('store/category_index',['type'=>'high-low'])}" class="storeid_a goodstype_btn {if $type=='high-low'}goodstype_active{/if}">从高到低</a>
                            </li>
                            <li>
                                <a href="{:url('store/category_index',['type'=>'low-high'])}" class="storeid_a goodstype_btn {if $type=='low-high'}goodstype_active{/if}">从低到高</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="kejia-top floatfalse">
                    <div class="index-title floatleft">{$categoryTitle}</div>
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
                                    <div class="floatright">销量{$vo['sales']}</div>
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
        <script type="text/javascript" src="__PC__/js/store/category_index.js"></script>
    </body>
</html>
