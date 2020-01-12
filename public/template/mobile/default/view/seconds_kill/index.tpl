<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>秒杀中心</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/seconds_kill/index.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="seconds-all allas">
                <div class="seconds-topas">
                    <div class="seconds-top">
                        <ul class="secondstop-auto" id="secondstime">
                            {volist name="secondGoodsTimeList" id="vo"}
                            <li data-time="{$vo['time']}" id="timeli{$vo['time']}">
                                <p class="secpone">{$vo['title']}</p>
                                <p>即将开始</p>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
                <div class="seconds-cont">

                    <div class="advertimg"><img src="/static/images/advertimg/20190312\38e174f536d6635680481a3090a61344.jpg" /></div>
                    <div class="miaosa-time" id="test-times"></div>
                    <div class="secondscont-all" id="rolling-listdiv">
                        <ul class="secondscont-ul" id="rolling-list">

                        </ul>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/seconds_kill/index.js"></script>

    </body>
</html>
