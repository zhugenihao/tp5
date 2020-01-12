
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>订单详情</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="goods-cate2" id="goods-details">
                        <div class="details-title" id="detailstitle">
                            <div class="detls-act">基本信息</div>
                            <div>会员信息</div>
                            <div>商品信息</div>
                            <div>物流信息</div>
                        </div>
                        <div class="detlstext-auto2">
                            <div class="detlstextauto3">
                                <div class="detlstextone" style="display: block;">
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            订单类型：
                                        </label>
                                        <div class="form_text">
                                            {eq name="order['activity']" value="spell_group"}拼团订单{/eq}
                                            {eq name="order['activity']" value="seconds_kill"}秒杀订单{/eq}
                                            {eq name="order['activity']" value="comdysalesp"}促销订单{/eq}
                                            {in name="order['activity']" value="a_separate_buy,''"}普通订单{/in}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            订单编号：
                                        </label>
                                        <div class="form_text">
                                            {$order['order_no']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            总运费：
                                        </label>
                                        <div class="form_text">
                                            ￥{$order['courier_price']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            实付总金额(含运费)：
                                        </label>
                                        <div class="form_text">
                                            ￥<input type="text" value="{$order['total_price']}" name="total_price" class="mall_input" id="total_price" size="20">
                                            {if $order['state']=='10'}
                                                <botton class="mall_btn goodsbtn_act floatright" onclick="modifyTotalPrice(this)" data-orderid="{$order['id']}">修改金额</botton>
                                                {/if}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            支付方式：
                                        </label>
                                        <div class="form_text">
                                            {$order['payment']['payment_name']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            订单状态：
                                        </label>
                                        <div class="form_text">
                                            {if $order['state']=='10'}
                                                <span class="color-blue">待付款</span>
                                                <botton class="mall_btn goodsbtn_act floatright" onclick="modifyStart(this)" data-orderid="{$order['id']}" data-ordertype="order">
                                                    帮付款
                                                </botton>
                                            {elseif($order['state']=='11') /} 
                                                <span class="color-red">交易关闭</span>
                                            {elseif($order['state']=='20') /} 
                                                <span class="color-blue">待发货</span>
                                                <botton class="mall_btn goodsbtn_act floatright" onclick="deliveryStart(this)" data-orderid="{$order['id']}" data-ordertype="order">
                                                    立即发货
                                                </botton>
                                            {elseif($order['state']=='30') /} 
                                                <span class="color-blue">待收货</span>
                                            {elseif($order['state']=='40') /} 
                                                <span class="color-green">已完成</span>
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            下单时间：
                                        </label>
                                        <div class="form_text">
                                            {if $order['order_time']}
                                                {$order['order_time']|date='Y-m-d H:i:s',###}
                                            {else/}0{/if}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            付款时间：
                                        </label>
                                        <div class="form_text">
                                            {if $order['payment_time']}
                                                {$order['payment_time']|date='Y-m-d H:i:s',###}
                                            {else/}0{/if}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            发货时间：
                                        </label>
                                        <div class="form_text">
                                            {if $order['delivery_time']}
                                                {$order['delivery_time']|date='Y-m-d H:i:s',###}
                                            {else/}0{/if}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            完成时间：
                                        </label>
                                        <div class="form_text">
                                            {if $order['complete_time']}
                                                {$order['complete_time']|date='Y-m-d H:i:s',###}
                                            {else/}0{/if}
                                        </div>
                                    </div>
                                </div>
                                <div class="detlstextone">
                                    {if $order['activity']=='spell_group'}
                                        <div class="div_texts">
                                            <label class="form_title">
                                                <i class="Hui-iconfont color-red">&#xe630;</i>
                                                团员：
                                            </label>
                                            <div class="form_text">
                                                <p>
                                                    {$order['sg_members_num']}人成团，
                                                    {if $order['sgm_member_poor'] > 0}
                                                        还差{$order['sgm_member_poor']}人 
                                                    {else/} 人数已满，可以发货{/if}
                                                </p>
                                                <ul class="pintuanimg sgm_mlist">
                                                    {volist name="order['sgm_member_list']" id="sgmvo" key="index"}
                                                    <li class="sgm_mlist-li" title="{$sgmvo['member_name']}">
                                                        <img src="__STATIC__/{$sgmvo['photo']}" class="{if $index==1}pintuanimg-active{/if}" onerror="imgExists(this)"/>
                                                        <p class="sgm_membern">{$sgmvo['member_name']}</p>
                                                    </li>
                                                    {/volist}
                                                </ul>
                                            </div>
                                        </div>
                                    {/if}

                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            会员名称：
                                        </label>
                                        <div class="form_text">
                                            {$order['member']['member_name']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            收货人：
                                        </label>
                                        <div class="form_text">
                                            {$order['ads_name']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            手机号码：
                                        </label>
                                        <div class="form_text">
                                            {$order['ads_mobile']}
                                        </div>
                                    </div>
                                    <div class="div_texts">
                                        <label class="form_title">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            收货地址：
                                        </label>
                                        <div class="form_text">
                                            {$order['tcgaddress']}
                                        </div>
                                    </div>
                                </div>
                                <div class="detlstextone">
                                    <table border="1" class="churuzhang-tb floatfalse">
                                        <thead class="churuzhang-te">
                                            <tr>
                                                <th>编号</th>
                                                <th>商品名称</th>
                                                <th>规格信息</th>
                                                <th>商品单价</th>
                                                <th>商品数量</th>
                                                <th>支付方式</th>
                                                <th width="90">小计</th>
                                                <th width="80">订单状态</th>
                                                <th width="170">下单时间</th>
                                                <th width="120">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody class="churuzhang-ty">
                                            {volist name="order['order_goods']" id="vo"}
                                            <tr class="tbcenter">
                                                <th>{$vo['id']}</th>
                                                <td>
                                                    <div class="goods-names">
                                                        <img src="__STATIC__/{$vo['goods']['thecover']}" width="20" />&nbsp;
                                                        {$vo['goods']['goods_name']}
                                                    </div>
                                                </td>
                                                <th><div class="goods-names">{$vo['goods_information']}</div></th>
                                                <th>{$vo['goods_price']}</th>
                                                <td>{$vo['goods_num']}</td>
                                                <th>{$vo['payment']['payment_name']}</th>
                                                <td>{$vo['total_price']}</td>
                                                <td>
                                                    {if $vo['state']=='10'}
                                                        <span class="color-blue">待付款</span>
                                                    {elseif($vo['state']=='11') /} 
                                                        <span class="color-red">交易关闭</span>
                                                    {elseif($vo['state']=='20') /} 
                                                        <span class="color-blue">待发货</span>
                                                    {elseif($vo['state']=='30') /} 
                                                        <span class="color-blue">待收货</span>
                                                    {elseif($vo['state']=='40') /} 
                                                        <span class="color-green">已完成</span>
                                                    {/if}
                                                </td>
                                                <th>{$vo['tord_time']|date='Y-m-d H:i:s',###}</th>
                                                <td></td>
                                            </tr>
                                            {/volist}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="detlstextone">
                                    <ul class="orderwuliu-ul">
                                        <li class="orderwuliu-li wuliu-act">
                                            <div class="orderwuliu-div1">
                                                <div class="orderwuliu-jd"></div>
                                                <div class="orderwuliu-yd"></div>
                                            </div>
                                            <div class="orderwuliu-div2">
                                                <div class="orderwuliu-div2-auto">
                                                    <div class="orderwuliu-time"><p class="wuliutime-p">时间 2014-8-31 15:20</p></div>
                                                    <div class="orderwuliu-text">
                                                        <p class="wuliutext-p">你是猴子派来的救兵吗？</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderwuliu-li">
                                            <div class="orderwuliu-div1">
                                                <div class="orderwuliu-jd"></div>
                                                <div class="orderwuliu-yd"></div>
                                            </div>
                                            <div class="orderwuliu-div2">
                                                <div class="orderwuliu-div2-auto">
                                                    <div class="orderwuliu-time"><p class="wuliutime-p">时间 2014-8-31 15:20</p></div>
                                                    <div class="orderwuliu-text">
                                                        <p class="wuliutext-p">你是猴子派来的救兵吗？</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderwuliu-li">
                                            <div class="orderwuliu-div1">
                                                <div class="orderwuliu-jd"></div>
                                                <div class="orderwuliu-yd"></div>
                                            </div>
                                            <div class="orderwuliu-div2">
                                                <div class="orderwuliu-div2-auto">
                                                    <div class="orderwuliu-time"><p class="wuliutime-p">时间 2014-8-31 15:20</p></div>
                                                    <div class="orderwuliu-text">
                                                        <p class="wuliutext-p">你是猴子派来的救兵吗？</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderwuliu-li">
                                            <div class="orderwuliu-div1">
                                                <div class="orderwuliu-jd"></div>
                                                <div class="orderwuliu-yd"></div>
                                            </div>
                                            <div class="orderwuliu-div2">
                                                <div class="orderwuliu-div2-auto">
                                                    <div class="orderwuliu-time"><p class="wuliutime-p">时间 2014-8-31 15:20</p></div>
                                                    <div class="orderwuliu-text">
                                                        <p class="wuliutext-p">你是猴子派来的救兵吗？</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="orderwuliu-li">
                                            <div class="orderwuliu-div1">
                                                <div class="orderwuliu-jd"></div>
                                                <div class="orderwuliu-yd"></div>
                                            </div>
                                            <div class="orderwuliu-div2">
                                                <div class="orderwuliu-div2-auto">
                                                    <div class="orderwuliu-time"><p class="wuliutime-p">时间 2014-8-31 15:20</p></div>
                                                    <div class="orderwuliu-text">
                                                        <p class="wuliutext-p">你是猴子派来的救兵吗？</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="returnOnPage(this)">确定</botton>
                    </div>

                </div>
                <input type="hidden" value="{$order['id']}" name="id" />
            </form>
        </div>
    </div>

</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/order/order_details.js"></script>
