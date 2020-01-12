<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商家入驻</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/login.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="login-div">
                <div class="login-auto">
                    <div class="login-text">
                        <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form login-text2">
                            <div class="login_title">商家入驻</div>
                            <ul class="progress-ul">
                                <li class="progress-li bacactive-red" style="width:100px;">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num">1</div>
                                    <div class="progress-title progress-mg1">联系信息</div>
                                </li>
                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">2</div>
                                    <div class="progress-title title-auto">填写公司信息</div>
                                </li>
                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">3</div>
                                    <div class="progress-title title-auto">填写店铺信息</div>
                                </li>
                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">4</div>
                                    <div class="progress-title title-auto">资质上传</div>
                                </li>
                                <li class="progress-li bacactive-hui" style="width:100px;">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num floatright"><i class="Hui-iconfont">&#xe6a7;</i></div>
                                    <div class="progress-title progress-mg2">等待审核</div>
                                </li>
                            </ul>
                            <ul class="login-ul floatfalse">
                                <li class="login-li">
                                    <div class="bacg-lihui">
                                        <div class="bacgli-auto">
                                            <div>联系信息</div>
                                            <div class="bacgli-title2">卖家入驻联系人信息,用于入驻过程中接收平台官方反馈的入驻通知，请务必填写正确</div>
                                        </div>
                                    </div>

                                </li>
                                <li class="login-li">
                                    <span>联系人姓名</span>
                                    <input type="text" value="" name="contact_name" class="loginli-input" placeholder="请输入联系人姓名" id="contact_name"/>
                                </li>
                                <li class="login-li">
                                    <span>联系人手机</span>
                                    <input type="text" value="" name="contact_mobile" class="loginli-input" placeholder="请输入联系人手机" id="contact_mobile"/>
                                </li>
                                <li class="login-li">
                                    <span>联系人电子邮箱</span>
                                    <input type="text" value="" name="contact_email" class="loginli-input" placeholder="请输入电子邮箱" id="contact_email"/>
                                </li>

                                <li class="login-li">
                                    <span>申请类型</span>
                                    <div class="appltype">
                                        <input type="radio" name="application_type" checked="" value="1" title="个人入驻">
                                        <input type="radio" name="application_type" checked="" value="2" title="企业入驻">
                                    </div>
                                </li>
                                <li class="login-li li-submit">
                                    <input type="button" value="下一步,填写公司信息" class="login-btn" onclick="registeredSubmit(this);"/>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/registered.js"></script>

    </body>
</html>
