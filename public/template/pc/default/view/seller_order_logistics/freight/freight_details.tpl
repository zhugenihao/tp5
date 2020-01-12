
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>编辑运费模板</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            运费模板名称：
                        </label>
                        <div class="form_text">
                            <input type="text" name="freight_name" value="{$info['freight_name']}" class="mall_input" id="freight_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            计费方式：
                        </label>
                        <div class="form_text">
                            <select name="billing_way" id="billing_way" onchange="billingWay(this)">
                                <option value="1" {eq name="info['billing_way']" value="1"}selected{/eq}>件数</option>
                                <option value="2" {eq name="info['billing_way']" value="2"}selected{/eq}>重量</option>
                                <option value="3" {eq name="info['billing_way']" value="3"}selected{/eq}>体积</option>
                            </select>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            配送区域：
                        </label>
                        <div class="form_text">
                            <div class="floatleft">
                                <select name="province_id" id="province_id">
                                    <option value="0" >省级</option>
                                    {volist name="provinceList" id="vo"}
                                    <option value="{$vo['id']}" >{$vo['name']}</option>
                                    {/volist}
                                </select>
                                <select name="city_id" id="city_id">
                                    <option value="0" >市级</option>
                                </select>
                                <select name="county_id" id="county_id">
                                    <option value="0" >区级</option>
                                </select>&nbsp;&nbsp;
                            </div>
                            <botton class="mall_btn goodsbtn_act floatleft" onclick="dtionArea(this)">确定</botton>
                            <div class="floatfalse">
                                <div class="border-divs">
                                    <ul class="borderdivs-ul" id="dtionarealu">
                                        {volist name="info['dtionAreaList']" id="vo"}
                                        <li>
                                            <span>{$vo['county_text']}</span>
                                            <span class="bspanicon" onclick="delDtionArea(this)"><i class="Hui-iconfont">&#xe609;</i></span>
                                            <input type="hidden" name="county_id[]" value="{$vo['county_id']}" class="county_id">
                                            <input type="hidden" name="county_text[]" value="{$vo['county_text']}" class="county_text">
                                        </li>
                                        {/volist}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            <span class="number_title">首件（件数）：</span>
                            <span class="heavy_title">首重（kg）：</span>
                            <span class="volume_title">首体积（立方米）：</span>
                        </label>
                        <div class="form_text">
                            <input type="text" name="first_number" value="{$info['first_number']}" class="mall_input number_title" id="first_number" size="40">
                            <input type="text" name="first_heavy" value="{$info['first_heavy']}" class="mall_input heavy_title" id="first_heavy" size="40">
                            <input type="text" name="first_volume" value="{$info['first_volume']}" class="mall_input volume_title" id="first_volume" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            首运费（￥）：
                        </label>
                        <div class="form_text">
                            <input type="text" name="first_fee" value="{$info['first_fee']}" class="mall_input" id="first_fee" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            <span class="number_title">续件（件数）：</span>
                            <span class="heavy_title">续重（kg）：</span>
                            <span class="volume_title">续体积（立方米）：</span>
                        </label>
                        <div class="form_text">
                            <input type="text" name="tocontinue_number" value="{$info['tocontinue_number']}" class="mall_input number_title" id="tocontinue_number" size="40">
                            <input type="text" name="tocontinue_heavy" value="{$info['tocontinue_heavy']}" class="mall_input heavy_title" id="tocontinue_heavy" size="40">
                            <input type="text" name="tocontinue_volume" value="{$info['tocontinue_volume']}" class="mall_input volume_title" id="tocontinue_volume" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            续运费（￥）：
                        </label>
                        <div class="form_text">
                            <input type="text" name="tocontinue_fee" value="{$info['tocontinue_fee']}" class="mall_input" id="tocontinue_fee" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            默认：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_default" id="is_default1" value="on" title="是" {eq name="info['is_default']" value="on"}checked{/eq}>
                            <label for="is_default1">是</label>
                            <input type="radio" name="is_default" id="is_default2" value="off" title="否" {eq name="info['is_default']" value="off"}checked{/eq}>
                            <label for="is_default2">否</label>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            使用：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_use" id="is_use1" value="1" title="是" {eq name="info['is_use']" value="1"}checked{/eq}>
                            <label for="is_use1">是</label>
                            <input type="radio" name="is_use" id="is_use2" value="2" title="否" {eq name="info['is_use']" value="2"}checked{/eq}>
                            <label for="is_use2">否</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="detailsFreight(this)">添加</botton>
                    </div>
                </div>
                <input type="hidden" value="{$info['id']}" name="freight_id" />
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/freight/freight_details.js"></script>
