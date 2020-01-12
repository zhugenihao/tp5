{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                订单编号：
            </label>
            <div class="form_text">
                {$info['order_no']}
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                商品名称：
            </label>
            <div class="form_text">
                {$info['goods_name']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                商品数量：
            </label>
            <div class="form_text">
                {$info['goods_num']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                退款金额：
            </label>
            <div class="form_text">
                {$info['refund_amount']}
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
                服务类型：
            </label>
            <div class="form_text">
                {eq name="info['service_type']" value="1"}退货{/eq}
                {eq name="info['service_type']" value="2"}换货{/eq}
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                理由内容：
            </label>
            <div class="form_text">
                <textarea cols="39" rows="5" name="reason_content" disabled="">{$info['reason_content']}</textarea>
            </div>
        </div>
        
        <div class="div_texts">
            <label class="form_title2">
                申请时间：
            </label>
            <div class="form_text">
                {$info['create_time']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                状态：
            </label>
            <div class="form_text">
                <input type="radio" name="state" id="is_show1" value="1" title="是" {eq name="info['state']" value="1"} checked{/eq}>
                <label for="is_show1">审核中</label>
                <input type="radio" name="state" id="is_show2" value="2" title="否" {eq name="info['state']" value="2"} checked{/eq}>
                <label for="is_show2">审核通过</label>
                <input type="radio" name="state" id="is_show3" value="3" title="否" {eq name="info['state']" value="3"} checked{/eq}>
                <label for="is_show3">审核不通过</label>
            </div>
        </div>
    </div>


    <div class="goodsbtn_div formdiv_btn">
        <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
        <botton class="goods_btn goodsbtn_act" onclick="detailsRetplt(this)">编辑</botton>
    </div>
</div>
<input type="hidden" value="{$info['id']}" name="id" />
</form>


<script type="text/javascript" src="__PC__/js/seller_after_sales/returns_replacement/retplt_details.js"></script>
