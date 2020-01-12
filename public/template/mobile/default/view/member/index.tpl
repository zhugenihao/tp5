
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
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/home.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="member-all allas">
                <div class="member-top">
                    <div class="member-topauto">
                        <div class="member-toptou margintop">
                            <div class="member-topmy floatleft">
                                <p class="member-img floatleft"><img src="__STATIC__/{$memberInfo['photo']}" onerror="imgExists(this)" id="photoimg"/></p>
                                <p class="sas" style="display: none;"><img src="__STATIC__/{$memberInfo['photo']}" onerror="imgExists(this)" id="photoimg"/></p>

                                <p class="member-name floatleft">{$memberInfo['member_name']}</p>
                            </div>
                            <div class="member-topsz floatright"><a href="{:url('member/account_settings')}">账号设置</a></div>
                        </div>
                        <div class="member-topyue floatfalse margintop">
                            <div class="member-yuenum floatleft">余额：{$memberInfo['forehead']}</div>
                            <div class="member-topicon floatright">
                                <a href="{:url('record_books/index')}"><i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>
                        </div>
                        <div class="member-topyh margintop floatfalse">
                            <div class="member-yhnum floatleft">积分：{$memberInfo['integral']}</div>
                        </div>
                        <div class="member-topyh margintop floatfalse">
                            <div class="member-yhnum floatleft">优惠券：{$memberInfo['coupon_count']}张</div>
                            <div class="member-topicon floatright">
                                <a href="{:url('coupon/index')}"><i class="Hui-iconfont">&#xe6d7;</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="orderlist">
                    <div class="ordertop">
                        <p class="ordertopp">我的订单</p>
                    </div>
                    <ul class="orderul">
                        <li class="orderli">
                            <a href="{:url('order/orderlist')}?type=order&state=10">
                                <p class="ordericon"><i class="Hui-iconfont">&#xe606;</i></p>
                                <p class="ordertitle">待付款</p>
                            </a>
                        </li>
                        <li class="orderli">
                            <a href="{:url('order/orderlist')}?type=order&state=20">
                                <p class="ordericon"><i class="Hui-iconfont">&#xe644;</i></p>
                                <p class="ordertitle">待发货</p>
                            </a>
                        </li>
                        <li class="orderli">
                            <a href="{:url('order/orderlist')}?type=order&state=30">
                                <p class="ordericon"><i class="Hui-iconfont">&#xe645;</i></p>
                                <p class="ordertitle">待收货</p>
                            </a>
                        </li>
                        <li class="orderli">
                            <a href="{:url('order/orderlist')}?type=order&state=40">
                                <p class="ordericon"><i class="Hui-iconfont">&#xe6e1;</i></p>
                                <p class="ordertitle">已完成</p>
                            </a>
                        </li>
                        <li class="orderli">
                            <a href="{:url('order/orderlist')}?type=order&state=all">
                                <p class="ordericon"><i class="Hui-iconfont">&#xe667;</i></p>
                                <p class="ordertitle">全部订单</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="myjiezuo floatfalse">
                    <div class="myjiezuo-auto">
                        <div class="myjiezuo-list">
                            <div class="myjiezuo-div">
                                <a href="{:url('member/goods_give_like')}">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe66d;</i>
                                        ({$memberInfo['givealike_count']})
                                    </p>
                                    <p class="myjiezuo-title">商品点赞</p>
                                </a>
                            </div>
                            <div class="myjiezuo-div">
                                <a href="{:url('member/watch_history')}">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe6ce;</i>
                                        ({$memberInfo['watch_history_count']})
                                    </p>
                                    <p class="myjiezuo-title">我的足迹</p>
                                </a>
                            </div>
                            <div class="myjiezuo-div">
                                <a href="{:url('member/collection')}">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe630;</i>
                                        ({$memberInfo['collection_count']})
                                    </p>
                                    <p class="myjiezuo-title">我的收藏</p>
                                </a>
                            </div>
                            <div class="myjiezuo-div">
                                <a href="{:url('order/orderlist')}?type=order&activity=seconds_kill">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe690;</i>
                                        ({$memberInfo['orderSecondsKill_count']})</p>
                                    <p class="myjiezuo-title">我的秒杀</p>
                                </a>
                            </div>
                            <div class="myjiezuo-div">
                                <a href="{:url('order/orderlist')}?type=order&activity=spell_group">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe62b;</i>
                                        ({$memberInfo['orderSpellGroup_count']})</p>
                                    <p class="myjiezuo-title">我的拼团</p>
                                </a>
                            </div>
                                    <div class="myjiezuo-div">
                                <a href="{:url('order/orderlist')}?type=order&activity=comdysalesp">
                                    <p class="myjiezuo-num">
                                        <i class="Hui-iconfont">&#xe620;</i>
                                        ({$memberInfo['orderComdysalesp_count']})</p>
                                    <p class="myjiezuo-title">促销订单</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tejiayouhui-all floatfalse">
                    <div class="tejiayouhui-top">
                        <div class="tejiayouhui-topauto">
                            <div class="tejiayouhui-toptitle">热门商品</div>
                        </div>
                    </div>
                    <ul class="tejiayouhui-ul">
                        {volist name="paymentGoodsList" id="vo"}
                        <li class="tejiayouhui-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo.goods_id])}"/>
                            <div class="tejiayouhui-img"><img src="__STATIC__{$vo['thecover']}"></div>
                            <div class="tejiayouhui-title">{$vo['goods_name']}</div>
                            <div class="tejiayouhui-bottom">
                                <span class="tejiayouhui-jiage">￥{$vo['goods_price']}</span>
                                <span class="tejiayouhui-xl">{$vo['number_payment']}人付款</span>
                            </div>
                            </a>
                        </li>
                        {/volist}

                    </ul>
                </div>

            </div>
            {include file="public/bottom" /}   
        </div>

        <script type="text/javascript" src="__MOBILE__/js/member/index.js"></script>

    </body>
</html>
