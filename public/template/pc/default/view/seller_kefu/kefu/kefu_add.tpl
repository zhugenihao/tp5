{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服名称：
            </label>
            <div class="form_text">
                <input type="text" name="kefu_name" value="客服名称1" class="mall_input" id="kefu_name" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服类型：
            </label>
            <div class="form_text">
                <select name="kefu_type" class="">
                    <option value="1">售前客服</option>
                    <option value="2">售后客服</option>
                </select>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服工具：
            </label>
            <div class="form_text">
                <select name="kefu_tool" class="" id="kefu_tool">
                    <option value="1">站内客服</option>
                    <option value="2">qq</option>
                    <option value="3">微信</option>
                    <option value="4">旺旺</option>
                </select>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服账号：
            </label>
            <div class="form_text">
                <input type="text" name="kefu_account" value="" placeholder="客服账号(站内账号/qq/微信/旺旺)" class="mall_input" id="kefu_account" size="20">
            </div>
        </div>
        <div class="div_texts" id="passworddiv">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                登录密码：
            </label>
            <div class="form_text">
                <input type="text" name="kefu_password" value="" placeholder="登录密码" class="mall_input" id="kefu_password" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服电话：
            </label>
            <div class="form_text">
                <input type="text" value="" name="tel" class="mall_input" id="tel" size="20">
            </div>
        </div>
        
        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="addKefu(this)">添加</botton>
        </div>
    </div>
</form>


<script type="text/javascript" src="__PC__/js/seller_kefu/kefu/kefu_add.js"></script>
