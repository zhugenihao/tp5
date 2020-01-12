<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>注册页面</title>
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
                        <div class="login_title">注册账号</div>
                        <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form">
                            <ul class="login-ul">
                                <li class="login-li">
                                    <input type="text" value="" name="mobile" class="loginli-input" placeholder="手机号"/>
                                </li>
                                <li class="login-li">
                                    <input type="password" value="" name="password" class="loginli-input" placeholder="登录密码" id="password"/>
                                </li>
                                <li class="login-li">
                                    <input type="password" value="" name="confirm_password" class="loginli-input" placeholder="请输入确认密码" id="confirm_password"/>
                                </li>

                                <!--<li class="login-li">
                                    <input type="text" value="" name="" class="loginli-input" placeholder="手机验证码"/>
                                </li>
                                <li class="login-li">
                                    <input type="button" value="获取手机验证码" class="mobile-yzmbtn" id="btncode" onclick="verificationCode(this)"/>
                                </li>-->
                                <li class="login-li">
                                    <input type="text" value="" name="code_img" class="loginli-input" placeholder="验证码"/>
                                </li>
                                <li class="login-li">
                                    <img src="{:url('login/verify_code')}" class="login-yanzhengma" onclick="captchaSrc(this);"/>
                                </li>
                                <li class="login-li">
                                    <div class="agreement floatfalse">
                                        <input type="checkbox" name="agreement" lay-skin="primary" title=""/>
                                        <a href="">注册协议</a>
                                    </div>
                                </li>
                                <li class="login-li li-submit">
                                    <input type="button" value="立即注册" class="login-btn" onclick="registeredSubmit(this);"/>
                                </li>
                                <li class="fged-li">
                                    <a href="{:url('login/forgotpassword')}" class="forgotpassword">忘记密码</a>
                                    <a href="{:url('login/login')}" class="registered">快去登录</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/login/registered.js"></script>
        <script type="text/javascript">
            function captchaSrc(obj) {
                $('.login-yanzhengma').attr("src", "{:url('login/verify_code')}?'+Math.random();");
            }
        </script>
    </body>
</html>
