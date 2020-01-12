
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>{$orderTitle}</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="secondskill_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>订单状态</label>
                <span>
                    <select name="state" class="selectpad">
                        <option value="0">请选择</option>
                        <option value="10" {eq name=":input('state')" value="10"} selected {/eq}>待付款</option>
                        <option value="11" {eq name=":input('state')" value="11"} selected {/eq}>交易关闭</option>
                        <option value="20" {eq name=":input('state')" value="20"} selected {/eq}>待发货</option>
                        <option value="30" {eq name=":input('state')" value="30"} selected {/eq}>待收货</option>
                        <option value="40" {eq name=":input('state')" value="40"} selected {/eq}>已完成</option>
                    </select>
                </span>
                <input type="text" value="{:input('member_name')}" name="member_name" class="member_text" placeholder="用户名" size="20"/>
                <input type="text" value="{:input('order_no')}" name="order_no" class="member_text" placeholder="订单编号"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="orderDel(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除促销
                </a>
            </div>
            <!--<div class="floatright">
                <a href="{:url('seller_sales_promotion.coupon/coupon_add',['top'=>4,'type'=>4])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加促销
                </a>
            </div>-->
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>规格信息</th>
                    <th>商品单价</th>
                    <th>商品数量</th>
                    <th>支付方式</th>
                    <th width="90">实付金额</th>
                    <th width="80">订单状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="order['data']" id="vo"}
                <tr class="tbcenter bacdanlan">
                    <td><input name="id[]" type="checkbox" value="{$vo.id}"></td>
                    <td colspan="8">
                        <div class="activity_div textleft">
                            {if $vo['activity']=='spell_group'}
                                <div class="color-green">拼团订单
                                    {$vo['sg_members_num']}人成团，
                                    {if $vo['sgm_member_poor'] > 0}
                                        还差{$vo['sgm_member_poor']}人 
                                    {else/} 人数已满，可以发货{/if}
                                </div>
                                {if $vo['sgm_member_list']}
                                    <span>团员：</span>
                                    <span class="pintuanimg">
                                        {volist name="vo['sgm_member_list']" id="sgmvo" key="index"}
                                        <img src="__STATIC__/{$sgmvo['photo']}" title="{$sgmvo['member_name']}" class="{if $index==1}pintuanimg-active{/if}" onerror="imgExists(this)"/>
                                        {/volist}
                                    </span>
                                {/if}

                            {elseif $vo['activity']=='seconds_kill'/}
                                <div class="color-green">秒杀订单</div>
                            {elseif $vo['activity']=='comdysalesp'/}
                                <div class="color-green">促销订单</div>
                            {else/}
                                <div class="color-green">普通订单</div>
                            {/if}
                            <div class="order_textdiv">
                                <span>订单编号：{$vo['order_no']}</span> 
                                <span>实付总金额：<i class="goods-price">￥{$vo['total_price']}</i></span> 
                                <span>用户名称：{$vo['member']['member_name']}</span>
                                <span>下单时间：{$vo['order_time']|date='Y-m-d H:i:s',###}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_order_logistics.order/order_details',['top'=>5,'type'=>1,'order_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="orderDel(this)" data-orderid="{$vo['id']}" data-ordertype="order">删除</a><br/>
                            {if $vo['state']=='20'} 
                                <a href="javascript:;" class="color-blue" onclick="deliveryStart(this)" data-orderid="{$vo['id']}" data-ordertype="order">立即发货</a>
                            {/if}
                            {if $vo['state']=='10'} 
                                <a href="javascript:;" class="color-blue" onclick="modifyStart(this)" data-orderid="{$vo['id']}" data-ordertype="order">帮付款</a>
                            {/if}

                        </div>
                    </td>
                </tr>
                {volist name="vo['order_goods']" id="vog"}
                <tr class="tbcenter">
                    <td>
                        <!--<input type="checkbox" name="id[]" value="{$vog['id']}" />-->
                    </td>
                    <td>{$vo['id']}</td>
                    <td>
                        <div class="goods-names">
                            <img src="__STATIC__/{$vog['goods_img']}" width="20" height="20">
                            &nbsp;{$vog['goods_name']}
                        </div>
                    </td>
                    <td><div class="goods-names">{$vog.goods_information}</div></td>
                    <td>￥{$vog.goods_price}</td>
                    <td>{$vog.goods_num}</td>
                    <td>{$vog['payment']['payment_name']}</td>
                    <td><i class="goods-price">￥{$vog.total_price}</i></td>
                    <td>
                        {if $vog['state']=='10'}
                            <span class="color-red">待付款</span> 
                        {elseif($vog['state']=='11') /} 
                            <span class="color-red">交易关闭</span> 
                        {elseif($vog['state']=='20') /} 
                            <span class="color-green">待发货</span> 
                        {elseif($vog['state']=='30') /} 
                            <span class="color-green">待收货</span> 
                        {elseif($vog['state']=='40') /} 
                            <span class="color-green">已完成</span> 
                        {/if}
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="orderGoodsDel(this)" data-orderid="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {/volist}
                {if $order['total'] < 1}
                    <tr class="tbcenter"><td colspan="10">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/order/order_list.js"></script>

