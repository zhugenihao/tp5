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
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/login.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="login-div2">
                <div class="login-auto2">
                    <div class="login-text3">
                        <div class="login_title2">商家后台登录</div>
                        <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form">
                            <ul class="login-ul">
                                <li class="login-li">
                                    <input type="text" value="" name="name_mobile" class="loginli-input3" placeholder="用户名/手机号"/>
                                </li>
                                <li class="login-li">
                                    <input type="password" value="" name="password" class="loginli-input3" placeholder="登录密码"/>
                                </li>
                                <li class="login-li">
                                    <input type="text" value="" name="code_img" class="loginli-input3" placeholder="验证码"/>
                                </li>
                                <li class="login-li">
                                    <img src="{:url('seller/verify_code')}" class="login-yanzhengma" onclick="captchaSrc(this);"/>
                                </li>
                                <li class="login-li li-submit">
                                    <input type="button" value="立即登录" class="login-btn3" onclick="loginSubmit(this)" id="seller_login"/>
                                </li>
                                
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/login.js"></script>
        <script type="text/javascript">
            function captchaSrc(obj) {
                $('.login-yanzhengma').attr("src", "{:url('seller/verify_code')}?'+Math.random();");
            }
        </script>
    </body>
</html>
