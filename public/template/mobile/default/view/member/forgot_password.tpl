

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
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/forgot_password.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="mname-all allas">
                <div class="mname-auto">
                    <ul class="mname-ul">
                        <li class="mname-li">当前手机号码：13256235645</li>

                        <li class="mname-li mobile-in">
                            <input type="text" name="title" lay-verify="title" placeholder="请输入手机验证码" class="layui-input inputtext">
                            <button class="layui-btn bacgbtn">获取手机验证码</button>
                        </li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">设置新密码：</div>
                            <div class="mname-input">
                                <input type="text" name="title" lay-verify="title" placeholder="请输入新密码" class="layui-input">
                            </div>
                        </li>
                    </ul>
                    <div class="mname-btndiv floatfalse">
                        <a href="#" class="mname-btn">立即修改</a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/member/forgot_password.js"></script>
    </body>
</html>
