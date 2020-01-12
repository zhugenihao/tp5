

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>修改支付密码</title>
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
                            <div class="mname-title">原始支付密码：</div>
                            <div class="mname-input">
                                <input type="password" name="pay_password_old" id="pay_password_old" placeholder="请输入原始支付密码" class="layui-input">
                            </div>
                        </li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">新的支付密码：</div>
                            <div class="mname-input">
                                <input type="password" name="pay_password_new" id="pay_password_new" placeholder="请输新的支付密码" class="layui-input">
                            </div>
                        </li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">确认支付密码：</div>
                            <div class="mname-input">
                                <input type="password" name="pay_password_queren" id="pay_password_queren" placeholder="请输入确认支付密码" class="layui-input">
                            </div>
                        </li>
                    </ul>
                    <div class="mname-btndiv floatfalse">
                        <a href="#" class="mname-btn" onclick="memberPayPassword(this)">立即修改</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/member/pay_password.js"></script>
    </body>
</html>
