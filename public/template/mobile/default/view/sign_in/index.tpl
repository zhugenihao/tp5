<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>签到中心</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/sign_in/index.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="singin-all allas">
                <div class="singin-top">
                    <div class="singintop-auto">
                        <div class="singintop-title">今天是{$today}，你有什么计划呢？</div>
                        <div class="singintop-guize">
                            <p class="singintop-gtitle floatleft">签到有金币领</p>
                            <p class="singintop-text floatright">签到规则</p>
                        </div>
                        <div class="singintopnum-t floatfalse">获得的积分：<span class="singintop-num">{$SignInGold}</span></div>
                        
                        <div class="singintop-btn">
                            <a href="javascript:;" class="singintop-btna" onclick="singinClick(this)">立即签到</a>
                        </div>
                        <div>最近连续签到{$continuousDay}天</div>
                    </div>
                </div>
                <div class="singinjl">
                    <div class="singinjl-title">签到记录</div>
                    <div class="singinjl-auto" id="singinjilu-div">
                        <div class="singinjl-title1">
                            <div class="width10">序号</div>
                            <div class="width30">签到时间</div>
                            <div class="width30">获得的积分</div>
                            <div class="width30">连续签到天数</div>
                        </div>
                        <ul class="singinjl-ul" id="singinjilu-list">
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="qiandaoguize htmlwidth">
                <div class="qiandaoguize-bag"></div>
                <div class="qiandaoguize-auto">
                    <div class="qiandaoguizea-2">
                        <div class="qiandaoguizea-3">
                            <div class="qiandaoguize-title">签到规则</div>
                            <div class="qiandaoguize-text">
                                连续签到1天，可获得10个金币；连续签到2天，可获得15个金币；连续签到3天，可获得20个金币；
                                连续签到4天，可获得25个金币；连续签到5天，可获得30个金币；连续签到6天，可获得35个金币；
                                连续签到7天，可获得40个金币。
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__MOBILE__/js/sign_in/index.js"></script>

    </body>
</html>
