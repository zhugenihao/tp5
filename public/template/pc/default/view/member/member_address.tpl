<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的收货地址</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
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
                        {include file="public/account_settings_left" /}
                        
                        <div class="member-right floatleft">
                            <div class="member-text">
                                <div class="member_adds_title">收货地址列表</div>
                                <div class="addrs_add"><a href="{:url('member/address_add',['type'=>7])}">添加地址</a></div>
                                <ul class="member_adds_ul">
                                    {volist name="addressList" id="vo" key="index"}
                                    <li class="member_adds_li">
                                        <div class="adds_text">
                                            {eq name="vo['ads_default']" value="on"}
                                            <span class="adsdefault">默认</span>
                                            {/eq}
                                            {$index}.{$vo.tcgaddress}
                                        </div>
                                        <div class="adds_update"><a href="{:url('member/address_modify',['type'=>7,'ads_id'=>$vo['ads_id']])}">修改</a></div>
                                    </li>
                                    {/volist}
                                </ul>
                            </div>
                            
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                            
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/member/member_name.js"></script>
    </body>
</html>
