
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>店铺信息</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <div class="details-title" id="detailstitle">
                <div class="detls-act">联系信息</div>
                <div>公司信息</div>
                <div>店铺信息</div>
                <div>资质信息</div>
            </div>
            <div class="detlstext-auto2">
                <div class="detlstextauto3">
                    <div class="detlstextone" style="display: block;">
                        {include file="public/seller/store/contact_information" /}
                    </div>
                    <div class="detlstextone">
                        {include file="public/seller/store/company_information" /}
                    </div>
                    <div class="detlstextone">
                        {include file="public/seller/store/store_information" /}
                    </div>
                    <div class="detlstextone">
                        {include file="public/seller/store/qualification_information" /}
                    </div>
                </div>
            </div>
            <div class="fromtext_auto">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/store/store_information.js"></script>
