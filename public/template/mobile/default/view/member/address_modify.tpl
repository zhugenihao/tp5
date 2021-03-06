
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
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/address_details.css" />
        {include file="public/address"}
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="address-all allas">
                <form class="layui-form" action="">
                    <ul class="address-ul">
                        <li class="address-li">
                            <div class="address-liauto">
                                <div class="address-name floatleft">收货人：</div>
                                <div class="name-div floatleft">
                                    <input type="text" name="ads_name" lay-verify="required" value="{$addressInfo['ads_name']}" class="layui-input">
                                </div>
                            </div>
                        </li>
                        <li class="address-li">
                            <div class="address-liauto">
                                <div class="address-name floatleft">联系方式：</div>
                                <div class="name-div2 floatleft">
                                    <input type="text" name="ads_mobile" lay-verify="required|phone" value="{$addressInfo['ads_mobile']}" class="layui-input">
                                </div>
                            </div>
                        </li>
                        <li class="address-li" id="addressbtn">
                            <div class="address-liauto" id="address-autoas">
                                <div class="address-name floatleft">选择地区：</div>
                                <div class="floatleft" id="addresstext">
                                    <span>{$addressInfo['province_name']}</span>
                                    <span>{$addressInfo['city_name']}</span>
                                    <span>{$addressInfo['county_name']}</span>
                                    <span>{$addressInfo['town_name']}</span>
                                </div>
                                <div class="floatright">
                                    <i class="Hui-iconfont">&#xe6d7;</i>
                                </div>
                            </div>
                        </li>
                        <li class="address-li">
                            <div class="address-liauto">
                                <div class="address-name">详细地址：</div>
                                <div class="address-text">
                                    <textarea class="layui-textarea" name="detaddress" lay-verify="required">{$addressInfo['detaddress']}</textarea>
                                </div>
                            </div>
                        </li>
                        <li class="address-li">
                            <div class="address-liauto">
                                <div class="address-name">地址标志：</div>
                                <div class="address-bjas">
                                    {volist name="AddressSignList" id="vo" key="index"}
                                    <div class="address-bj {if $vo['id']==$addressInfo['sign_id']}bj-active{/if}" data-id="{$vo['id']}">{$vo['sign_name']}</div>
                                    {/volist}
                                    {volist name="memberAddressSignList" id="vo" key="index"}
                                    <div class="floatleft">
                                        <div class="address-bj {if $vo['id']==$addressInfo['sign_id']}bj-active{/if}" data-id="{$vo['id']}">{$vo['sign_name']}</div>
                                        <a href="javascript:" class="delsigns floatleft" data-id="{$vo['id']}">删除</a>
                                    </div>
                                    {/volist}
                                    <div class="address-bj" id="add_sign">添加标志</div>
                                    <div class="address-bj colordel" id="del_sign">删除标志</div>
                                </div>
                            </div>
                            <input type="hidden" value="{$addressInfo['sign_id']}" name="sign_id" class="sign_id" />
                        </li>
                        <li class="address-li">
                            <div class="address-liauto">
                                <div class="address-name floatleft">设置为默认地址：</div>
                                <div class="floatright">
                                    <input type="checkbox" name="ads_default" lay-skin="switch" lay-text="ON|OFF" {if $addressInfo['ads_default']=='on'}checked{/if} >
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="address-btn">
                        <a href="#" class="address-a" lay-submit="" lay-filter="demo1">修改收货地址</a>
                    </div>
                    <div class="addressid">
                        <input type="hidden" value="{$addressInfo['province_id']}" id="province_id" name="province_id"/>
                        <input type="hidden" value="{$addressInfo['city_id']}" id="city_id" name="city_id"/>
                        <input type="hidden" value="{$addressInfo['county_id']}" id="county_id" name="county_id"/>
                        <input type="hidden" value="{$addressInfo['town_id']}" id="town_id" name="town_id"/>
                    </div>

                    <input type="hidden" value="{$addressInfo['ads_id']}" name="ads_id" class="ads_id" />
                </form>
            </div>
            <div class="all-div">
                <div class="allbacg" id="addrehide"></div>
                <div class="allautoas">
                    <div class="allautoas-auto">
                        <div class="allautoas-title">
                            <div class="ada-active" data-id="0">省级</div>
                            <div id="city" data-id="">市级</div>
                            <div id="county" data-id="">县级</div>
                            <div id="town" data-id="">镇级</div>
                        </div>
                    </div>
                    <ul class="allautoas-ul" id="provincelist">
                        {volist name="provinceList" id="vo"}
                        <li data-id="{$vo['id']}">{$vo['name']}</li>
                            {/volist}
                    </ul>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="__MOBILE__/js/member/address_modify.js"></script>
    </body>
</html>
