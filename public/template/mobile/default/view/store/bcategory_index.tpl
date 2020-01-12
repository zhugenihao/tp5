<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>店铺【{$store['store_name']}】的全部分类</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/directory/index.css" />
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/store/bcategory_index.css" />
    </head>
    <body>
        {include file="public/store_top" /}
        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="directory-all allas">
                <div class="directory-one">
                    <ul class="directory-oneul">
                        {volist name="bCategory" id="vo"}
                        <li class="directory-oneli" data-directory1id="{$vo['directory1_id']}">
                            <a href="javascript:;" class="directory-onea">{$vo.directory1_name}</a>
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
        <script type="text/javascript" src="__MOBILE__/js/store/bcategory_index.js"></script>

    </body>
</html>
