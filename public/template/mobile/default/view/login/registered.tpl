
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>账号注册</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/login/registered.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text2" /}
            <div class="registered-all allas">
                <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form">
                    <div class="registered-auto">
                        <div class="registered-top">
                            <i class="Hui-iconfont">&#xe62c;</i>
                        </div>
                        <div class="registered-divul">
                            <ul class="registered-ul">
                                <li class="registered-li">
                                    <input type="text" name="mobile" placeholder="请输入手机号" class="layui-input">
                                </li>
                                <li class="registered-li">
                                    <input type="password" name="password" placeholder="请输入密码" class="layui-input">
                                </li>
                                <li class="registered-li">
                                    <input type="password" name="confirm_password" placeholder="请输入确认密码" class="layui-input">
                                </li>
                                <li class="registered-li input-yanz">
                                    <div class="floatleft input-as">
                                        <input type="text" name="code_img" placeholder="请输入验证码" class="layui-input inputtext">
                                    </div>
                                    <div class="vcode-div floatright">
                                        <img src="{:url('login/verify_code')}" class="vcode-img" onclick="captchaSrc(this);"/>
                                    </div>

                                </li>
                                <!--<li class="registered-li floatfalse input-yanz">
                                    <input type="text" name="code" lay-verify="title" placeholder="请输入手机验证码" class="layui-input inputtext">
                                    <button class="layui-btn bacgbtn" id="btncode" onclick="verificationCode(this)">获取手机验证码</button>
                                </li>-->
                            </ul>
                            <div class="agreement floatfalse">
                                <input type="checkbox" name="agreement" lay-skin="primary" title=""/>
                                <a href="">注册协议</a>
                            </div>
                        </div>
                        <div class="registered-btnas floatfalse">
                            <a href="javascript:void(0)" class="registered-btn" onclick="registeredSubmit(this);">立即注册</a>
                        </div>
                        <p class="registered-login"><a href="{:url('login/login')}">已有账号去登录</a></p>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/login/registered.js"></script>
        <script type="text/javascript">
            function captchaSrc(obj) {
                $('.vcode-img').attr("src", "{:url('login/verify_code')}?'+Math.random();");
            }
        </script>
    </body>
</html>
