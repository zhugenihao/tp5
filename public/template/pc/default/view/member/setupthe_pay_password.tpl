<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>设置支付密码</title>
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
                                    <div>新的支付密码：<input type="password" id="pay_password" class="member_text2" placeholder="输入新的密码"/></div>
                                    <div>确认支付密码：<input type="password" id="pay_password_queren" class="member_text2" placeholder="输入确认密码"/></div>
                                    <div><input type="button" value="立即设置" class="update_btn" onclick="memberSetPayPassword(this)"/></div>
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
        <script type="text/javascript" src="__PC__/js/member/setupthe_pay_password.js"></script>
    </body>
</html>
