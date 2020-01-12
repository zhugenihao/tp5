

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>修改用户名</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/member_name.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="mname-all allas">
                <div class="mname-auto">
                    <ul class="mname-ul">
                        <li class="mname-li">当前用户名为：{$memberInfo['member_name']}</li>
                        <li class="mname-li mname-xiugai">
                            <div class="mname-title">修改为：</div>
                            <div class="mname-input">
                                <input type="text" name="member_name" id="member_name" placeholder="请输入用户名" class="layui-input">
                            </div>
                        </li>
                    </ul>
                    <div class="mname-btndiv floatfalse">
                        <a href="#" class="mname-btn" onclick="memberName(this)">立即修改</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="__MOBILE__/js/member/member_name.js"></script>
    </body>
</html>
