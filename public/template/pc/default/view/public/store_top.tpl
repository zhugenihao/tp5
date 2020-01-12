<link rel="stylesheet" type="text/css" href="__PC__/css/public/top.css" />
{eq name="store['tpl_id']" value="2"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template.css" />
{/eq}
{eq name="store['tpl_id']" value="3"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template1.css" />
{/eq}
{eq name="store['tpl_id']" value="4"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template2.css" />
{/eq}
{eq name="store['tpl_id']" value="5"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template3.css" />
{/eq}
{eq name="store['tpl_id']" value="6"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template4.css" />
{/eq}
{eq name="store['tpl_id']" value="7"}
<link rel="stylesheet" type="text/css" href="__PC__/css/store/template5.css" />
{/eq}
<div class="indextop-all">
    <div class="index-top">
        <div class="indextop-auto pcdiv-auto">
            <div class="loginrg-top floatleft">
                <div><a href="{:url('index/index')}">总商城首页</a></div>
                {if $memberInfo['id']}
                    <div>当前用户：<a href="{:url('member/index')}">{$memberInfo['member_name']}</a></div>
                    {else/}
                    <div><a href="{:url('login/login')}">会员登录</a></div>
                    <div><a href="{:url('login/registered')}">注册</a></div>
                {/if}
            </div>
            <div class="cartkf-top floatright">
                <div><a href="{:url('cart/cartlist')}">购物车({$cartCount})</a></div>
                <div><a href="">联系客服</a></div>
                <div><a href="{:url('member/index')}">个人中心</a></div>
                <div><a href="{:url('seller/seller_index')}">商家入驻</a></div>
                <div><a href="{:url('seller/login')}">商家登录</a></div>
            </div>
        </div>
    </div>
    <div class="index-logosh pcdiv-auto">
        <div class="logosh-auto">
            <div class="logo-img floatleft">
                <a href="{:url('index/index')}"><img src="__STATIC__/{$store['logo']}"/></a>
            </div>
            <div class="index-search floatleft">
                <div class="store_name">店铺名称：{$store['store_name']}</div>
                <div class="store_name">店铺等级：{$store['level_name']}</div>
            </div>
        </div>
    </div>
</div>
<div class="advert-img pcdiv-auto">
    <a href=""><img src="__STATIC__/{$store['banner']}"/></a>
</div>
<div class="index-categoty">
    <div class="categoty-auto pcdiv-auto">
        <ul class="categoty-ul">
            <li class="categoty-li">
                <a href="{:url('store/index')}" class="storeid_a">首页</a>
            </li>
            {volist name="category" id="vo"}
            <li class="categoty-li">
                <a href="{:url('store/category_index',['cat_id'=>$vo['cat_id']])}" 
                   {eq name="vo['is_newwindow']" value="1"} target="_blank"{/eq} class="storeid_a">
                    {$vo.cat_name}
                </a>
            </li>
            {/volist}
        </ul>
    </div>
</div>
<input type="hidden" value="{:input('store_id')}" id="store_id"/>
<script type="text/javascript" src="__PC__/js/public/store_top.js"></script>