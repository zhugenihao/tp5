{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                常用语句内容：
            </label>
            <div class="form_text">
                <textarea cols="39" rows="5" name="content" placeholder="常用语句内容" id="content2">{$info['content']}</textarea>
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                状态：
            </label>
            <div class="form_text">
                <select name="is_show" class="">
                    <option value="1" {eq name="info['is_show']" value="1"}selected{/eq}>显示</option>
                    <option value="2" {eq name="info['is_show']" value="2"}selected{/eq}>隐藏</option>
                </select>
            </div>
        </div>
        <input type="hidden" value="{$info['id']}" name="kstem_id" />
        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="detailsSubmit(this)">编辑</botton>
        </div>
    </div>
</form>

<script type="text/javascript" src="__PC__/js/seller_kefu/kefu_statements/statements_details.js"></script>
