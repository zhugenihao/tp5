{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                提现金额：
            </label>
            <div class="form_text">
                <input type="text" name="toapplyfor_amount" value="" placeholder="最少提现额度10" class="mall_input" id="toapplyfor_amount" size="40">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                银行名称：
            </label>
            <div class="form_text">
                <input type="text" name="bank_name" value="" placeholder="如:支付宝,农业银行,工商银行等..." class="mall_input" id="bank_name" size="40">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                收款账号：
            </label>
            <div class="form_text">
                <input type="text" name="bank_account" value="" placeholder="如:支付宝账号,建设银行账号" class="mall_input" id="bank_account" size="40">
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                开户人姓名：
            </label>
            <div class="form_text">
                <input type="text" name="account_name" value="" placeholder="开户人姓名" class="mall_input" id="account_name" size="40">
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                备注：
            </label>
            <div class="form_text">
                <input type="text" name="note" value="" placeholder="备注" class="mall_input" id="note" size="40">
            </div>
        </div>
    </div>
    <div class="goodsbtn_div formdiv_btn">
        <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
        <botton class="goods_btn goodsbtn_act" onclick="addWithdrawal(this)">立即申请</botton>
    </div>
</div>
</form>


<script type="text/javascript" src="__PC__/js/seller_statselement/withdrawal/withdrawal_add.js"></script>
