
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>编辑地址</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            联系人：
                        </label>
                        <div class="form_text">
                            <input type="text" name="contact_name" value="{$info['contact_name']}" class="mall_input" id="contact_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            手机：
                        </label>
                        <div class="form_text">
                            <input type="text" name="mobile" value="{$info['mobile']}" class="mall_input" id="mobile" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            邮政编码：
                        </label>
                        <div class="form_text">
                            <input type="text" name="zip_code" value="{$info['zip_code']}" class="mall_input" id="zip_code" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            地区：
                        </label>
                        <div class="form_text">
                            <select name="province_id" id="province_id">
                                <option value="0" >省级</option>
                            </select>
                            <input type="hidden" value="{$info['province_id']}" id="province_show" />
                            <select name="city_id" id="city_id">
                                <option value="0" >市级</option>
                            </select>
                            <input type="hidden" value="{$info['city_id']}" id="city_show" />
                            <select name="county_id" id="county_id">
                                <option value="0" >区级</option>
                            </select>
                            <input type="hidden" value="{$info['county_id']}" id="county_show" />
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            详细地址：
                        </label>
                        <div class="form_text" style="width:900px;">
                            <textarea cols="50" rows="5" name="detailed_address" id="detailed_address">{$info['detailed_address']}</textarea>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            地址类型：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="address_type" id="radio1" value="1" {eq name="info['address_type']" value="1"}checked{/eq}/>
                            <label for="radio1">发货地址</label>
                            <input type="radio" name="address_type" id="radio2" value="2" {eq name="info['address_type']" value="2"}checked{/eq}/>
                            <label for="radio2">收货地址</label>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            是否默认：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_default" id="radio11" value="1" {eq name="info['is_default']" value="1"}checked{/eq}/>
                            <label for="radio11">是</label>
                            <input type="radio" name="is_default" id="radio22" value="2" {eq name="info['is_default']" value="2"}checked{/eq}/>
                            <label for="radio22">否</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="detailsSellerAddress(this)">编辑</botton>
                    </div>
                </div>
                <input type="hidden" value="{$info['id']}" name="id" />
            </form>
        </div>
    </div>
</div>

{include file="public/plugin/regional_linkage" /}
<script type="text/javascript" src="__PC__/js/seller_store/seller_address/seller_address_details.js"></script>
