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

                            <ul class="login-ul floatfalse">
                                <li class="login-li">
                                    <div class="bacg-lihui2">
                                        <div class="bacgli-auto">
                                            {if !$store['id']}
                                                <div class="seller_abtn1">
                                                    <a href="{:url('seller/seller_contact')}">立即入住</a>
                                                </div>
                                            {/if}
                                            <div class="seller_abtn2">
                                                <a href="{:url('seller/seller_audit')}">查看审核进度</a>
                                            </div>
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
