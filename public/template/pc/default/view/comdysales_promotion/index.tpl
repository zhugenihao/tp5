<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>促销优惠</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/comdysales_promotion/index.css" />
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
                    <div class="index-title floatleft">促销优惠</div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="comdypList['data']" id="vo"}
                        <li class="kejia-li">
                            <div class="dazhe">
                                {eq name="vo['cp_type']" value="1"}{$vo['discount']}{/eq}
                                {eq name="vo['cp_type']" value="2"}优{/eq}
                            </div>
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'comdysalesp'])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['cp_img']}" />
                                </div>
                                <div class="kejia-name">{$vo['cp_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥
                                        {eq name="vo['cp_type']" value="1"}{$vo['goods_price']}{/eq}
                                        {eq name="vo['cp_type']" value="2"}{$vo['cp_price']}{/eq}
                                    </div>
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
        <script type="text/javascript" src="__PC__/js/comdysales_promotion/index.js"></script>
    </body>
</html>
