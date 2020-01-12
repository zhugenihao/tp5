<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{$orderTitle}</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/order/orderlist.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="order-all allas">
                <div class="order-top htmlwidth">
                    <ul class="order-topul">
                        <li class="order-topli adtactive" data-state="all">全部</li>
                        <li class="order-topli" data-state="10">待付款</li>
                        <li class="order-topli" data-state="20">待发货</li>
                        <li class="order-topli" data-state="30">待收货</li>
                        <li class="order-topli" data-state="40">已完成</li>
                    </ul>
                    <input type="hidden" name="state" value="all" id="stateId" />
                </div>
                <div class="order-list" id="order-list">
                    <div class="top-search">
                        <div class="order-searchauto">
                            <div class="floatleft searchdiv"><input type="text" name="search" class="search-input" placeholder="商品名称/订单号"/></div>
                            <div class="search-btn2 floatleft" id="search-btn2"><i class="Hui-iconfont">&#xe709</i></div>
                        </div>
                    </div>
                    <ul class="order-listul" id="order_listul">

                    </ul>
                    <form action="" method="post" name="pay_submit">
                        <input type="hidden" value="" name="order_no" id="order_no"/>
                        <input type="hidden" value="" name="total_price" id="total_price"/>
                        <input type="hidden" value="balance" name="payment_type" id="payment_type"/>
                    </form>
                </div>
            </div>
            {include file="public/pay/pay_window" /}
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/order/orderlist.js"></script>

    </body>
</html>
