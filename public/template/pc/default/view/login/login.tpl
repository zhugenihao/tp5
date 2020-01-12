<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>登录页面</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/login/login.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="login-div">
                <div class="login-auto">
                    <div class="login-text">
                        <div class="login_title">会员登录</div>
                        <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form">
                            <ul class="login-ul">
                                <li class="login-li">
                                    <input type="text" value="" name="name_mobile" class="loginli-input" placeholder="用户名/手机号"/>
                                </li>
                                <li class="login-li">
                                    <input type="password" value="" name="password" class="loginli-input" placeholder="登录密码"/>
                                </li>
                                <!--<li class="login-li">
                                    <input type="text" value="" name="" class="loginli-input" placeholder="验证码"/>
                                </li>
                                <li class="login-li">
                                    <img src="/static/images/yzm.png" class="login-yanzhengma"/>
                                </li>-->
                                <li class="login-li li-submit">
                                    <input type="button" value="立即登录" class="login-btn" onclick="loginSubmit(this)" id="member_login"/>
                                </li>
                                <li class="fged-li">
                                    <a href="{:url('login/forgotpassword')}" class="forgotpassword">忘记密码</a>
                                    <a href="{:url('login/registered')}" class="registered">快去注册</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/login/login.js"></script>
    </body>
</html>
