<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>账号设置</title>
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
                                <form action="" method="post" enctype="multipart/form-data" name="formsubmit"  >
                                    <div class="member-photo"><img src="__STATIC__/{$memberInfo['photo']}" /></div>
                                    <div class="membertext_1">
                                        <div class="member-uname">我的头像</div>
                                        <div class="member-yeys">
                                            <a href="javascript:;" id="clickphoto">头像修改</a>
                                            <input type="file" multiple="" accept="image/*" name="photo" id="idphoto" class="hide">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}

                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/member/account_settings.js"></script>
    </body>
</html>
