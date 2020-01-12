
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
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/member/account_settings.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="account-all allas">
                <div class="account-auto">
                    <ul class="account-ul">
                        <li class="account-li account-top">
                            <form action="" method="post" enctype="multipart/form-data" name="formsubmit"  >
                                <div class="account-ulauto" id="clickphoto">
                                    <div class="floatleft account-divuser">
                                        <p class="account-img"><img src="__STATIC__/{$memberInfo['photo']}" onerror="imgExists(this)"/></p>
                                        <p class="account-name">头像</p>
                                    </div>
                                    <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                </div>
                                <input type="file"  multiple accept="image/*" name="photo" id="idphoto" class="hide"/>
                            </form>
                        </li>
                        <li class="account-li alias">
                            <div class="account-ulauto">
                                <a href="{:url('member/member_name')}">
                                    <div class="floatleft account-divuser">
                                        用户名：{$memberInfo['member_name']}
                                    </div>
                                    <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                </a>

                            </div>
                        </li>
                        <li class="account-li alias">
                            <div class="account-ulauto">
                                <a href="{:url('member/member_mobile')}">
                                    <div class="floatleft account-divuser">
                                        手机号码：{$memberInfo['mobile']}
                                    </div>
                                    <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                </a>
                            </div>
                        </li>

                        <li class="account-li alias">
                            <div class="account-ulauto">
                                <a href="{:url('member/member_password')}">
                                    <div class="floatleft account-divuser">
                                        修改登录密码
                                    </div>
                                    <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                </a>
                            </div>
                        </li>

                        {if $memberInfo['pay_password']==''}
                            <li class="account-li alias">
                                <div class="account-ulauto">
                                    <a href="{:url('member/setupthe_pay_password')}">
                                        <div class="floatleft account-divuser">
                                            设置支付密码
                                        </div>
                                        <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                    </a>
                                </div>
                            </li>
                        {else/}
                            <li class="account-li alias">
                                <div class="account-ulauto">
                                    <a href="{:url('member/pay_password')}">
                                        <div class="floatleft account-divuser">
                                            修改支付密码
                                        </div>
                                        <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                    </a>
                                </div>
                            </li>
                        {/if}
                        <li class="account-li alias">
                            <div class="account-ulauto">
                                <a href="{:url('member/member_address')}">
                                    <div class="floatleft account-divuser">
                                        我的收货地址
                                    </div>
                                    <div class="account-icon floatright"><i class="Hui-iconfont">&#xe6d7;</i></div>
                                </a>
                            </div>
                        </li>
                        <li class="account-li alias">
                            <div class="login-div account-ulauto">
                                <a href="#" class="login-btn" onclick="mLogout(this)">退出登录</a>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/member/account_settings.js"></script>
    </body>
</html>
