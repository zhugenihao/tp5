{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                供货商名称：
            </label>
            <div class="form_text">
                <input type="text" name="supplier_name" value="供货商名称1" class="mall_input" id="supplier_name" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                联系人名称：
            </label>
            <div class="form_text">
                <input type="text" name="contact_name" value="" placeholder="联系人名称" class="mall_input" id="contact_name" size="20">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                联系电话：
            </label>
            <div class="form_text">
                <input type="text" value="" name="contact_phone" class="mall_input" id="contact_phone" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                备注：
            </label>
            <div class="form_text">
                <textarea cols="39" rows="5" name="note"></textarea>
            </div>
        </div>

        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="addSupplier(this)">添加</botton>
        </div>
    </div>
</form>


<script type="text/javascript" src="__PC__/js/seller_store/supplier/supplier_add.js"></script>
