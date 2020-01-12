$(function () {
    layui.use(['form', 'layedit', 'laydate','layer'], function () {
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
function memberMobile(obj) {
    var member_mobile = $("#member_mobile").val();
    var code = $("#code").val();
    if (!isMobile(member_mobile)) {
        layer.msg('手机号码不能为空或不正确!', function () {//关闭后的操作
        });
        return false;
    }
    if (!trim(code)) {
        layer.msg('验证码不能为空!', function () {//关闭后的操作
        });
        return false;
    }
    layer.confirm('你确定要修改手机号码么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        console.log(3333);
        ajaxMemberName(member_mobile,code);
    });
}
function ajaxMemberName(member_mobile,code) {
    ajaxMethods({
        url: 'member/member_mobile/',
        type: 'get',
        data: {member_mobile: member_mobile,code:code},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    href_url('member/index?type=member');
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {//关闭后的操作
                });
            }
        }
    });
}
//单纯分钟和秒倒计时
function resetTime(time) {
    console.log(333);
    $('#onCode').attr('disabled', "true");//添加disabled属性
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
            var css = {'background': '#999'};
        } else {
            var text = '重新获取验证码';
            var css = {'background': '#666'};
            $('#onCode').removeAttr('disabled');//移除disabled属性
        }
        $("#onCode").css(css);
        $("#onCode").text(text);
    }
    timer = setInterval(countDown, 1000);
}