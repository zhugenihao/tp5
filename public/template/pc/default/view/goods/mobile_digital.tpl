<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{$directoryTitle}</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/goods/mobile_digital.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="index-categoty">
                <div class="categoty-auto pcdiv-auto">
                    <ul class="categoty-ul">
                        <li class="categoty-li">
                            <a href="{:url('index/index')}">首页</a>
                        </li>
                        {volist name="directoryList" id="vo"}
                        <li class="categoty-li">
                            <a href="{:url($vo['home_template_p'],['dir_id'=>$vo['id'],'typeclassif'=>'classification'])}">{$vo.title}</a>
                        </li>
                        {/volist}
                    </ul>
                </div>
            </div>
            <div class="lunbo-dadiv">
                <div class="lunbo-imglist">
                    <div class="layui-carousel" id="test3" lay-filter="test4">
                        <div carousel-item="">
                            {volist name="advertList" id="vo"}
                            <div>
                                <a href="{$vo['adv_link']}"><img src="__STATIC__/{$vo['dire']}" /></a>
                            </div>
                            {/volist}
                        </div>
                    </div> 
                </div>

            </div>


            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top">
                    <div class="index-title floatleft">为你推荐</div>
                    <div class="floatright"><a href="{:url('goods/goods_all',['dir_id'=> input('dir_id'),'typeclassif'=>'classification'])}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="mobileGoodsList" id="vo"}
                        <li class="kejia-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['thecover']}" />
                                </div>
                                <div class="kejia-name">{$vo['goods_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥{$vo['goods_price']}</div>
                                    <div class="floatright">{$vo['number_payment']}人付款</div>
                                </div>
                            </a>
                        </li>
                        {/volist}
                    </ul>
                    <div class="page-div">{$page}</div>
                </div>
                <div class="advert-img pcdiv-auto">
                    <a href="{$mobile_digital_advert20['adv_link']}"><img src="__STATIC__/{$mobile_digital_advert20['dire']}"/></a>
                </div>
            </div>

            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/goods/mobile_digital.js"></script>
    </body>
</html>
