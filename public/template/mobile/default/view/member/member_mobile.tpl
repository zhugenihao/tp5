

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>修改手机号码</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/member_mobile.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="mname-all allas">
                <div class="mname-auto">
                    <ul class="mname-ul">
                        <li class="mname-li">当前手机号码：13256235645</li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">修改为：</div>
                            <div class="mname-input">
                                <input type="text" name="member_mobile" id="member_mobile" placeholder="请输入手机号码" class="layui-input">
                            </div>
                        </li>
                        <li class="mname-li mobile-in">
                            <input type="text" name="code" id="code" placeholder="请输入手机验证码" class="layui-input inputtext">
                            <button class="layui-btn bacgbtn" onclick="verificationCode(this)" id="onCode">获取手机验证码</button>
                        </li>
                    </ul>
                    <div class="mname-btndiv floatfalse">
                        <a href="#" class="mname-btn" onclick="memberMobile(this)">立即修改</a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/member/member_mobile.js"></script>
    </body>
</html>
