
function cartDetermine(obj) {
    ajaxForm({
        url: 'cart/cartOneSubmit/',
        type: 'post',
        formName: 'cartoneform',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function cartlistBtn(obj) {
    var checked = getChecked();
    if (!checked || checked == 'on') {
        layer.msg('请选择商品', {icon: 5});
        return false;
    }
    goodsJudge();
}
function delCart(obj) {
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        delCartAjax(obj);
    });
}
function delCartAjax(obj) {
    var cart_id = $(obj).data('cartid');
    ajaxMethods({
        url: 'cart/cartDel/',
        type: 'get',
        data: {cart_id: cart_id},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function goodsJudge() {
    ajaxForm({
        url: 'cart/goodsJudge/',
        type: 'post',
        formName: "cartlistform",
        sCallback: function (data) {
            if (data.types === 1) {
                $("#cartlistform").submit();
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function emptyCart(obj) {
    layer.confirm('确定要清空购物车么？', {
        btn: ['确认', '取消']
    }, function () {
        emptyCartAjax(obj);
    });
}
function emptyCartAjax(obj) {
    ajaxMethods({
        url: 'cart/emptyCart/',
        type: 'get',
        data: {},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}

