<?php

use think\Route;

#移动端接口
Route::rule([]);
Route::post('api/:version/token/member', 'api/:version.Token/getToken'); //令牌
Route::post('api/:version/token/mid', 'api/:version.Token/getMid'); // 获取用户mid

Route::get([
    'api/:version/index_index' => 'api/:version.Index/index', //首页数据
    'api/:version/index_secondsk_cur' => 'api/:version.Index/secondsKillCurrent', //首页秒杀
    'api/:version/order_orderlist' => 'api/:version.Order/orderList', //订单列表数据
    'api/:version/goods_recommended' => 'api/:version.Goods/recommended', //商品推荐数据
    'api/:version/goods_goodsdetails' => 'api/:version.Goods/goods_details', //商品详情
    'api/:version/submit_givealike' => 'api/:version.Givealike/submitGivealike', //商品喜欢操作
    'api/:version/add_copon_receive' => 'api/:version.CoponReceive/addCoponReceive', //领取优惠券
    'api/:version/goods_cateslist' => 'api/:version.Goods/catesList', //获取商品版本信息
    'api/:version/submit_orders' => 'api/:version.Order/submit_orders', //订单提交页面数据
    'api/:version/algorithm_cart' => 'api/:version.Cart/algorithmCart', //使用优惠券
    'api/:version/seconds_kill_judge' => 'api/:version.SecondsKill/secondsKillJudge', //判断秒杀商品是否已超时
    'api/:version/comdyp_judge' => 'api/:version.ComdysalesPromotion/comdypJudge', //判断促销商品是否已超时
    'api/:version/spell_group_ordernum_list' => 'api/:version.SpellGroupOrdernum/getlist', //参团信息
    'api/:version/spell_group_ordernum_member' => 'api/:version.SpellGroupOrdernum/getsgMemberList', //参团信息2
    'api/:version/add_collection' => 'api/:version.Collection/addCollection', //商品收藏
    
    'api/:version/user_cart_list' => 'api/:version.Cart/cartList', //用户购物车数据
    'api/:version/user_cart_norm' => 'api/:version.Cart/normList', //用户购物车规格1
    'api/:version/user_cart_cates' => 'api/:version.Cart/catesList', //用户购物车规格2
    'api/:version/user_cart_del' => 'api/:version.Cart/cartDel', //用户购物车删除
    'api/:version/user_cart_empty' => 'api/:version.Cart/emptyCart', //用户购物车清空
]);

Route::post([
    'api/:version/spell_group_judge' => 'api/:version.SpellGroupOrdernum/spellGroupJudge', //拼团信息判断
    'api/:version/member_index' => 'api/:version.Member/index', //个人中心数据
    'api/:version/pay_payupdateone' => 'api/:version.Pay/payUpdateOne', //单个订单付款
    'api/:version/order_orderdel' => 'api/:version.Order/orderDel', //订单取消
    'api/:version/order_confirmgoods' => 'api/:version.Order/confirmGoods', //确认收货
    'api/:version/goods_addcart' => 'api/:version.Goods/addCart', //添加购物车
    'api/:version/submit_orders_api' => 'api/:version.Order/submit_orders_api', //单个商品订单提交
    'api/:version/pay_paysubmit' => 'api/:version.Pay/paySubmit', //支付订单提交
    'api/:version/pay_payupdate' => 'api/:version.Pay/payUpdate', //多个订单付款
    
    'api/:version/user_cart_onesubmit' => 'api/:version.Cart/cartOneSubmit', //用户购物车修改数据
    'api/:version/cache_cartid' => 'api/:version.Order/cacheCartid', //缓存购物车id
    'api/:version/cart_order_submit' => 'api/:version.Order/cart_order_submit', //购物车订单提交
    
]);
