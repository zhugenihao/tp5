<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{$countTitle}</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/cart/cartlist.css" />
    </head>
    <body>
        <div class="youslie" id="youslieid">
            <ul class="youslie-ul">
                <li class="youslie-li">
                    <a href="{:url('index/index')}"><i class="Hui-iconfont">&#xe625;</i><span>首页</span></a>
                </li>
                <li class="youslie-li">
                    <a href="javascript:;" onclick="emptyCart(this)"><i class="Hui-iconfont">&#xe609;</i><span>清空购物车</span></a>
                </li>
            </ul>
        </div>
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="cart-all allas">
                <div class="cart-auto">
                    <form class="layui-form" action="{:url('order/cart_order_submit')}" method="post" lay-filter="example" id="cartlistform" name="cartlistform">
                        <ul class="cart-ul" id="rolling-list">
                        </ul>
                        <div class="cart-goumai htmlwidth">
                            <div class="cart-quanxuan floatleft">
                                <input type="checkbox" name="allid" lay-skin="primary" id="c_all" lay-filter="c_all" title="全选"/>
                            </div>
                            <div class="cart-jgbtn floatright">

                                <a href="#" class="cart-btnfk" onclick="cartlistBtn(this)">立即付款</a>
                                <p class="cart-zj">
                                    总计(含运费)：<i class="cart-zji">￥<span id="cart_price">0.00</span></i>&nbsp;</p>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="cart-guige">
                    <div class="cart-guigeer"></div>
                    <div class="cart-guige-auto">
                        <div class="cart-guigetop">
                            <div class="cart-guigetaut">
                                <div class="cart-guigeimg floatleft">
                                    <img src="__MOBILE__/images/sj.jpg" />
                                </div>
                                <div class="cart-guigeshuj floatleft">
                                    <p class="cart-guigejiage">￥190.00</p>
                                    <p class="cart-guigekc">库存<span class="inventory">0</span>件</p>
                                </div>
                                <p class="cart-guigeyx floatfalse">已选：
                                    <span class="yansetext"></span>，
                                    <span class="banbentext"></span>，
                                    <span class="goodsnum"></span>个
                                </p>
                            </div>
                        </div>
                        <div class="yanse-list">
                            <div class="cart-yanse">
                                <div class="cart-yanseauto">
                                    <div class="cart-ystitle">颜色类型</div>
                                    <ul class="cart-yanseul" id="cartyanse">
                                    </ul>
                                </div>
                            </div>
                            <div class="cart-yanse">
                                <div class="cart-yanseauto">
                                    <div class="cart-ystitle">版本类型</div>
                                    <ul class="cart-yanseul" id="cartbanben">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="cart-btnas floatfalse">
                            <div class="cart-guigenum">
                                <div class="cart-num floatleft">数量：<span class="goodsnum"></span></div>
                                <div class="cart-btnnum floatright">
                                    <input type="button" value="-" name="cart-jian" class="cart-jian" id="cart-jian"/>
                                    <input type="text" value="1" name="cart-text" class="cart-text" id="cart-text"/>
                                    <input type="button" value="+" name="cart-jia" class="cart-jia" id="cart-jia"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-queding">
                        <div class="floatleft queding-btn1" onclick="cartCancel(this)">取消</div>
                        <div class="floatleft queding-btn2" onclick="cartDetermine(this)">确定</div>
                    </div>
                </div>
                <form action="" method="post" name="cartoneform">
                    <input type="hidden" value="" class="cart_one_id" name="cart_id"/>
                    <input type="hidden" value="" class="n_one_id" name="n_id"/>
                    <input type="hidden" value="" class="cate_one_id" name="cate_id"/>
                    <input type="hidden" value="" class="goods_one_num" name="goods_num"/>
                    <input type="hidden" value="" class="goods_one_price" name="goods_price"/>
                    <input type="hidden" value="" class="total_one_price" name="total_price"/>
                </form>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/cart/cartlist.js"></script>
        <script type="text/javascript" src="__MOBILE__/js/cart/cartsubmit.js"></script>

    </body>
</html>
