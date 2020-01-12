<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>发布评论</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/comments/add.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="comadd-all allas">

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
                            <textarea name="texts" class="comadd-tares" placeholder="请输入评论内容"></textarea>
                        </div>
                        <div class="comimg-in floatfalse">
                        </div>
                        <input type="hidden" value="{$orderGoods['goods_id']}" name="goods_id" />
                        <input type="hidden" value="{$orderGoods['id']}" name="order_id" />
                    </form>
                    <form class="form-img" method="post" enctype="multipart/form-data" name="formfileas">
                        <div class="comadd-img">
                            <ul class="comadd-imgul"></ul>

                            <div class="comadd-imgup" onclick="comimgFile(this)"><img src="__MOBILE__/images/icon/imgup.png"/></div>
                        </div>
                        <input type="file" name="comimg" id="comimg-file" class="hide" onchange="imgFileas(this)"/>
                    </form>
                    <div class="comadd-btn"><a href="#" onclick="commentsAdd(this)">立即发布</a></div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/comments/add.js"></script>
    </body>
</html>
