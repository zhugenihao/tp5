
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>编辑商品促销</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            促销名称：
                        </label>
                        <div class="form_text">
                            <input type="text" value="{$info['cp_name']}" name="cp_name" placeholder="请输入促销名称" class="mall_input" id="cp_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            活动类型：
                        </label>
                        <div class="form_text">
                            <select name="cp_type" id="cp_type" onchange="cpType(this)">
                                <option value="1" {eq name="info['cp_type']" value="1"}selected{/eq}>直接打折</option>
                                <option value="2" {eq name="info['cp_type']" value="2"}selected{/eq}>减价优惠</option>
                            </select>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title" id="cptypes_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            <span id="discount_title" style="display: {if $info['cp_type']==1}initial{else/}none{/if}">折扣(如：7.5)：</span>
                            <span id="cpprice_title" style="display: {if $info['cp_type']==2}initial{else/}none{/if}">促销价格(￥)：</span>
                        </label>
                        <div class="form_text" id="cptypes_text">
                            <input type="text" name="discount" style="display: {if $info['cp_type']==1}initial{else/}none{/if}" value="{$info['discount']}" class="mall_input" id="discount" size="40">
                            <input type="text" name="cp_price" style="display: {if $info['cp_type']==2}initial{else/}none{/if}" value="{$info['cp_price']}" class="mall_input" id="cp_price" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            限购数量：
                        </label>
                        <div class="form_text">
                            <input type="text" name="cp_num" value="{$info['cp_num']}" class="mall_input" id="cp_num" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            选择商品促销商品：<br/>
                            (输入商品名称或商品ID)
                        </label>
                        <div class="form_text posformtext">
                            <input type="text" value="￥{$goodsInfo['goods_price']},{$goodsInfo['goods_name']}" class="mall_input" id="goods_id" oninput="goodsList(this)" size="60">
                            <ul class="goodslistul goodsulclick"> 
                                <li data-goodsid="1" onclick="goodsulli(this)"></li>
                            </ul>
                            <input type="hidden" name="goods_id" value="{$info['goods_id']}" class="goods_id">
                        </div>

                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            促销图片：
                        </label>
                        <div class="form_text">
                            <label class="fileimg-btn" for="images">选择文件</label>
                            <input class="" onchange="getPhoto(this, 'cp_img', 150)" id="images" style="display: none;" name="cp_img" type="file">

                            <img src="__STATIC__/{$info['cp_img']}" class="fileimg_cp_img" />
                            <input type="hidden" value="{$info['cp_img']}" name="cp_img" />
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            开始时间：
                        </label>
                        <div class="form_text" id="start_timediv">
                            <input type="text" value="{$info['start_time']}" name="start_time" class="mall_input" id="start_time1" placeholder="HH:mm:ss" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            结束时间：
                        </label>
                        <div class="form_text" id="end_timediv">
                            <input type="text" value="{$info['end_time']}" name="end_time" class="mall_input" id="end_time1" placeholder="HH:mm:ss" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            排序值：
                        </label>
                        <div class="form_text">
                            <input type="text" value="{$info['sort']}" name="sort" class="mall_input" id="sort" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            促销描述：
                        </label>
                        <div class="form_text">
                            <textarea cols="50" rows="5" name="description" id="description">{$info['description']}</textarea>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            状态：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" {eq name="info['is_show']" value="1" }checked{/eq}>
                            <label for="is_show1">上架</label>
                            <input type="radio" name="is_show" id="is_show2" value="2" title="下架" {eq name="info['is_show']" value="2" }checked{/eq}>
                            <label for="is_show2">下架</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="detailsComdsption(this)">编辑</botton>
                    </div>
                </div>
                <input type="hidden" value="{$info['id']}" name="id" />
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_sales_promotion/comdysales_promotion/comdsption_details.js"></script>
