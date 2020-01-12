
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>添加秒杀</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            选择秒杀商品：<br/>
                            (输入商品名称或商品ID)
                        </label>
                        <div class="form_text posformtext">
                            <input type="text" placeholder="请输入商品名称或商品ID" class="mall_input" id="goods_id" oninput="goodsList(this)" size="60">
                            <ul class="goodslistul goodsulclick"> 
                                <li data-goodsid="1" onclick="goodsulli(this)"></li>
                            </ul>
                            <input type="hidden" name="goods_id" value="0" class="goods_id">
                        </div>

                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            秒杀价格(￥)：
                        </label>
                        <div class="form_text">
                            <input type="text" name="sk_price" value="1.00" class="mall_input" id="sk_price" size="40">
                        </div>
                    </div>


                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            秒杀数量（件）：
                        </label>
                        <div class="form_text">
                            <input type="text" value="10" name="sk_num" class="mall_input" id="sk_num" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            设置为每天：
                        </label>
                        <div class="form_text">
                            <select name="every_day" id="every_day" onchange="everyDay(this)">
                                <option value="1" >设置</option>
                                <option value="2" >不设置</option>
                            </select>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            开始时间：
                        </label>
                        <div class="form_text" id="start_timediv">
                            <input type="text" value="{$start_time}" name="start_time" class="mall_input" id="start_time1" placeholder="HH:mm:ss" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            结束时间：
                        </label>
                        <div class="form_text" id="end_timediv">
                            <input type="text" value="" name="end_time" class="mall_input" id="end_time1" placeholder="HH:mm:ss" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            排序值：
                        </label>
                        <div class="form_text">
                            <input type="text" value="10" name="sort" class="mall_input" id="sort" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            状态：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" checked="">
                            <label for="is_show1">上架</label>
                            <input type="radio" name="is_show" id="is_show2" value="2" title="下架">
                            <label for="is_show2">下架</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="addSecondskill(this)">添加</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_sales_promotion/seconds_kill/secondskill_add.js"></script>
