<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>秒杀中心</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/seconds_kill/index.css" />
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
            <div class="miaosha-time pcdiv-auto">
                <div class="miaoshatime-1">
                    <div class="miaoshatime-title">秒杀时间</div>
                    <ul class="miaoshatime-ul">
                        <li class="{if input('time')==$shours0||input('time')==''}mtime-active{/if}">
                            <a href="{:url('seconds_kill/index',['time'=>$shours0])}">{$shours}点(当前秒杀)</a>
                        </li>
                        {volist name="secondGoodsTimeList" id="vo"}
                        <li class="{if input('time')==$vo.time}mtime-active{/if}">
                            <a href="{:url('seconds_kill/index',['time'=>$vo.time])}">{$vo['title']}(即将开始)</a>
                        </li>
                        {/volist}
                    </ul>
                </div>
            </div>

            <div class="advert-img pcdiv-auto">
                <a href=""><img src="/static/images/advertimg/20190412\832cd0ee0d954bee4b7d3f4f7e0c1626.png"/></a>
            </div>
            <div class="pintuan-all pcdiv-auto">
                <div class="pintuan-top">
                    <div class="pintuan-title floatleft">秒杀列表</div>
                </div>
                <div class="pintuan-cont">
                    <ul class="pintuan-ul">
                        {volist name="secondsKillList" id="vo"}
                        <li class="pintuan-li">
                            <div class="pintuan-img">
                                <img src="__STATIC__{$vo['thecover']}" />
                            </div>
                            <div class="goods-name">{$vo['goods_name']}</div>
                            <div class="pintuanli-jiagers">
                                <div class="goods-jiage">￥{$vo['goods_price']}</div>
                                <div class="buy-num">{$vo['number_payment']}人付款</div>
                            </div>
                            <div class="pintuanli-a floatfalse">
                                {if $shours0 == input('time')}
                                <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'seconds_kill'])}">立即抢购</a>
                                {else/}
                                <a href="javascript:;" class="pintuanli-btn2">立即抢购</a>
                                {/if}
                            </div>
                        </li>
                        {/volist}
                    </ul>
                    <div class="page-div">{$page}</div>
                </div>
            </div>

            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seconds_kill/index.js"></script>
    </body>
</html>
