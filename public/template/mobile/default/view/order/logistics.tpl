<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>物流信息</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/order/logistics.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="sorder-all allas">
                <ul class="sorder-ul">
                    <li class="sorder-li">
                        <div class="sorder-lidiv layui-form-item">
                            <div class="sorder-imgas">
                                <div class="sorder-img">
                                    <img src="__STATIC__/{$orderGoods['goods_img']}">
                                </div>
                            </div>
                            <div class="sorder-title">
                                <div class="sorder-textas">{$orderGoods['goods_name']}</div>
                                <div class=""><span class="color-red">￥{$orderGoods['total_price']}</span>
                                    <div class="sorder-num floatright">数量：<span class="goods_num">{$orderGoods['goods_num']}</span></div>
                                </div>
                                {if $orderGoods['goods_information']}
                                <div class="sorder-qita">
                                    <p class="sorder-qitagg floatleft">规格:{$orderGoods['goods_information']}</p>
                                </div>
                                {/if}
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="wuliu-list">
                    <div class="wuliu-text">
                        <div>物流公司：{$orderGoods['cou_name']}</div>
                        <div>快递单号：435454543232354</div>
                    </div>
                    <div class="wuliu-cont">
                        <div class="wuliu-title">配送进度</div>
                        <ul class="wuliucont-ul">
                            <li class="wuliucont-li">
                                <div class="wuliucont-su wuliucont-green">
                                    <div class="wuliucont-yuan"></div>
                                </div>
                                <div class="wuliucont-tetm wuliucont-tetmbac1">
                                    <div class="wuliucont-time">时间：2019-04-27:10:00:10</div>
                                    <div class="wuliucont-text">
                                        已签收，签收人是施先生,祝你生活愉快。
                                        已签收，签收人是施先生,祝你生活愉快。
                                        已签收，签收人是施先生,祝你生活愉快。
                                    </div>
                                </div>
                            </li>
                            <li class="wuliucont-li">
                                <div class="wuliucont-su wuliucont-huise">
                                    <div class="wuliucont-yuan"></div>
                                </div>
                                <div class="wuliucont-tetm wuliucont-tetmbac2">
                                    <div class="wuliucont-time">时间：2019-04-27:10:00:10</div>
                                    <div class="wuliucont-text">
                                        已签收，签收人是施先生,祝你生活愉快。
                                    </div>
                                </div>
                            </li>
                            <li class="wuliucont-li">
                                <div class="wuliucont-su wuliucont-huise">
                                    <div class="wuliucont-yuan"></div>
                                </div>
                                <div class="wuliucont-tetm wuliucont-tetmbac2">
                                    <div class="wuliucont-time">时间：2019-04-27:10:00:10</div>
                                    <div class="wuliucont-text">
                                        已签收，签收人是施先生,祝你生活愉快。
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/order/logistics.js"></script>
    </body>
</html>
