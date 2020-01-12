{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                登录账号：
            </label>
            <div class="form_text">
                <input type="text" name="seller_name" value="{$seller['seller_name']}" placeholder="登录账号" class="mall_input" id="seller_name" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                原登录密码：
            </label>
            <div class="form_text">
                <input type="password" name="seller_password" value="" placeholder="登录密码" class="mall_input" id="seller_password" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                新登录密码：
            </label>
            <div class="form_text">
                <input type="password" name="new_password" value="" placeholder="留空则不改" class="mall_input" id="new_password" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                确认新密码：
            </label>
            <div class="form_text">
                <input type="password" name="queren_password" value="" placeholder="留空则不改" class="mall_input" id="queren_password" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                账号组：
            </label>
            <div class="form_text">
                {$seller['group_name']}
            </div>
        </div>

        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="settingsSeller(this)">设置</botton>
        </div>
    </div>
</form>


<script type="text/javascript" src="__PC__/js/seller_account/seller/account_settings.js"></script>
