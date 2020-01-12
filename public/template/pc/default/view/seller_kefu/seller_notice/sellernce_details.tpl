{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                通知者：
            </label>
            <div class="form_text">
                <input type="text" name="kefu_name" value="总平台" class="mall_input" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                消息内容：
            </label>
            <div class="form_text">
                <textarea cols="39" rows="5" name="content">{$info['content']}</textarea>
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                更新时间：
            </label>
            <div class="form_text">
                <input type="text" name="kefu_name" value="{$info['create_time']}" class="mall_input" id="create_time" size="20">
            </div>
        </div>


        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
        </div>
    </div>
    <input type="hidden" value="{$info['id']}" name="id" />
</form>

