<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的优惠券</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/coupon/index.css" />
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
                                <form class="layui-form" action="">
                                    <div class="member-yue"><span>我的优惠券（{$count_all}张）</div>
                                    <div class="layui-inline zhanglx">
                                        <label class="layui-form-label">优惠券类型</label>
                                        <div class="layui-input-inline">
                                            <select name="quiz" lay-filter="state">
                                                <option value="1" {eq name="state" value="1"}selected{/eq}>可用的</option>
                                                <option value="2" {eq name="state" value="2"}selected{/eq}>已过期</option>
                                                <option value="record" {eq name="state" value="record"}selected{/eq}>使用记录</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="churuzhang">
                                        <table border="1" class="churuzhang-tb">
                                            <thead class="churuzhang-te">
                                                <tr>
                                                    <th>内容</th>
                                                    <th>优惠券类型</th>
                                                    <th>数量</th>
                                                    <th>有效时间</th>
                                                </tr>
                                            </thead>
                                            <tbody class="churuzhang-ty">
                                                {volist name="list" id="vo"}
                                                <tr class="tbcenter">
                                                    <td>
                                                        {if $state==1}
                                                            <div class="coupon-alls">
                                                                <div class="couponlistone">
                                                                    <p class="coup-price">￥{$vo['cop_price']}</p>
                                                                    <p class="coup-text">满{$vo['full_amount']}元方可使用</p>
                                                                </div>
                                                                <div class="couponlisttwo">
                                                                    <div class="coupnametime floatleft">
                                                                        {eq name="vo['type']" value="1"}
                                                                        <p class="coupname">商品：{$vo['goods_name']}</p>
                                                                        {/eq}
                                                                        {eq name="vo['type']" value="2"}
                                                                        <p class="coupname">店铺：{$vo['store_name']}</p>
                                                                        {/eq}
                                                                        <p class="couptime">有效期：{$vo['copb_time']}</p>
                                                                    </div>
                                                                    {eq name="vo['type']" value="1"}
                                                                    <div class="floatright coup-btn"><a href="{:url('goods/goods_details',['goods_id'=>$vo['type_id']])}" class="backga1">立即使用</a></div>
                                                                    {/eq}
                                                                    {eq name="vo['type']" value="2"}
                                                                    <div class="floatright coup-btn"><a href="{:url('stroe/index',['stroe_id'=>$vo['type_id']])}" class="backga1">立即使用</a></div>
                                                                    {/eq}
                                                                </div>    

                                                            </div>
                                                        {elseif $state==2 }
                                                            <div class="coupon-alls">
                                                                <div class="couponlistone">
                                                                    <p class="coup-price">￥{$vo['cop_price']}</p>
                                                                    <p class="coup-text">满{$vo['full_amount']}元方可使用</p>
                                                                </div>
                                                                <div class="couponlisttwo">
                                                                    <div class="coupnametime floatleft">
                                                                        {eq name="vo['type']" value="1"}
                                                                        <p class="coupname">商品：{$vo['goods_name']}</p>
                                                                        {/eq}
                                                                        {eq name="vo['type']" value="2"}
                                                                        <p class="coupname">店铺：{$vo['store_name']}</p>
                                                                        {/eq}
                                                                        <p class="couptime">有效期：{$vo['copb_time']}</p>
                                                                    </div>
                                                                    <div class="floatright coup-btn"><a href="javascript:;" class="backga2">已过期</a></div>
                                                                </div>
                                                            </div>
                                                        {else/}
                                                            <div class="coupon-alls">
                                                                <div class="couponlistone">
                                                                    <p class="coup-price">￥{$vo['cop_price']}</p>
                                                                    <p class="coup-text">满{$vo['full_amount']}元方可使用</p>
                                                                </div>
                                                                <div class="couponlisttwo">
                                                                    <div class="coupnametime floatleft">
                                                                        {eq name="vo['type']" value="1"}
                                                                        <p class="coupname">商品：{$vo['goods_name']}</p>
                                                                        {/eq}
                                                                        {eq name="vo['type']" value="2"}
                                                                        <p class="coupname">店铺：{$vo['store_name']}</p>
                                                                        {/eq}
                                                                        <p class="couptime">有效期：{$vo['copb_time']}</p>
                                                                    </div>
                                                                    <div class="floatright coup-btn"><a href="javascript:;" class="backga3">已使用</a></div>
                                                                </div><div class="record_div floatfalse">
                                                                    <p class="coupongoodsn">使用的商品：{$vo['use_goods_name']}</p>
                                                                    <p class="shiyongsj">使用的时间：{$vo['create_time']}</p>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                        <div style="height:15px;"></div>
                                                    </td>
                                                    <td>
                                                        {if $state==1}可用的{elseif $state==2 }已过期{else/}使用记录{/if}
                                                    </td>
                                                    <td>1</td>
                                                    <td>{$vo['copb_time']}</td>
                                                </tr>
                                                {/volist}
                                            </tbody>
                                        </table>
                                        {if count($list) < 1}
                                            <div class="wushuju_text">暂无数据</div>
                                        {/if}
                                        <div class="page-div">{$page}</div>
                                    </div>
                                </form>
                            </div>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/coupon/index.js"></script>
    </body>
</html>
