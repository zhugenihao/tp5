<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>修改收货地址</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/address_add.css" />
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
                                <form class="layui-form" action="" id="formsubmit">
                                    <div class="address-auto">
                                        <div class="address_div">修改收货地址</div>
                                        <div class="address_div">收货人：<input type="text" value="{$addressInfo['ads_name']}" name="ads_name" id="ads_name" class="member_text3" placeholder="输入收货人" /></div>
                                        <div class="address_div">联系方式：<input type="text" value="{$addressInfo['ads_mobile']}" name="ads_mobile" id="ads_mobile" class="member_text4" placeholder="输入联系方式"/></div>
                                        <div class="addre-region address_div">
                                            <div>选择地区：</div>
                                            <div class="layui-inline">
                                                <div class="layui-input-inline">
                                                    <select name="province_id" lay-filter="province" id="province">
                                                        <option value="0">请选择省份</option>
                                                        {volist name="provinceList" id="vo"}
                                                        <option value="{$vo['id']}" {eq name="addressInfo['province_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                        {/volist}
                                                    </select>
                                                </div>
                                                <div class="layui-input-inline">
                                                    <select name="city_id" lay-filter="city" id="city">
                                                        <option value="0">请选择市级</option>
                                                        {volist name="cityList" id="vo"}
                                                        <option value="{$vo['id']}" {eq name="addressInfo['city_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                        {/volist}
                                                    </select>
                                                </div>
                                                <div class="layui-input-inline">
                                                    <select name="county_id" lay-filter="county" id="county">
                                                        <option value="0">请选择县级</option>
                                                        {volist name="countyList" id="vo"}
                                                        <option value="{$vo['id']}" {eq name="addressInfo['county_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                        {/volist}
                                                    </select>
                                                </div>
                                                <div class="layui-input-inline">
                                                    <select name="town_id" lay-filter="town" id="town">
                                                        <option value="0">请选择镇级</option>
                                                        {volist name="townList" id="vo"}
                                                        <option value="{$vo['id']}" {eq name="addressInfo['town_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                        {/volist}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="address_tdiv address_div">
                                            <p>详细地址：</p>
                                            <p><textarea class="address_text" name="detaddress" id="detaddress" placeholder="输入详细地址">{$addressInfo['detaddress']}</textarea></p>
                                        </div>
                                        <div class="addrsbz_div floatfalse">
                                            <div>地址标志：</div>
                                            <ul class="addrsbz_ul" id="address_sign">
                                                {volist name="AddressSignList" id="vo" key="index"}
                                                <li class="{if $vo['id']==$addressInfo['sign_id']}sign_active{/if}" data-id="{$vo['id']}">{$vo['sign_name']}</li>
                                                    {/volist}

                                                {volist name="memberAddressSignList" id="vo" key="index"}
                                                <li class="{if $vo['id']==$addressInfo['sign_id']}sign_active{/if}" data-id="{$vo['id']}">{$vo['sign_name']}
                                                    <a href="javascript:" class="delsigns" data-id="{$vo['id']}">删除</a>
                                                </li>
                                                {/volist}
                                                <li id="add_sign">添加标志</li>
                                                <li id="del_sign" show="1">删除标志</li>
                                            </ul>
                                            <input type="hidden" value="{$addressInfo['sign_id']}" name="sign_id" class="sign_id">
                                        </div>
                                        <div class="address_mrdiv address_div">
                                            <p class="floatleft">默认收货地址：</p>
                                            <div class="layui-input-block floatleft">
                                                <input type="checkbox" name="ads_default" lay-skin="switch" lay-text="ON|OFF" {eq name="addressInfo['ads_default']" value="on"}checked{/eq}>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{$addressInfo['ads_id']}" name="ads_id" class="ads_id">
                                        <div class="upbtn_div floatfalse"><input type="button" value="立即修改" class="update_btn1" onclick="modifyAddress(this)"/></div>
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
        <script type="text/javascript" src="__PC__/js/member/address_modify.js"></script>
    </body>
</html>
