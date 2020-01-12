<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的手机号码</title>
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
                                <div class="membert-auto">
                                    <div>当前手机号码：13526512548</div>
                                    <div>修改为：<input type="text" id="member_mobile" class="member_text" placeholder="输入新的手机号码"/></div>
                                    <div>验证码：<input type="text" id="code" class="member_text" placeholder="输入手机验证码"/></div>
                                    <div><input type="button" value="获取手机验证码" class="update_btn" id="onCode" onclick="verificationCode(this)"/></div>
                                    <div><input type="button" value="立即修改" class="update_btn" onclick="memberMobile(this)"/></div>
                                </div>
                            </div>
                            
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                            
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/member/member_mobile.js"></script>
    </body>
</html>
