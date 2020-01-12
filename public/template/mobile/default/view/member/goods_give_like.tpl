
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>点赞中心({$count_all})</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/goods_give_like.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="goodsgive-all allas">
                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">我的点赞商品</div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul" id="rolling-list">
                        
                    </ul>
                </div>

            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/member/goods_give_like.js"></script>

    </body>
</html>
