$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
        //表单初始赋值

    })
})
//获取手机验证码
function verificationCode(obj) {
    resetTime(10);
    return false;
    ajaxMethods({
        url: 'common/verificationcode/',
        type: 'post',
        data: {},
        sCallback: function (data) {
            layer.msg('发送成功！');
        }
    });
}
//用户注册
function registeredSubmit(obj) {
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在注册中...');
    ajaxForm({
        url: 'login/registeredSubmit/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            $(obj).val('立即注册');
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    href_url('login/login/');
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 2});
                $(obj).css({'pointer-events': 'auto'});
            }
        }
    });
}

//单纯分钟和秒倒计时
function resetTime(time) {
    console.log(333);
    $('#btncode').attr('disabled', "true");//添加disabled属性
    var timer = null;
    var t = time;
    var m = 0;
    var s = 0;
    m = Math.floor(t / 60 % 60);
    m < 10 && (m = '0' + m);
    s = Math.floor(t % 60);
    function countDown() {
        s--;
        s < 10 && (s = '0' + s);
        if (s.length >= 3) {
            s = 59;
            m = "0" + (Number(m) - 1);
        }
        if (m.length >= 3) {
            m = '00';
            s = '00';
            clearInterval(timer);
        }
//        console.log(m + "分钟" + s + "秒");
        if (s != '00') {
            var text = '验证码(' + s + ')后过时！';
            var css = {'background': '#ccc'};
        } else {
            var text = '重新获取验证码';
            var css = {'background': '#eee'};
            $('#btncode').removeAttr('disabled');//移除disabled属性
        }
        $("#btncode").css(css);
        $("#btncode").val(text);
    }
    timer = setInterval(countDown, 1000);
}
