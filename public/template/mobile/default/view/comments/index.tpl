<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商品评论</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/comments/index.css" />

        {include file="public/light_gallery" /} 
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/comments_top" /}
            <div class="comments-all allas">
                <div class="comments-top">
                    <div class="commentstop-auto">
                        <div class="goods-img floatleft">
                            <img src="__STATIC__/{$goods['thecover']}" />
                        </div>
                        <div class="goods-text floatleft">
                            <p class="goods-name">{$goods['goods_name']}</p>
                            <p class="goods-price color-red">￥{$goods['goods_price']}</p>
                        </div>
                    </div>
                </div>
                <div class="comments-list">
                    <div class="commentslist-top"><p class="commentslist-topp">全部品论({$comments_count})</p></div>
                    <ul class="comments-lul" id="rolling-list">

                    </ul>
                </div>
            </div>
            <input type="hidden" value="{:input('goods_id')}" id="goods_id" />
           <!-- <div class="comfabu"><a href="{:url('comments/add',['goods_id'=> input('goods_id')])}">发布</a></div>-->
        </div>
        <script type="text/javascript" src="__MOBILE__/js/comments/index.js"></script>
    </body>
</html>
