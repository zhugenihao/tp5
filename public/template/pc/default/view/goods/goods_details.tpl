<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商品详情</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/goods/goods_details.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            {include file="public/directory_top" /}
            <div class="goodsdetails-all pcdiv-auto">
                <div class="goodsdetails-title">
                    <ul class="goodsdetails-tul">
                        <li>全部<span class="goodstul-span"><i class="Hui-iconfont">&#xe6d7;</i></span></li>
                        <li>商品详情</li>
                    </ul>
                </div>
                <div class="goods-text">
                    <div class="goods-imgas floatleft">
                        <div class="magnifier" id="magnifier1">
                            <div class="magnifier-container">
                                <div class="images-cover"></div>
                                <!--当前图片显示容器-->
                                <div class="move-view"></div>
                                <!--跟随鼠标移动的盒子-->
                            </div>
                            <div class="magnifier-assembly">
                                <div class="magnifier-btn">
                                    <span class="magnifier-btn-left">&lt;</span>
                                    <span class="magnifier-btn-right">&gt;</span>
                                </div>
                                <!--按钮组-->
                                <div class="magnifier-line">
                                    <ul class="clearfix animation03" id="gallery_list">
                                        {volist name="goodsInfo['gallery_list']" id="vo"}
                                        <li>
                                            <div class="small-img">
                                                <img src="__STATIC__{$vo['img_small']}" bigimg="__STATIC__{$vo['img_big']}"/>
                                            </div>
                                        </li>
                                        {/volist}
                                    </ul>
                                </div>
                                <!--缩略图-->
                            </div>
                            <div class="magnifier-view"></div>
                            <!--经过放大的图片显示容器-->
                        </div>
                    </div>
                    <div class="goods-bens floatleft">
                        <p id="cantuanp">你正在参团，请选择商品</p>
                        <ul class="goodsbens-ul">
                            <li class="goods_name">{$goodsInfo['goods_name']}</li>
                            <li class="goods_gkp">
                                <div class="goods_gkp_1 floatleft">
                                    <div class="goods_gkp_k">
                                        {if input('activity')=='seconds_kill'}
                                            秒杀数量：<span id="goods_stock">{$secondsKillInfo['sk_num']}</span>件
                                        {elseif input('activity')=='spell_group' /} 
                                            拼团数量：<span id="goods_stock">{$spellGroupInfo['sg_num']}</span>件
                                        {elseif input('activity')=='comdysalesp' /}
                                            {if $comdysalespInfo['cp_type']==1}
                                                打折商品：<span id="goods_stock">{$comdysalespInfo['cp_num']}</span>
                                            {elseif $comdysalespInfo['cp_type']==2}
                                                降价商品：<span id="goods_stock">{$comdysalespInfo['cp_num']}</span>
                                            {else/}
                                                其他
                                            {/if}
                                        {else /}
                                            库存：<span id="goods_stock">{$goodsInfo['goods_stock']}</span>件
                                        {/if}
                                    </div>
                                    <div class="goods_gkp_p">
                                        {if input('activity')=='seconds_kill'}
                                            秒杀商品 ￥<span id="spanprice">{$secondsKillInfo['sk_price']}</span>
                                        {elseif input('activity')=='spell_group' /} 
                                            拼团商品 ￥<span id="spanprice">{$spellGroupInfo['sg_price']}</span>
                                        {elseif input('activity')=='comdysalesp' /} 
                                            {if $comdysalespInfo['cp_type']==1}
                                                打折商品({$comdysalespInfo['discount']}折) ￥<span id="spanprice">{$goodsInfo['goods_price']*($comdysalespInfo['discount']/10)}</span>
                                                <p class="color-hui">原价：<span id="orgprice">{$goodsInfo['goods_price']}</span></p>
                                                {elseif $comdysalespInfo['cp_type']==2}
                                                降价商品 ￥<span id="spanprice">{$comdysalespInfo['cp_price']}</span>
                                                <p class="color-hui">原价：<span id="orgprice">{$goodsInfo['goods_price']}</span></p>
                                                {else/}
                                                其他
                                            {/if}
                                        {else /}
                                            ￥<span id="spanprice">{$goodsInfo['goods_price']}</span>
                                        {/if}
                                    </div>
                                </div>
                                <div class="goods_gkp_2 floatright" id="givealikeBtn" data-goodsid="{$goodsInfo['goods_id']}">
                                    <div class="goods_gkp_xh">
                                        {if $goodsInfo['is_givealike'] > 0}
                                            <i class="Hui-iconfont">&#xe648;</i>
                                        {else/}
                                            <i class="Hui-iconfont">&#xe649;</i>
                                        {/if}
                                    </div>
                                    <div class="goods_gkp_xht">喜欢</div>

                                </div>
                                <p class="goods_gkp_num floatright">{$givealike_count}</p>
                            </li>
                            {if $goodsInfo['setup_norm']=='on'}
                                <li class="goods_gkp1">
                                    <p class="cart-guigeyx floatfalse">已选：
                                        <span class="yansetext">
                                            {if isset($goodsInfo['goods_color_list'][0])}
                                                {$goodsInfo['goods_color_list'][0]['color_name']}
                                            {/if}
                                        </span>，
                                        <span class="banbentext">
                                            {if isset($goodsInfo['cates_list'][0])}
                                                {$goodsInfo['cates_list'][0]['cate_name']}
                                            {/if}
                                        </span>，
                                        <span class="goodsnum">1</span>个
                                    </p>
                                </li>
                                <li class="floatfalse goods_sb">
                                    <div class="goods_color">颜色类型</div>
                                    <div class="goodscolor_list" id="goodscolor_click">
                                        {volist name="goodsInfo['goods_color_list']" id="vo" key="index"}
                                        <div>
                                            <a href="javascript:;" class="{if $index==1}gcolor_active{/if}" data-id="{$vo['id']}">
                                                {$vo['color_name']}
                                            </a>
                                        </div>
                                        {/volist}
                                    </div>
                                </li>
                                <li class="floatfalse goods_sb">
                                    <div class="goods_color">版本类型</div>
                                    <div class="goodscolor_list" id="cartbanben">
                                    </div>
                                </li>
                            {/if}
                            <li class="floatleft">
                                <div class="goodsnum-text floatleft">
                                    <input type="button" value="-" class="goods_num_jian"/>
                                    <input type="text" value="1" class="goods_num" oninput="get_goods_num(this)"/>
                                    <input type="button" value="+" class="goods_num_jia"/>
                                </div>
                                <div class="floatright goods_shouc">
                                    <a href="javascript:;" onclick="addCollection(this)">
                                        {if $goodsInfo['is_collection']}
                                            <i class="Hui-iconfont color-red">&#xe69d;</i>
                                        {else/}
                                            <i class="Hui-iconfont">&#xe69e;</i>
                                        {/if}
                                        <span>收藏</span>
                                    </a>
                                </div>
                            </li>
                            <li class="floatleft goods_btns">
                                <?php 
                                $cateId = '';
                                if(isset($goodsInfo['cates_list'][0])){
                                $cateId = $goodsInfo['cates_list'][0]['cate_id'];
                                }
                                ?>
                                <form action="{:url('order/submit_orders')}" method="post" name="formsubmit" id="formsubmit">
                                    <input type="hidden" value="{$goodsInfo['goods_id']}" id="goods_id" name="goods_id" />
                                    <input type="hidden" value="{$goodsInfo['default_norm_info']['n_id']}" id="n_id" name="n_id" />
                                    <input type="hidden" value="{$cateId}" id="cate_id" name="cate_id" />
                                    <input type="hidden" value="buy" id="submit_type" name="submit_type" />
                                    <input type="hidden" value="1" id="goods_num" name="goods_num" />
                                    <input type="hidden" value="{:input('activity')}" name="activity" id="activity"/>
                                    <input type="hidden" value="{$goodsInfo['setup_norm']}" name="setup_norm" id="setup_norm"/>
                                    <input type="hidden" value="{$goodsInfo['store_id']}" name="store_id" id="store_id"/>
                                    <input type="hidden" value="0" name="first_member_id" id="first_member_id"/>
                                    <input type="hidden" value="0" name="sgm_id" id="sgm_id"/>
                                </form>
                                <!--商品秒杀-->
                                {if input('activity')=='seconds_kill'}
                                    <div class="add_cart add_buy"><a href="javascript:;" data-type="cart" data-buytype="seconds_kill">加入购物车</a></div>
                                    <div class="goods_buy add_buy"><a href="javascript:;" data-type="buy" data-buytype="seconds_kill">立即抢购</a></div>

                                    <!--商品拼团-->
                                {elseif input('activity')=='spell_group'}
                                    <div class="add_cart add_buy"><a href="javascript:;" data-type="buy" data-buytype="a_separate_buy">单独购买</a></div>
                                    <div class="goods_buy add_buy"><a href="javascript:;" data-type="buy" data-buytype="spell_group">立即拼团</a></div>

                                    <!--促销商品-->
                                {elseif input('activity')=='comdysalesp'}
                                    <div class="add_cart add_buy"><a href="javascript:;" data-type="cart" data-buytype="comdysalesp">加入购物车</a></div>
                                    <div class="goods_buy add_buy"><a href="javascript:;" data-type="buy" data-buytype="comdysalesp">立即抢购</a></div>

                                    <!--普通购买-->
                                {else /}
                                    <div class="add_cart add_buy"><a href="javascript:;" data-type="cart" data-buytype="a_separate_buy">加入购物车</a></div>
                                    <div class="goods_buy add_buy"><a href="javascript:;" data-type="buy" data-buytype="a_separate_buy">立即购买</a></div>
                                {/if}

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="goods_text_all floatfalse">
                    <div class="goodstext_all_1 floatleft">
                        <div class="goodstext_dianpu">
                            <div class="goodstext_dianpu_1">
                                {if $goodsInfo['store_id']>0}
                                    <a href="{:url('store/index',['store_id'=>$goodsInfo['store_id']])}">
                                        <div class="gdianpu_img"><img src="__STATIC__/{$store['image']}" /></div>
                                        <div class="gdianpu_name">{$store['store_name']}</div>
                                    </a>
                                {else/}
                                    <div class="gdianpu_name">平台自营</div>
                                {/if}
                            </div>
                            {if $goodsInfo['store_id']>0}
                                <div class="store_jinru">
                                    <div class="floatright"><a href="{:url('store/index',['store_id'=>$goodsInfo['store_id']])}">进入店铺</a></div>
                                </div>
                            {/if}
                            <div class="goodstext_kefu floatfalse" onclick="kefuUrl(this)" url="{:url('socket/index/index',['kefu_id'=>$kefu['id'],'goods_id'=>$goodsInfo['goods_id']])}">
                                <div class="gkefu_icon">
                                    <a href="javascript:;"><i class="Hui-iconfont">&#xe6d0;</i></a>
                                </div>
                                <div>客服</div>

                            </div>
                        </div>
                        <div class="goods_hot">
                            <div class="goodshot_title">商品热销</div>
                            <ul class="goodshot_ul">
                                <li class="goodshot_li">
                                    <a href="">
                                        <div class="goodshot_img floatleft"><img src="/static/images/goods/cover/20190331\a7df2164b10a8c6f1e507aa6f197af18.jpg" /></div>
                                        <div class="goodshot_cont floatleft">
                                            <div>商品标题商品标题</div>
                                            <div class="goodshot_price">￥190.00</div>
                                            <div class="goodshot_snum">已售出<span>23332</span>件</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="goodshot_li">
                                    <a href="">
                                        <div class="goodshot_img floatleft"><img src="/static/images/goods/cover/20190331\a7df2164b10a8c6f1e507aa6f197af18.jpg" /></div>
                                        <div class="goodshot_cont floatleft">
                                            <div>商品标题商品标题</div>
                                            <div class="goodshot_price">￥190.00</div>
                                            <div class="goodshot_snum">已售出<span>23332</span>件</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="goodshot_li">
                                    <a href="">
                                        <div class="goodshot_img floatleft"><img src="/static/images/goods/cover/20190331\a7df2164b10a8c6f1e507aa6f197af18.jpg" /></div>
                                        <div class="goodshot_cont floatleft">
                                            <div>商品标题商品标题</div>
                                            <div class="goodshot_price">￥190.00</div>
                                            <div class="goodshot_snum">已售出<span>23332</span>件</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="goodshot_li">
                                    <a href="">
                                        <div class="goodshot_img floatleft"><img src="/static/images/goods/cover/20190331\a7df2164b10a8c6f1e507aa6f197af18.jpg" /></div>
                                        <div class="goodshot_cont floatleft">
                                            <div>商品标题商品标题</div>
                                            <div class="goodshot_price">￥190.00</div>
                                            <div class="goodshot_snum">已售出<span>23332</span>件</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="goodstext_all_2 floatleft">
                        <div class="goodsdetails_title">
                            <div class="gdtitle_active">商品详情</div>
                            <div>商品规格</div>
                            {if input('activity')=='spell_group' /}<div id="splgomcount" splgomcount="">拼团信息</div>{/if}
                            {if input('activity')=='' /}<div>领取优惠券</div>{/if}
                            <div data-comscount="{$comments_count}" id="comscount">评价({$comments_count})</div>
                        </div>
                        <div class="goodsdetails_text">
                            <div class="goodstext_list gd_texts show">
                                {$goodsInfo['goods_desc']|htmlspecialchars_decode}
                            </div>
                            <div class="goodstext_list">{$goodsInfo['goods_desc2']|htmlspecialchars_decode}</div>

                            {if input('activity')=='spell_group' /}
                                <div class="goodstext_list">
                                    <ul class="goodspl_ul" id="spellgroup-list">

                                    </ul>
                                    <div id="spellgroup-page"></div>
                                </div>
                            {/if}
                            {if input('activity')=='' /}
                                <div class="goodstext_list">
                                    <ul class="goodsyhq-ul">
                                        {volist name="goodsInfo['coupon_list']" id="vo"}
                                        <li class="goodsyhq-li">
                                            <div class="goodsyhqli-auto">
                                                <div class="goodsyhqdiv floatleft">
                                                    <p class="goodsyhq-num">￥{$vo['cop_price']}</p>
                                                    <p class="goodsyhq-jiage">满{$vo['full_amount']}可使用此优惠券(还有{$vo['cop_num']}张)</p>
                                                </div>
                                                <div class="goodsyhq-lq floatright" data-copid="{$vo['cop_id']}">
                                                    <p class="goodsyhq-lqp" data-copid="{$vo['cop_id']}">领取</p>
                                                </div>
                                            </div>
                                        </li>
                                        {/volist}
                                    </ul>
                                </div>
                            {/if}
                            <div class="goodstext_list goods_pl">
                                <ul class="goodspl_ul" id="comments-list">

                                </ul>
                                <div id="comments-page"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="goods-cai floatleft">
                    <div class="goodscai-title">猜你喜欢</div>
                    <ul class="goodscai-ul">
                        {volist name="goodsInfo['sales_goods_list']['list']" id="vo"}
                        <li class="goodscai-li">
                            <a href="{:url('goods/goods_details',['goods_id'=>$vo['goods_id']])}">
                                <div class="goodscai-img"><img src="__STATIC__{$vo['thecover']}" /></div>
                                <div class="goods_name">{$vo['goods_name']}</div>
                                <div class="goodshot_price">￥{$vo['goods_price']}</div> 
                            </a>
                        </li>
                        {/volist}
                    </ul>
                </div>
            </div>

            {include file="public/bottom" /}
            <!--某个拼团的团员-->      
            <div class="cantuanlist2 htmlwidth" id="pinyuan2">
                <div class="pinyuan-auto2" id="pinyuan-auto2"></div>
                <div class="pinyuan-div">
                    <div class="pinyuan-auto">
                        <div class="pinyuan-ludiv2">
                            <div class="pinyuan-ludiv">

                                <div class="pinyuan-title">可参与拼团，还差<span id="poormember">0</span>个成员</div>
                                <ul class="pinyuan-lu" id="pinyuan-luid">

                                </ul>
                                <div class="spell-buys">立即参加</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--某个拼团的团员-->
        </div>

        <link rel="stylesheet" type="text/css" href="__PC__/css/public/magnifier.css">
        <script type="text/javascript" src="__PC__/js/public/magnifier.js"></script>

        <script type="text/javascript" src="__PC__/js/goods/goods_details.js"></script>
        <script type="text/javascript" src="__PC__/js/goods/spell_list.js"></script>

    </body>
</html>
