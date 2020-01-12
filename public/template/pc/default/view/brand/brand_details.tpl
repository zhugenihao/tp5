
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>编辑品牌</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" id="brand_from" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            品牌标题：
                        </label>
                        <div class="form_text">
                            <input type="text" name="brand_name" value="{$info['brand_name']}" class="mall_input" id="brand_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            品牌地址：
                        </label>
                        <div class="form_text">
                            <input type="text" name="brand_url" value="{$info['brand_url']}" class="mall_input" id="brand_url" size="40">
                        </div>
                    </div>

                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            品牌logo：
                        </label>
                        <div class="form_text">
                            <label class="fileimg-btn" for="images">选择文件</label>
                            <input class="" onchange="getPhoto(this, 'brand_logo', 150)" id="images" style="display: none;" name="brand_logo" type="file">

                            <img src="__STATIC__/{$info['brand_logo']}" class="fileimg_brand_logo" />
                            <input type="hidden" value="{$info['brand_logo']}" name="brand_logo" />
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
                            品牌描述：
                        </label>
                        <div class="form_text">
                            <textarea cols="40" rows="5" name="describe" id="describe">{$info['describe']}</textarea>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            状态：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" {eq name="info['is_show']" value="1"}checked{/eq}>
                            <label for="is_show1">上架</label>
                            <input type="radio" name="is_show" id="is_show2" value="0" title="下架" {eq name="info['is_show']" value="0"}checked{/eq}>
                            <label for="is_show2">下架</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="detailsBrand(this)">编辑</botton>
                    </div>
                </div>
                <input type="hidden" value="{$info['id']}" name="brand_id" />
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/brand/brand_details.js"></script>
