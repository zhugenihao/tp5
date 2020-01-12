<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>拼团特区</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/spell_group/index.css" />
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
            <div class="pintuan-all pcdiv-auto">
                <div class="pintuan-top">
                    <div class="pintuan-title floatleft">拼团特区</div>
                </div>
                <div class="pintuan-cont">
                    <ul class="pintuan-ul">
                        {volist name="spellGroupList" id="vo"}
                        <li class="pintuan-li">
                            <div class="pintuan-img">
                                <img src="__STATIC__{$vo['thecover']}" />
                            </div>
                            <div class="goods-name">{$vo['goods_name']}</div>
                            <div class="pintuanli-jiagers">
                                <div class="goods-jiage">￥{$vo['goods_price']}</div>
                                <div class="buy-num">{$vo['sg_members_num']}人成团</div>
                            </div>
                            <div class="pintuanli-a floatfalse">
                                <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'spell_group'])}">立即拼团</a>
                            </div>
                        </li>
                        {/volist}
                    </ul>
                    <div class="page-div">{$page}</div>
                </div>
            </div>
            
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/spell_group/index.js"></script>
    </body>
</html>
