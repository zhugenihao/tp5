<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{$directoryTitle}</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/goods/goods_all.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top" /}
            <div class="goods-all allas">
                <div class="goodsalltop">
                    <ul class="goodsalltop-ul">
                        <li class="goodsalltop-li activeall" data-type="all">全部</li>
                        <li class="goodsalltop-li" data-type="sales">销量</li>
                        <li class="goodsalltop-li" data-type="goodwill">好感</li>
                        <li class="goodsalltop-li goodssxtop-btn" data-type="screening">筛选</li>
                    </ul>
                </div>
                <div class="tejiayouhui-all floatfalse" id="goods_alldiv">
                    <ul class="tejiayouhui-ul" id="goods_listul">

                    </ul>
                </div>
            </div>
            <div class="goodssx">
                <div class="goodssx-bacg"></div>
                <div class="goodssx-text">
                    <div class="goodssx-title">价格</div>
                    <div class="goodssx-list">
                        <ul class="goodssx-ul">
                            <li class="goodssx-li goodssxli1">
                                <div data-type="high-low">从高到低</div>
                                <div data-type="low-high">从低到高</div>
                            </li>
                            <li class="goodssx-li goodssxli2 floatfalse">
                                <div class="goodssxli-div"><input type="text" value="" placeholder="最低价" oninput="lowInput(this)"/></div>
                                <div>-</div>
                                <div class="goodssxli-div"><input type="text" value="" placeholder="最高价" oninput="highInput(this)"/></div>
                            </li>
                            <li class="goodssx-li goodssxli3 floatfalse">
                                <div data-price="200-500">200-500</div>
                                <div data-price="500-1000">500-1000</div>
                                <div data-price="1000-2000">1000-2000</div>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" value="" id="highandlow" />
                    <input type="hidden" id="theinputprice" low="" high=""/>
                    <input type="hidden" value="" id="pricesegment" />
                    <div class="goodssx-btn floatfalse">
                        <div class="goodssx-btn1">取消</div>
                        <div class="goodssx-btn2">确定</div>
                    </div>
                </div>
            </div>
            <div class="anniu">
                <ul class="anniu-ul">
                    <li class="anniu-li anniuli1">
                        <a href="{:url('index/home')}"><i class="Hui-iconfont">&#xe625;</i></a>
                    </li>
                    <li class="anniu-li anniuli2">
                        <i class="Hui-iconfont">&#xe6bf;</i>
                        <i class="Hui-iconfont">&#xe6c0;</i>
                    </li>
                    <li class="anniu-li anniuli3">
                        <a href="{:url('cart/cartlist')}?type=cart"><i class="Hui-iconfont">&#xe673;</i></a>
                    </li>
                </ul>
                <div class="anniu-one">
                    <i class="Hui-iconfont">&#xe600;</i>
                    <i class="Hui-iconfont">&#xe6a6;</i>
                </div>
            </div>
        </div>
        <input type="hidden" value="{:input('typeclassif')}" id="typeclassif" />
        <input type="hidden" value="{:input('dir_id')}" id="dir_id" />

        <script type="text/javascript" src="__MOBILE__/js/goods/goods_all.js"></script>
    </body>
</html>
