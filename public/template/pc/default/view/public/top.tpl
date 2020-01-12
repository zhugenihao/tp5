<link rel="stylesheet" type="text/css" href="__PC__/css/public/top.css" />
<div class="indextop-all">
    <div class="index-top">
        <div class="indextop-auto pcdiv-auto">
            <div class="loginrg-top floatleft">
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
                <a href="{:url('index/index')}"><img src="__STATIC__/{$logo_images}"/></a>
            </div>
            <div class="index-search floatleft">
                <div class="index-inputs">
                    <input type="text" name="search" class="input-search" />
                </div>
                <div class="search-btn"><a href="javascript:;">搜索</a></div>
            </div>
        </div>
    </div>
</div>