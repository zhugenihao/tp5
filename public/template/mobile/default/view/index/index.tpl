<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/index/index.css" />
    </head>
    <body>
        <div class="index-all">
            <div class="allhtml">
                {include file="public/top" /}
                <div class="index-content">
                    <iframe src="{:url('index/home')}" width="100%" height="100%" frameborder="0" id="iframe-url"></iframe>
                </div>
            </div>
            {include file="public/bottom" /}

        </div>
    </body>
</html>
