
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>添加运费模板</span></div>

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
                            <input type="text" name="freight_name" value="运费模板名称" class="mall_input" id="freight_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            计费方式：
                        </label>
                        <div class="form_text">
                            <select name="billing_way" id="billing_way" onchange="billingWay(this)">
                                <option value="1" >件数</option>
                                <option value="2" >重量</option>
                                <option value="3" >体积</option>
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
                            <input type="text" name="first_number" value="1" class="mall_input number_title" id="first_number" size="40">
                            <input type="text" name="first_heavy" value="1.00" class="mall_input heavy_title" id="first_heavy" size="40">
                            <input type="text" name="first_volume" value="1.00" class="mall_input volume_title" id="first_volume" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            首运费（￥）：
                        </label>
                        <div class="form_text">
                            <input type="text" name="first_fee" value="1.00" class="mall_input" id="first_fee" size="40">
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
                            <input type="text" name="tocontinue_number" value="1" class="mall_input number_title" id="tocontinue_number" size="40">
                            <input type="text" name="tocontinue_heavy" value="1.00" class="mall_input heavy_title" id="tocontinue_heavy" size="40">
                            <input type="text" name="tocontinue_volume" value="1.00" class="mall_input volume_title" id="tocontinue_volume" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            续运费（￥）：
                        </label>
                        <div class="form_text">
                            <input type="text" name="tocontinue_fee" value="1.00" class="mall_input" id="tocontinue_fee" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            默认：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_default" id="is_default1" value="on" title="是" checked="">
                            <label for="is_default1">是</label>
                            <input type="radio" name="is_default" id="is_default2" value="off" title="否">
                            <label for="is_default2">否</label>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            使用：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_use" id="is_use1" value="1" title="是" checked="">
                            <label for="is_use1">是</label>
                            <input type="radio" name="is_use" id="is_use2" value="2" title="否">
                            <label for="is_use2">否</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="addFreight(this)">添加</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/freight/freight_add.js"></script>
