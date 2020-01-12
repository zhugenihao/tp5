{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/socket/css/index/pc_index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                聊天内容：
            </label>
            <div class="form_text" id="content2" style="width:350px;" go_type="{$info['go_type']}">
                {$info['content']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                用户名称：
            </label>
            <div class="form_text">
                {$info['member_name']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                客服名称：
            </label>
            <div class="form_text">
                {$info['kefu_name']}
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                类型：
            </label>
            <div class="form_text">
                <select name="type" class="">
                    <option value="1" {eq name="info['type']" value="1"}selected{/eq}>用户的信息</option>
                    <option value="2" {eq name="info['type']" value="2"}selected{/eq}>客服的信息</option>
                </select>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                创建时间：
            </label>
            <div class="form_text">
                {$info['create_time']}
            </div>
        </div>
        <input type="hidden" value="{$info['id']}" name="id" />
        <div class="goodsbtn_div formdiv_btn">
            <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
            <!--<botton class="goods_btn goodsbtn_act" onclick="detailsSubmit(this)">编辑</botton>-->
        </div>
    </div>
</form>
<script type="text/javascript" src="__STATIC__/socket/js/public/functions.js"></script>
<script type="text/javascript" src="__PC__/js/seller_kefu/kefu_chat/kefu_chat_details.js"></script>
