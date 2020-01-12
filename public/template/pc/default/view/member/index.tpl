<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>个人中心</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
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
                                <div class="member-photo"><img src="__STATIC__/{$memberInfo['photo']}" /></div>
                                <div class="sas" style="display: none;"><img src="__STATIC__/{$memberInfo['photo']}" onerror="imgExists(this)" id="photoimg"/></div>

                                <div class="membertext_1">
                                    <div class="member-uname">{$memberInfo['member_name']}</div>
                                    <div class="member-yeys">
                                        <a href="">余额：{$memberInfo['forehead']}</a>
                                        <a href="">积分：{$memberInfo['integral']}</a>
                                        <a href="">优惠券：{$memberInfo['coupon_count']}张</a>
                                        <a href="">收货地址</a>
                                    </div>
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
        <script type="text/javascript" src="__PC__/js/member/index.js"></script>
    </body>
</html>
