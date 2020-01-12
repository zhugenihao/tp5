
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
{include file="public/plugin/editor" /}
<div class="seller-allas">
    <div class="member-yue"><span>添加经营类目</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            经营类目：
                        </label>
                        <div class="form_text">
                            <select name="directory1_id" id="directory1_id">
                                <option value="0">选择一级类目</option>
                                {volist name="directoryBigList" id="vo"}
                                <option value="{$vo['id']}">{$vo['title']}</option>
                                {/volist}
                            </select> 
                            <select name="directory2_id" id="directory2_id">
                                <option value="0">选择二级类目</option>
                            </select> 
                            <select name="directory3_id" id="directory3_id">
                                <option value="0">选择三级类目</option>
                            </select>
                        </div>
                    </div>

                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="addBcategory(this)">添加</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/bcategory/bcategory_add.js"></script>
