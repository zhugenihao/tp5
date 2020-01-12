<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商品推荐</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="home-all allas">
                <div class="advertsas">
                    <a href="{$recommended_advert20['adv_link']}"><img src="__STATIC__/{$recommended_advert20['dire']}" class="advertsas-img"></a>
                </div>
                <div class="tejiayouhui-all">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">重磅推荐</div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul" id="rolling-list">
                    </ul>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/goods/recommended.js"></script>
        
    </body>
</html>
