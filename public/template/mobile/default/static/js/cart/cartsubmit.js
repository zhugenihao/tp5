
function cartDetermine(obj) {
    ajaxForm({
        url: 'cart/cartOneSubmit/',
        type: 'post',
        formName: 'cartoneform',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function cartlistBtn(obj) {
    var checked = getChecked();
    if(!checked || checked == 'on'){
       layer.msg('请选择商品', function () {});
       return false;
    }
    goodsJudge();
}
function delCart(obj) {
    layer.msg('确定要删除么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            delCartAjax(obj);
        }
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
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function goodsJudge(){
    ajaxForm({
        url: 'cart/goodsJudge/',
        type: 'post',
        formName: "cartlistform",
        sCallback: function (data) {
            if (data.types === 1) {
                 $("#cartlistform").submit();
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}
function emptyCart(obj){
    layer.msg('确定要清空购物车么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            emptyCartAjax(obj);
        }
    });
}
function emptyCartAjax(obj) {
    ajaxMethods({
        url: 'cart/emptyCart/',
        type: 'get',
        data: {},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
        }
    });
}

