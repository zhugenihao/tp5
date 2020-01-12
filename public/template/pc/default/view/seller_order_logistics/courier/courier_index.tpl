
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>选择快递公司</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts div_tishi">
                        <ul class="divtishi-ul">
                            <li>友情提示：</li>
                            <li>1.勾选你要使用的快递公司。</li>
                        </ul>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            快递公司如下：
                        </label>
                        <div class="form_text">
                            <ul class="checkboxs-ul">
                                <li>
                                    <input type="checkbox" name="all" id="checkedAll"/>
                                    <label for="checkedAll">全部</label>
                                </li>
                                {volist name="courierList" id="vo"}
                                <li>
                                    <input type="checkbox" value="{$vo['id']}" name="id[]" id="checked_{$vo['id']}}" 
                                           {eq name="vo['is_show']" value="1"}checked {/eq}/>
                                    <label for="checked_{$vo['id']}}"> {$vo['cou_name']}</label>
                                </li>
                                {/volist}
                            </ul>

                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="updateSellerCourier(this)">编辑</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/courier/courier_index.js"></script>
