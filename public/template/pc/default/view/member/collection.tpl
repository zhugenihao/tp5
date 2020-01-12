<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的收藏</title>
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
                        {include file="public/member_left" /}

                        <div class="member-right floatleft">
                            <div class="kejia-all">
                                <div class="kejia-top">
                                    <div class="member-title floatleft"><span>收藏的商品({$count_all})</span></div>
                                    <div class="floatright"><a href="javascript:;" onclick="deleteCollection(this)">立即清空</a></div>
                                </div>
                                <div class="kejia-list">
                                    <ul class="kejia-ul">
                                        {volist name="list" id="vo"}
                                        <li class="kejia-li">
                                            <a href="{:url('goods/goods_details',['goods_id'=>$vo.goods_id])}">
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
                                    {if empty($count_all)}
                                        <div class="wushuju_text">暂无数据</div>
                                    {/if}
                                    <div class="page-div">{$page}</div>
                                </div>
                            </div>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/member/collection.js"></script>
    </body>
</html>
