
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>添加优惠券</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            优惠券类型：
                        </label>
                        <div class="form_text">
                            <select name="type" id="cop_type" onchange="copType(this)">
                                <option value="1" >商品</option>
                                <option value="2" >店铺</option>
                            </select>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title" id="cptypes_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            <span id="copgoods_title">
                                选择拼团商品：<br/>
                                (输入商品名称或商品ID)
                            </span>
                            <span id="copstore_title">
                                选择店铺：<br/>
                            </span>
                        </label>
                        <div class="form_text posformtext">
                            <input type="text" value="" class="mall_input" id="type_text" size="40" oninput="goodsList(this)">
                            <ul class="goodslistul goodsulclick"> 
                                <li data-goodsid="1" onclick="goodsulli(this)"></li>
                            </ul>
                            <input type="hidden" name="goods_id" value="0" class="goods_id">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            优惠券名称：
                        </label>
                        <div class="form_text">
                            <input type="text" value="优惠券名称" name="cop_name" placeholder="请输入优惠券名称" class="mall_input" id="cop_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            金额(￥)：
                        </label>
                        <div class="form_text">
                            <input type="text" name="cop_price" value="10.00" class="mall_input" id="cop_price" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            优惠券数量：（张）
                        </label>
                        <div class="form_text">
                            <input type="text" name="cop_num" value="10" class="mall_input" id="cop_num" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            满足金额（￥）：
                        </label>
                        <div class="form_text">
                            <input type="text" name="full_amount" value="100" class="mall_input" id="full_amount" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            优惠券封面：
                        </label>
                        <div class="form_text">
                            <label class="fileimg-btn" for="images">选择文件</label>
                            <input class="" onchange="getPhoto(this, 'cop_img', 150)" id="images" style="display: none;" name="cop_img" type="file">

                            <img src="" class="fileimg_cop_img" />
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            开始时间：
                        </label>
                        <div class="form_text" id="start_timediv">
                            <input type="text" value="{$start_time}" name="copa_time" class="mall_input" id="start_time1" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            结束时间：
                        </label>
                        <div class="form_text" id="end_timediv">
                            <input type="text" value="" name="copb_time" class="mall_input" id="end_time1" placeholder="YY-mm-dd HH:ii:ss" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            状态：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="cop_show" id="is_show1" value="1" title="上架" checked="">
                            <label for="is_show1">上架</label>
                            <input type="radio" name="cop_show" id="is_show2" value="2" title="下架">
                            <label for="is_show2">下架</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="addCoupon(this)">添加</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_sales_promotion/coupon/coupon_add.js"></script>
