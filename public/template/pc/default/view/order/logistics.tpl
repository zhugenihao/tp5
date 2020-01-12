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
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/logistics.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="member-all">
                <!--头部栏目-->
                {include file="public/member_top" /}

                <div class="pcdiv-auto">
                    <div class="membertext-all">
                        <!--左部栏目-->
                        {include file="public/member_left" /}

                        <div class="member-right floatleft">
                            <div class="member-text">
                                <div class="member-yue"><span>物流信息</div>
                                <div class="order-det">
                                    <ul class="orderdet-ul">
                                        <li class="orderdet-li">
                                            <div class="orderdet-img floatleft">
                                                <img src="__STATIC__/{$orderGoods['goods_img']}" />
                                            </div>
                                            <div class="orderdet-text floatleft">
                                                <div class="orderdet-name">{$orderGoods['goods_name']}</div>
                                                <div class="orderdet-er">
                                                    <div class="floatleft">
                                                        <div class="goods-price">￥{$orderGoods['goods_price']}</div>
                                                        <div class="goods-guige">规格:{$orderGoods['goods_information']}</div>
                                                    </div>
                                                    <div class="floatright">
                                                        <div>数量：{$orderGoods['goods_num']}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderdet-li orderli-top">
                                            <div>物流公司：{$orderGoods['cou_name']}</div>
                                            <div>快递单号：435454543232354</div>
                                            <div class="wuliujidu">
                                                <div class="wuliujidu-title">配送进度</div>
                                                <ul class="wuliujidu-ul">
                                                    <li class="wuliujidu-li wuliujd-active">
                                                        <div class="wuliujidu-yuan"></div>
                                                        <div class="wuliujidu-text">
                                                            <p class="wuliujidu-time">时间：2019-04-27:10:00:10</p>
                                                            <p>
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li class="wuliujidu-li">
                                                        <div class="wuliujidu-yuan"></div>
                                                        <div class="wuliujidu-text">
                                                            <p class="wuliujidu-time">时间：2019-04-27:10:00:10</p>
                                                            <p>
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li class="wuliujidu-li">
                                                        <div class="wuliujidu-yuan"></div>
                                                        <div class="wuliujidu-text">
                                                            <p class="wuliujidu-time">时间：2019-04-27:10:00:10</p>
                                                            <p>
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                已签收，签收人是施先生,祝你生活愉快。
                                                                
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="orderdet-li">
                                            <div class="floatright">
                                                <a href="javascript:;" class="btnlist-a" onclick="returnOnPage();">返回</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/order/logistics.js"></script>
    </body>
</html>
