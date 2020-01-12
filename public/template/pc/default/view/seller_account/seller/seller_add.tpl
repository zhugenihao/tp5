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
                <input type="text" name="seller_name" value="" placeholder="登录账号" class="mall_input" id="seller_name" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                登录密码：
            </label>
            <div class="form_text">
                <input type="password" name="seller_password" value="" placeholder="登录密码" class="mall_input" id="seller_password" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                账号组：
            </label>
            <div class="form_text">
                <select name="group_id" class="" id="group_id">
                    {volist name="sellerGroup" id="vo"}
                    <option value="{$vo['id']}">{$vo['group_name']}</option>
                    {/volist}
                </select>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                状态：
            </label>
            <div class="form_text">
                <select name="seller_delete" class="">
                    <option value="1">启用</option>
                    <option value="2">禁用</option>
                </select>
            </div>
        </div>

        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="addSeller(this)">添加</botton>
        </div>
    </div>
</form>


<script type="text/javascript" src="__PC__/js/seller_account/seller/seller_add.js"></script>
