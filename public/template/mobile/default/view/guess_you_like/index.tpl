<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>猜你喜欢</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/guess_you_like/index.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="tejiayouhui-allas allas">
                <div class="tejiayouhui-top">
                    <img src="/mallz/public/static/images/advertimg/20190331\216ff8faca13f5621d919ddae5b53af7.jpg" />
                </div>
                <div class="tejiayouhui-all">
                    <ul class="tejiayouhui-ul" id="rolling-list">

                    </ul>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>

        <script type="text/javascript" src="__MOBILE__/js/guess_you_like/index.js"></script>
        
    </body>
</html>
