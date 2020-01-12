<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>分类区域</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/directory/index.css" />
    </head>
    <body>
        
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="directory-all allas">
                <div class="directory-one">
                    <ul class="directory-oneul">
                        {volist name="directoryList" id="vo"}
                        <li class="directory-oneli" data-dirid="{$vo['id']}">
                            <a href="javascript:;" class="directory-onea">{$vo.alias}</a>
                        </li>
                        {/volist}
                    </ul>
                </div>
                <div class="directory-second">
                    <ul class="directory-sul" id="directory-lister">
                        
                    </ul>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/directory/index.js"></script>
        
    </body>
</html>
