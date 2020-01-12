

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>修改登录密码</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/member_password.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="mname-all allas">
                <div class="mname-auto">
                    <ul class="mname-ul">
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">原始登录密码：</div>
                            <div class="mname-input">
                                <input type="password" name="password_old" id="password_old" placeholder="请输入原始登录密码" class="layui-input">
                            </div>
                        </li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">新的密码：</div>
                            <div class="mname-input">
                                <input type="password" name="password_new" id="password_new" placeholder="请输新的登录密码" class="layui-input">
                            </div>
                        </li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">确认密码：</div>
                            <div class="mname-input">
                                <input type="password" name="password_queren" id="password_queren" placeholder="请输入确认登录密码" class="layui-input">
                            </div>
                        </li>
                    </ul>
                    <div class="mname-btndiv floatfalse">
                        <a href="#" class="mname-btn" onclick="memberPassword(this)">立即修改</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/member/member_password.js"></script>
    </body>
</html>
