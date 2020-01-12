function addWithdrawal(obj) {
    var toapplyfor_amount = $("#toapplyfor_amount").val();
    var bank_name = $("#bank_name").val();
    var bank_account = $("#bank_account").val();
    var account_name = $("#account_name").val();
    if (!trim(toapplyfor_amount)) {
        layer.msg("提现金额不能为空！", {icon: 5});
        return;
    }
    if (!is_pinteger(toapplyfor_amount)) {
        layer.msg("提现金额必须是正整数！", {icon: 5});
        return;
    }
    if (Number(toapplyfor_amount) < 10) {
        layer.msg("提现金额最小10元！", {icon: 5});
        return;
    }
    if (!trim(bank_name)) {
        layer.msg("银行名称不能为空！", {icon: 5});
        return;
    }
    if (!trim(bank_account)) {
        layer.msg("收款账号不能为空！", {icon: 5});
        return;
    }
    if (!trim(account_name)) {
        layer.msg("开户人姓名不能为空！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_statselement.withdrawal/withdrawal_add/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    closeRefresh();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}