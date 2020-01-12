<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商家中心</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            <div class="member-all">
                <!--头部栏目-->
                {include file="public/seller/seller_top" /}

                <div class="pcdiv-auto">
                    <div class="membertext-all">
                        <!--左部栏目-->
                        {include file="public/seller/seller_left" /}

                        <div class="member-right floatleft">
                            <div class="member-text">
                                <div class="seller_auto">
                                    <div class="member-photo"><img src="__STATIC__/{$seller['seller_photo']}" onerror="imgExists(this)"/></div>
                                    <div class="sas" style="display: none;"><img src="__STATIC__/{$seller['seller_photo']}" onerror="imgExists(this)" id="photoimg"/></div>

                                    <div class="membertext_1">
                                        <div class="member-uname">{$seller['seller_name']}</div>
                                        <div class="member-yeys">
                                            <a href="">余额：{$seller['seller_forehead']}</a>
                                            <a href="">积分：{$seller['seller_integral']}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/index.js"></script>
    </body>
</html>
