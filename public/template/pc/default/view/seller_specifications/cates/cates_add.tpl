{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                版本名称：
            </label>
            <div class="form_text">
                <input type="text" name="cate_name" value="版本名称" placeholder="版本名称" class="mall_input" id="cate_name" size="40">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                经营类目：
            </label>
            <div class="form_text">
                <select name="directory1_id" class="" id="directory1_id">
                    <option value="0">一级类目</option>
                </select>
                <select name="directory2_id" class="" id="directory2_id">
                    <option value="0">二级类目</option>
                </select>
                <select name="directory3_id" class="" id="directory3_id">
                    <option value="0">三级类目</option>
                </select>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                排序：
            </label>
            <div class="form_text">
                <input type="text" name="sort" value="10" placeholder="排序" class="mall_input" id="sort" size="20">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                发布状态：
            </label>
            <div class="form_text">
                <select name="is_show" class="">
                    <option value="1">显示</option>
                    <option value="0">隐藏</option>
                </select>
            </div>
        </div>

        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <botton class="goods_btn goodsbtn_act" onclick="addCates(this)">添加</botton>
        </div>
    </div>
</form>

{include file="public/seller/directory_list" /}
<script type="text/javascript" src="__PC__/js/seller_specifications/cates/cates_add.js"></script>
