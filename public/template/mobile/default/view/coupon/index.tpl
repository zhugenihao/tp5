
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的优惠券({$count_all})</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/coupon/index.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="coupon-all allas">
                <div class="coupon-top">
                    <div class="coupontop-auto">
                        <div class="coupon-active" data-state="1">可用的</div>
                        <div data-state="2">已过期</div>
                        <div data-state="record">使用记录</div>
                    </div>
                </div>
                <div class="coupon-list" id="couponlist_alldiv">
                    <ul class="couponlist-ul" id="coupon_listul">
                        
                    </ul>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/coupon/index.js"></script>

    </body>
</html>
