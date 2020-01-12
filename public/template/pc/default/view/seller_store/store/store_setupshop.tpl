
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>店铺设置</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">

            <div class="fromtext_auto">
                <div class="goods-cate2" id="goods-details">
                    <div class="details-title" id="detailstitle">
                        <div class="detls-act">店铺设置</div>
                        <div>电脑幻灯片设置</div>
                        <div>手机幻灯片设置</div>
                        <div>店铺主题</div>
                    </div>
                    <div class="detlstext-auto2">
                        <div class="detlstextauto3">
                            <div class="detlstextone" style="display: block;">
                                {include file="public/seller/store/setupshop" /}
                            </div>
                            <div class="detlstextone">
                                {include file="public/seller/store/slide_pc" /}
                            </div>
                            <div class="detlstextone">
                                {include file="public/seller/store/slide_mobile" /}
                            </div>
                            <div class="detlstextone">
                                {include file="public/seller/store/store_template" /}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <input type="hidden" value="" name="id" />

        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/store/store_setupshop.js"></script>
