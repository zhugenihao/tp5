
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
{include file="public/plugin/editor" /}
<div class="seller-allas">
    <div class="member-yue"><span>添加导航</span></div>

    <div class="from_divall">
        <div class="fromdivall_auto">
            <form action="" method="post" name="submitfrom" enctype="multipart/form-data">
                <div class="fromtext_auto">
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            导航标题：
                        </label>
                        <div class="form_text">
                            <input type="text" name="cat_name" value="导航标题1" class="mall_input" id="cat_name" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            指定的大类目：
                        </label>
                        <div class="form_text">
                            <select name="dir_id" id="dir_id">
                                <option value="0">请选择</option>
                                {volist name="businessCategory" id="vo"}
                                <option value="{$vo['directory1_id']}">{$vo['directory1_name']}</option>
                                {/volist}
                            </select> 
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            导航地址：
                        </label>
                        <div class="form_text">
                            <input type="text" name="cat_link" value="" placeholder="请加上http://" class="mall_input" id="cat_link" size="40">
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            设备类型：
                        </label>
                        <div class="form_text">
                            <select name="equipment" id="equipment">
                                <option value="1">手机</option>
                                <option value="2">电脑</option>
                            </select> 
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
                            导航描述：
                        </label>
                        <div class="form_text" style="width:900px;">
                            <textarea id="editor" style="height:300px;" name="description"></textarea>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            新窗口打开：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_newwindow" id="is_newwindow1" value="1" title="是" checked="">
                            <label for="is_newwindow1">是</label>
                            <input type="radio" name="is_newwindow" id="is_newwindow2" value="0" title="否">
                            <label for="is_newwindow2">否</label>
                        </div>
                    </div>
                    <div class="div_texts">
                        <label class="form_title">
                            <i class="Hui-iconfont color-red">&#xe630;</i>
                            显示：
                        </label>
                        <div class="form_text">
                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" checked="">
                            <label for="is_show1">是</label>
                            <input type="radio" name="is_show" id="is_show2" value="0" title="下架">
                            <label for="is_show2">否</label>
                        </div>
                    </div>
                    <div class="goodsbtn_div formdiv_btn">
                        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                        <botton class="goods_btn goodsbtn_act" onclick="addCategory(this)">添加</botton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/category/category_add.js"></script>
