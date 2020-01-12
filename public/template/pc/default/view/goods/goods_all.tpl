<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>全部商品</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/goods/goods_all.css" />
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
                        <li class="categoty-li {if $type=='all'}categoty-active{/if}">
                            <a href="{:url('goods/goods_all',['type'=>'all'])}">全部</a>
                        </li>
                        <li class="categoty-li {if $type=='sales'}categoty-active{/if}">
                            <a href="{:url('goods/goods_all',['type'=>'sales'])}">销量</a>
                        </li>
                        <li class="categoty-li {if $type=='goodwill'}categoty-active{/if}">
                            <a href="{:url('goods/goods_all',['type'=>'goodwill'])}">好感</a>
                        </li>
                        <li class="categoty-li {if $type=='screening'}categoty-active{/if}">
                            <a href="{:url('goods/goods_all',['type'=>'screening'])}">筛选</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="kejia-all pcdiv-auto">
                <div class="goodsdetails-title">
                    <ul class="goodsdetails-tul">
                        <li>全部<span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span></li>
                            {if $directoryInfo3}
                            <li><a href="{:url('goods/goods_all',['dir_id'=> $directoryInfo3['id'],'typeclassif'=>'classification'])}">
                                    {$directoryInfo3['title']}</a>
                                <span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span>
                            </li>
                        {/if}
                        {if $directoryInfo2}
                            <li><a href="{:url('goods/goods_all',['dir_id'=> $directoryInfo2['id'],'typeclassif'=>'classification'])}">
                                    {$directoryInfo2['title']}</a>
                                <span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span>
                            </li>
                        {/if}
                        <li>{$directoryInfo1['title']}</li>
                    </ul>
                </div>
                {if $brandinfo}    
                    <div class="goodsdetails-title floatfalse">
                        <ul class="goodsdetails-tul">
                            <li>商品品牌<span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span></li>
                            <li>{$brandinfo['brand_name']}</li>
                        </ul>
                    </div>
                {/if}
                <div class="goods_type">
                    <div class="goodstype_1">
                        <div class="goodspce_title">商品价格：</div>
                        <ul class="goodspce_ul">
                            <li>
                                <a href="{:url('goods/goods_all',['screening'=>'high-low'])}" class="goodstype_btn {if $screening=='high-low'}goodstype_active{/if}">从高到低</a>
                            </li>
                            <li>
                                <a href="{:url('goods/goods_all',['screening'=>'low-high'])}" class="goodstype_btn {if $screening=='low-high'}goodstype_active{/if}">从低到高</a>
                            </li>
                            <li class="goodstype_lt">
                                <form action="" method="get">
                                    <input type='text' value="{$price_low}" placeholder="￥" class="goodstype_text" name="price_low"/>-
                                    <input type='text' value="{$price_high}" placeholder="￥" class="goodstype_text" name="price_high"/>
                                    <input type='submit' value="确定" class="goodstype_btn goodstype_qd"/>
                                </form>
                            </li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'200-500'])}" class="goodstype_btn {if $pricesegment=='200-500'}goodstype_active{/if}">200-500</a></li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'500-1000'])}" class="goodstype_btn {if $pricesegment=='500-1000'}goodstype_active{/if}">500-1000</a></li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'1000-2000'])}" class="goodstype_btn {if $pricesegment=='1000-2000'}goodstype_active{/if}">1000-2000</a></li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'2000-3000'])}" class="goodstype_btn {if $pricesegment=='2000-3000'}goodstype_active{/if}">2000-3000</a></li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'3000-5000'])}" class="goodstype_btn {if $pricesegment=='3000-5000'}goodstype_active{/if}">3000-5000</a></li>
                            <li><a href="{:url('goods/goods_all',['pricesegment'=>'5000-6000'])}" class="goodstype_btn {if $pricesegment=='5000-6000'}goodstype_active{/if}">5000-6000</a></li>
                        </ul>
                    </div>

                </div>
                <div class="kejia-top floatfalse">
                    <div class="index-title floatleft">商品列表</div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="goodsList" id="vo"}
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
                    <a href=""><img src="/static/images/advertimg/20190412\832cd0ee0d954bee4b7d3f4f7e0c1626.png"/></a>
                </div>
            </div>

            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/goods/goods_all.js"></script>
    </body>
</html>
