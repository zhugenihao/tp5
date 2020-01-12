
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
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/member_address.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text2" /}
            <div class="address-all allas">
                <ul class="address-ul">
                    {volist name="addressList" id="vo" key="i"}
                    <li class="address-li">
                        <div class="address-liauto">
                            <div class="address-text floatleft">
                                {if $vo['ads_default']=='on'}<span class="adsdefault">默认</span>{/if}
                                {$i}.{$vo['tcgaddress']}</div>
                            <div class="floatright"><a href="{:url('member/address_modify',['ads_id'=>$vo['ads_id']])}">修改</a></div>
                        </div>
                    </li>
                    {/volist}
                </ul>
            </div>
            <div class="address-btn">
                <a href="{:url('member/address_add')}" class="address-a">添加收货地址</a>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/member/member_address.js"></script>
    </body>
</html>
