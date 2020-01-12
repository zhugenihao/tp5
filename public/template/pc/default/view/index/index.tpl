<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>首页</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/index/index.css" />
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
                        {volist name="category" id="vo"}
                        <li class="categoty-li">
                            <a href="{:url($vo['methods'],['dir_id'=>$vo.dir_id])}" {if $vo['is_newwindow']==1}target="_blank"{/if}>
                                {$vo.cat_name}
                            </a>
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
                                <a href="{$vo['adv_link']}" target="_blank"><img src="__STATIC__/{$vo['dire']}" /></a>
                            </div>
                            {/volist}
                        </div>
                    </div> 
                </div>
                <div class="lunbo-div pcdiv-auto">
                    <div class="categ-list">
                        <ul class="categlist-ul">
                            {volist name="directory_list" id="vo"}
                            <li class="categlist-li"><a href="{:url('goods/goods_all',['dir_id'=>$vo.id])}" class="categlistli-a">{$vo.title}</a>
                                <ul class="categlister-ul">
                                    {volist name="vo['directory_2']" id="vo2"}
                                    <li class="categlister-li">
                                        <div class="categlister-div"><a href="{:url('goods/goods_all',['dir_id'=>$vo2.id])}" class="categlisterli-a">{$vo2.title}</a></div>
                                        <div class="categlister-div2">
                                            <ul class="categlistsan-ul {if $vo2['directory_3']}categlistsan-ulpd{/if}">
                                                {volist name="vo2['directory_3']" id="vo3"}
                                                <li class="categlistsan-li">
                                                    <a href="{:url('goods/goods_all',['dir_id'=>$vo3.id])}" class="categlistsanli-a">{$vo3.title}</a>
                                                </li>
                                                {/volist}
                                            </ul>
                                        </div>
                                    </li>
                                    {/volist}
                                </ul>
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top">
                    <div class="index-title floatleft">品牌推荐</div>
                </div>
                <div class="kejia-list">
                    <ul class="brand-ul">
                        {volist name="brandlist" id="vo"}
                        <li><a href="{:url('goods/goods_all',['brand_id'=>$vo['id']])}"><img src="__STATIC__/{$vo.brand_logo}"/></a></li>
                                {/volist}
                    </ul>
                </div>
            </div>
            <div class="miaosha-all pcdiv-auto">
                <div class="miaosha-top">
                    <div class="index-title">秒杀活动</div>
                    <div class="miaosha-title2">
                        <div class="miaosha-title3 floatleft" id="test-times"></div>
                        <div class="floatright"><a href="{:url('seconds_kill/index')}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>
                    </div>
                </div>
                <div class="miaosha-cont">
                    <ul class="miaosha-ul" id="miaosaul">

                    </ul>
                    <p class="zanwumiaosha"></p>
                </div>
            </div>
            <div class="advert-img pcdiv-auto">
                {if isset($common_advert[0])}
                    <a href="{$common_advert[0]['adv_link']}" ><img src="__STATIC__{$common_advert[0]['dire']}" /></a>
                    {/if}
            </div>
            <div class="pintuan-all pcdiv-auto">
                <div class="pintuan-top">
                    <div class="pintuan-title floatleft">拼团特区</div>
                    <div class="floatright"><a href="{:url('spell_group/index')}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>
                </div>
                <div class="pintuan-cont">
                    <ul class="pintuan-ul">
                        {volist name="spellGroupList" id="vo"}
                        <li class="pintuan-li">
                            <div class="pintuan-img">
                                <img src="__STATIC__{$vo['thecover']}" />
                            </div>
                            <div class="goods-name">{$vo['goods_name']}</div>
                            <div class="pintuanli-jiagers">
                                <div class="goods-jiage">￥{$vo['sg_price']}</div>
                                <div class="buy-num">{$vo['sg_members_num']}人成团</div>
                            </div>
                            <div class="pintuanli-a floatfalse">
                                <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'spell_group'])}">立即拼团</a>
                            </div>
                        </li>
                        {/volist}

                    </ul>
                </div>
            </div>
            <div class="advert-img pcdiv-auto floatfalse">
                {if isset($common_advert[1])}
                    <a href="{$common_advert[1]['adv_link']}" ><img src="__STATIC__{$common_advert[1]['dire']}" /></a>
                    {/if}
            </div>
            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top">
                    <div class="index-title floatleft">促销优惠</div>
                    <div class="floatright"><a href="{:url('comdysales_promotion/index')}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="comdysalespList" id="vo"}
                        <li class="kejia-li">
                            <div class="dazhe">
                                {eq name="vo['cp_type']" value="1"}{$vo['discount']}{/eq}
                                {eq name="vo['cp_type']" value="2"}优{/eq}
                            </div>
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id'],'activity'=>'comdysalesp'])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['cp_img']}" />
                                </div>
                                <div class="kejia-name">{$vo['cp_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥
                                        {eq name="vo['cp_type']" value="1"}{$vo['goods_price']}{/eq}
                                        {eq name="vo['cp_type']" value="2"}{$vo['cp_price']}{/eq}
                                    </div>
                                    <div class="floatright">{$vo['number_payment']}人付款</div>
                                </div>
                            </a>
                        </li>
                        {/volist}

                    </ul>
                </div>
            </div>
            <div class="advert-img pcdiv-auto">
                {if isset($common_advert[2])}
                    <a href="{$common_advert[2]['adv_link']}" ><img src="__STATIC__{$common_advert[2]['dire']}" /></a>
                    {/if}
            </div>
            <div class="kejia-all pcdiv-auto">
                <div class="kejia-top">
                    <div class="index-title floatleft">猜你喜欢</div>
                    <div class="floatright"><a href="{:url('guess_you_like/index')}"><span>更多</span><i class="Hui-iconfont">&#xe6d7;</i></a></div>
                </div>
                <div class="kejia-list">
                    <ul class="kejia-ul">
                        {volist name="salesGoodsList" id="vo"}
                        <li class="kejia-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="kejia-img">
                                    <img src="__STATIC__{$vo['thecover']}" />
                                </div>
                                <div class="kejia-name">{$vo['goods_name']}</div>
                                <div class="kejia-jiagerf">
                                    <div class="kejia-jiage floatleft">￥{$vo['goods_price']}</div>
                                    <div class="floatright">销量:{$vo['sales']}</div>
                                </div>
                            </a>
                        </li>
                        {/volist}

                    </ul>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>

        <script type="text/javascript" src="__PC__/js/index/index.js"></script>

        
    </body>
</html>
