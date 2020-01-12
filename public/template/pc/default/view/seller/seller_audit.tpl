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
                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">2</div>
                                    <div class="progress-title title-auto">填写公司信息</div>
                                </li>
                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">3</div>
                                    <div class="progress-title title-auto">填写店铺信息</div>
                                </li>
                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">4</div>
                                    <div class="progress-title title-auto">资质上传</div>
                                </li>
                                <li class="progress-li bacactive-red" style="width:100px;">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num floatright"><i class="Hui-iconfont">&#xe6a7;</i></div>
                                    <div class="progress-title progress-mg2">等待审核</div>
                                </li>
                            </ul>
                            <ul class="login-ul floatfalse">
                                <li class="login-li">
                                    <div class="bacg-lihui2">
                                        <div class="bacgli-auto">
                                            {eq name="store['audit']" value="10"}
                                            <div class="bacgliname1">审核中...</div>
                                            <div class="bacgliname2">请耐心等待。</div>
                                            {/eq}
                                            {eq name="store['audit']" value="20"}
                                            <div class="bacgliname1">你的审核已通过！</div>
                                            <div class="bacgliname2">你的商家后台初始账号密码是：{$seller['seller_name']}(账号)，{$seller['initial_password']}(初始密码)，请登录及时修改。</div>
                                            {/eq}
                                            {eq name="store['audit']" value="30"}
                                            <div class="bacgliname1">你的审核未通过！</div>
                                            <div class="bacgliname2">请重新提交资料,原因图片模糊。</div>
                                            <a href="{:url('seller/seller_contact')}" class="shangyb-btn4">去修改资料</a>
                                            {/eq}
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/seller_audit.js"></script>

    </body>
</html>
