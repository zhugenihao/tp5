<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的用户名</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="member-all">
                <!--头部栏目-->
                {include file="public/member_top" /}
                <div class="pcdiv-auto">
                    <div class="membertext-all">
                        <!--左部栏目-->
                        {include file="public/account_settings_left" /}
                        
                        <div class="member-right floatleft">
                            <div class="member-text">
                                <div class="membert-auto">
                                    <div>当前用户名：{$memberInfo['member_name']}</div>
                                    <div>修改为：<input type="text" class="member_text" placeholder="输入新的用户名" id="member_name"/></div>
                                    <div><input type="button" value="立即修改" class="update_btn" onclick="memberName(this)"/></div>
                                </div>
                            </div>
                            
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                            
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/member/member_name.js"></script>
    </body>
</html>
