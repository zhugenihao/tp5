
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>账号登录</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/login/registered.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text2" /}
            <div class="registered-all allas">
                <div class="registered-auto">

                    <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form">
                        <div class="registered-top">
                            <i class="Hui-iconfont">&#xe62c;</i>
                        </div>
                        <div class="registered-divul">
                            <ul class="registered-ul">
                                <li class="registered-li">
                                    <input type="text" name="name_mobile" placeholder="请输入手机号/用户名" class="layui-input">
                                </li>
                                <li class="registered-li">
                                    <input type="password" name="password" placeholder="请输入密码" class="layui-input">
                                </li>
                            </ul>
                        </div>
                        <div class="registered-btnas floatfalse">
                            <a href="javascript:void(0)" class="registered-btn" onclick="loginSubmit(this)">立即登录</a>
                        </div>
                        <p class="registered-login">
                            <a href="{:url('member/forgot_password')}" class="floatleft">忘记密码</a>
                            <a href="{:url('login/registered')}" class="floatright">去注册账号</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/login/login.js"></script>
    </body>
</html>
