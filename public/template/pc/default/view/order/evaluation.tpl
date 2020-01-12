<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商品评价</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/evaluation.css" />

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
                                <div class="member-yue"><span>商品评价</div>
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
                                        <li class="orderdet-li">

                                            <div class="comadd-auto">
                                                <form class="form-text" method="post" enctype="multipart/form-data" name="comments-add">
                                                    <div class="comadd-text">
                                                        <p>星星打分：</p>
                                                        <div class="comadd-xing" id="comaddimg">
                                                            {volist name="BesidesContent" id="vo"}
                                                            <img src="__STATIC__/images/star/iconpic-star-S-default.png" title="1分" score="{$vo['score']}" name="{$vo['name']}"/>
                                                            {/volist}
                                                            <span id="scorespan">5.0分（非常满意）</span>
                                                        </div>
                                                        <input type="hidden" value="__STATIC__/images/star/iconpic-star-S-default.png" id="star-simg1" />
                                                        <input type="hidden" value="__STATIC__/images/star/iconpic-star-S.png" id="star-simg2" />
                                                        <input type="hidden" value="5.0" id="score" name="score"/>
                                                    </div>
                                                    <div class="comadd-text">
                                                        <p>评论内容：</p>
                                                        <textarea name="texts" class="comadd-tares" placeholder="请输入评论内容"></textarea>
                                                    </div>
                                                    <div class="comimg-in floatfalse">
                                                    </div>
                                                    <input type="hidden" value="{$orderGoods['goods_id']}" name="goods_id" />
                                                    <input type="hidden" value="{$orderGoods['id']}" name="order_id" />
                                                </form>
                                                <form class="form-img" method="post" enctype="multipart/form-data" name="formfileas">
                                                    <div class="comadd-img">
                                                        <p>图片：</p>
                                                        <ul class="comadd-imgul"></ul>

                                                        <div class="comadd-imgup" onclick="comimgFile(this)"><img src="__STATIC__/images/imgup.png"/></div>
                                                    </div>
                                                    <input type="file" name="comimg" id="comimg-file" class="hide" onchange="imgFileas(this)"/>
                                                </form>
                                                <div class="wuliu-btn">
                                                    <a href="javascript:;" class="btnlist-a" onclick="returnOnPage();">返回</a>
                                                </div>
                                                <div class="wuliu-btn">
                                                    <a href="javascript:;" class="btnlist-a" onclick="commentsAdd(this)">立即发布</a>
                                                </div>
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
        <script type="text/javascript" src="__PC__/js/order/evaluation.js"></script>
    </body>
</html>
