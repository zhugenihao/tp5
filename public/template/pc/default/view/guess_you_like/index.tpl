<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>猜你喜欢</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/guess_you_like/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="index-categoty">
                <div class="categoty-auto pcdiv-auto">
                    <ul class="categoty-ul">
                        <li class="categoty-li">
                            <a href="{:url('index/index')}">首页</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/goods_all')}">全部</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/mobile_digital')}">手机数码</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/supermarket')}">日常超市</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/computer_shop')}">电脑城</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/clothing_store')}">服装市场</a>
                        </li>
                        <li class="categoty-li">
                            <a href="{:url('goods/electrical_appliances')}">电器城</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            
            <div class="advert-img pcdiv-auto">
                <a href=""><img src="/static/images/advertimg/20190412\832cd0ee0d954bee4b7d3f4f7e0c1626.png"/></a>
            </div>
            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top">
                    <div class="index-title floatleft">猜你喜欢</div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="salesGoodsList" id="vo"}
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
        <script type="text/javascript" src="__PC__/js/guess_you_like/index.js"></script>
    </body>
</html>
