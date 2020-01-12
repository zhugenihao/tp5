<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的订单</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/order/orderlist.css" />
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
                                <form class="layui-form" action="{:url('order/orderlist')}" id="order_from">
                                    <input type="hidden" value="4" name="type" />
                                    <input type="hidden" name="activity" value="{:input('activity')}" id="activity"/>
                                    <div class="member-yue"><span>{$orderTitle}</div>
                                    <div class="layui-inline zhanglx">
                                        <label class="layui-form-label">订单类型</label>
                                        <div class="layui-input-inline">
                                            <select name="state" lay-filter="order_state">
                                                <option value="all" {eq name="state" value="all"}selected{/eq}>全部</option>
                                                <option value="10" {eq name="state" value="10"}selected{/eq}>待付款</option>
                                                <option value="11" {eq name="state" value="11"}selected{/eq}>交易关闭</option>
                                                <option value="20" {eq name="state" value="20"}selected{/eq}>待发货</option>
                                                <option value="30" {eq name="state" value="30"}selected{/eq}>待收货</option>
                                                <option value="40" {eq name="state" value="40"}selected{/eq}>已完成</option>
                                            </select>
                                        </div>
                                        <input type="text" value="{$search}" name="search" class="member_text" placeholder="输入订单号/商品名称"/>
                                        <input type="submit" value="搜索" class="update_btn2"/>
                                    </div>
                                </form>
                                <div class="churuzhang">
                                    <table border="1" class="churuzhang-tb">
                                        <thead class="churuzhang-te">
                                            <tr>
                                                <th>商品信息</th>
                                                <th width="60">数量</th>
                                                <th>实付</th>
                                                <th width="170">下单时间</th>
                                                <th width="80">状态</th>
                                                <th width="120">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody class="churuzhang-ty">
                                            {volist name="orderList" id="vo"}
                                            <tr class="tbcenter">
                                                <td>
                                                    <div class="goods-alls">
                                                        {eq name="vo['activity']" value="seconds_kill"} 
                                                        <div class="activity_title">秒杀商品</div>
                                                        {/eq}
                                                        {eq name="vo['activity']" value="discount"} 
                                                        <div class="activity_title">打折商品</div>
                                                        {/eq}
                                                        {eq name="vo['activity']" value="spell_group"} 

                                                        <div class="activity_title">拼团订单:{$vo['sg_members_num']}人成团，
                                                            {if $vo['sgm_member_poor']>0}
                                                                还差{$vo['sgm_member_poor']}人 
                                                            {else/}
                                                                人数已满
                                                            {/if}
                                                            <div class="spellmember">团员:
                                                                {volist name="vo['sgm_member_list']" id="sgm_vo"}
                                                                <img class="selactive" src="__STATIC__/{$sgm_vo['photo']}">
                                                                {/volist}
                                                            </div>
                                                        </div>

                                                        {/eq}


                                                        <div class="goods-img floatleft">
                                                            <img src="__STATIC__/{$vo['goods_img']}"/>
                                                        </div>
                                                        <div class="goods-text floatleft">
                                                            <div class="goods-name">{$vo['goods_name']}</div>
                                                            <div class="goods-price">￥{$vo['goods_price']}</div>
                                                            <div class="goods-guige">规格：{$vo['goods_information']}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{$vo['goods_num']}</td>
                                                <td><div class="goods-price">￥{$vo['total_price']}</div></td>
                                                <td>{$vo['tord_time']|date="Y-m-d H:i:s",###}</td>
                                                <td>
                                                    {eq name="vo['state']" value="10"}<span class="color-red"> 未付款</span> {/eq}
                                                    {eq name="vo['state']" value="11"} <span class="color-red">交易关闭</span> {/eq}
                                                    {eq name="vo['state']" value="20"} <span class="color-green">待发货</span> {/eq}
                                                    {eq name="vo['state']" value="30"} <span class="color-green">待收货</span> {/eq}
                                                    {eq name="vo['state']" value="40"} <span class="color-green">已完成</span> {/eq}

                                                </td>
                                                <td>
                                                    <div class="order-btn">
                                                        {eq name="vo['state']" value="10"}
                                                        <div><a href="javascript:;" onclick="orderDel(this)" data-orderid="{$vo['id']}">取消订单</a></div>
                                                        <div><a href="javascript:;" data-orderno="{$vo['order_no']}" data-totalprice="{$vo['total_price']}"
                                                                data-goodsnum="{$vo['goods_num']}" class="color-blue det_payment">立即付款</a>
                                                        </div>
                                                        {/eq}
                                                        {eq name="vo['state']" value="11"}
                                                        <div><a href="javascript:;" onclick="orderDel(this)" data-orderid="{$vo['id']}">取消订单</a></div>
                                                        {/eq}
                                                        {eq name="vo['state']" value="20"}
                                                        <div><a href="{:url('order/order_details',['type'=>4,'order_id'=>$vo['id']])}">订单详情</a></div>
                                                        <div><a href="{:url('order/logistics',['type'=>4,'order_id'=>$vo['id']])}">查看物流</a></div>
                                                        {/eq}
                                                        {eq name="vo['state']" value="30"}
                                                        <div><a href="javascript:;" onclick="confirmGoods(this)" data-orderno="{$vo['order_no']}">确认收货</a></div>
                                                        <div><a href="{:url('order/order_details',['type'=>4,'order_id'=>$vo['id']])}">订单详情</a></div>
                                                        <div><a href="{:url('order/logistics',['type'=>4,'order_id'=>$vo['id']])}">查看物流</a></div>

                                                        {/eq}
                                                        {eq name="vo['state']" value="40"}
                                                        <div><a href="{:url('order/order_details',['type'=>4,'order_id'=>$vo['id']])}">订单详情</a></div>
                                                        {if !isset($commentsIs[$vo['order_no']])}
                                                            <div><a href="{:url('order/evaluation',['type'=>4,'order_id'=>$vo['id']])}">等待评价</a></div>
                                                        {/if}
                                                        {/eq}

                                                    </div>
                                                </td>
                                            </tr>
                                            {/volist}

                                        </tbody>
                                    </table>
                                    {if empty($orderCount)}
                                        <div class="wushuju_text">暂无数据</div>
                                    {/if}
                                    <div class="page-div">{$page}</div>
                                </div>

                            </div>
                            <form action="" method="post" name="pay_submit">
                                <input type="hidden" value="" name="order_no" id="order_no"/>
                                <input type="hidden" value="" name="total_price" id="total_price"/>
                                <input type="hidden" value="balance" name="payment_type" id="payment_type"/>
                            </form>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/pay/pay_window" /}
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/order/orderlist.js"></script>
    </body>
</html>
