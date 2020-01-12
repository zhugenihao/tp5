<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>忘记密码</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/login/login.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/login_top" /}
            <div class="login-div">
                <div class="login-auto">
                    <div class="login-text">
                        <div class="login_title">找回登录密码</div>
                        <ul class="login-ul">
                            <li class="login-li">
                                <input type="text" value="" name="mobile" class="loginli-input" placeholder="手机号"/>
                            </li>
                            <li class="login-li">
                                <input type="text" value="" name="" class="loginli-input" placeholder="手机验证码"/>
                            </li>
                            <li class="login-li">
                                <input type="button" value="获取手机验证码" class="mobile-yzmbtn" />
                            </li>
                            <li class="login-li">
                                <input type="password" value="" name="password" class="loginli-input" placeholder="新登录密码"/>
                            </li>
                            <li class="login-li">
                                <input type="password" value="" name="confirm_password" class="loginli-input" placeholder="确认新密码"/>
                            </li>
                            <li class="login-li">
                                <input type="text" value="" name="" class="loginli-input" placeholder="验证码"/>
                            </li>
                            <li class="login-li">
                                <img src="/static/images/yzm.png" class="login-yanzhengma"/>
                            </li>
                            <li class="login-li li-submit">
                                <input type="submit" value="立即找回" class="login-btn" />
                            </li>
                            <li class="fged-li">
                                <a href="{:url('login/registered')}" class="forgotpassword">快去注册</a>
                                <a href="{:url('login/login')}" class="registered">快去登录</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/login/login.js"></script>
    </body>
</html>
