
var module = '/admin/';
//var module = '/mallz/public/admin/';
//ajax优化
function ajaxMethods(ajaxArray) {
    if (ajaxArray.type == '') {
        ajaxArray.type = 'GET';
    }
    $.ajax({
        type: ajaxArray.type,
        url: module + ajaxArray.url,
        data: ajaxArray.data,
        dataType: 'json',
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
    });
}
//表单提交优化
function ajaxForm(ajaxArray) {
    if (ajaxArray.type == '') {
        ajaxArray.type = 'GET';
    }
    var form = document.forms.namedItem(ajaxArray.formName);
    var form = new FormData(form);
    $.ajax({
        type: ajaxArray.type,
        url: module + ajaxArray.url,
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
    });
}
function imgBigShow(obj, title,closeBtn) {
    var img_url = $(obj).attr('url');
    var img = '<div class="sas"><img src="' + img_url + '"></div>'
    var closeBtn = closeBtn === undefined ? 1 : closeBtn;
    var title = title === undefined ? false : title;
    layer.open({
        type: 1,
        title: title,
        closeBtn: closeBtn,
//        area: '500px',
        skin: 'layui-layer-nobg', //没有背景色
        shadeClose: true,
        content: img
    });
}
function imgExists(e) {
    //默认图片
    var img = event.srcElement;
    var imgUrl = '/static/images/user.png';
    e.src = imgUrl;
    img.onerror = null;// 控制不要一直跳动
}
//关闭当前并刷新
function closeRefresh() {
    var index = parent.layer.getFrameIndex(window.name);//获取当前弹出层的层级
    window.parent.location.reload();//刷新父页面
    parent.layer.close(index);//关闭弹出层
}

function href_jump(title, url, w, h) {
    layer_show(title, url, w, h);
}
//页面弹出
function href_url(title, url) {
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
//时间格式化
function formatDate(time) {
    var date = new Date(time);

    var year = date.getFullYear(),
            month = date.getMonth() + 1, //月份是从0开始的
            day = date.getDate(),
            hour = date.getHours(),
            min = date.getMinutes(),
            sec = date.getSeconds();
    var newTime = year + '-' +
            month + '-' +
            day + ' ' +
            hour + ':' +
            min + ':' +
            sec;
    return newTime;
}
//上传图片显示
var imgurl = "";
function getPhoto(node, _class, width, height) {
    var imgURL = "";
    try {
        var file = null;
        if (node.files && node.files[0]) {
            file = node.files[0];
        } else if (node.files && node.files.item(0)) {
            file = node.files.item(0);
        }
        //Firefox 因安全性问题已无法直接通过input[file].value 获取完整的文件路径  
        try {
            imgURL = file.getAsDataURL();
        } catch (e) {
            imgRUL = window.URL.createObjectURL(file);
        }
    } catch (e) {
        if (node.files && node.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imgURL = e.target.result;
            };
            reader.readAsDataURL(node.files[0]);
        }
    }
    creatImg(imgRUL, _class, width, height);
    console.log(111);
    return imgURL;
}

function creatImg(imgRUL, _class, width, height) {
    var _class = _class === undefined ? '' : _class;
    var width = width === undefined ? '200' : width;
    var height = height === undefined ? '' : height;
    var textHtml = "<img src='" + imgRUL + "'width='" + width + "' height='" + height + "'/>";
    $(".ge_pic_icon_Infor" + _class).html(textHtml);
}
$(function () {
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });
    $("#tab-category").Huitab({
        index: 0
    });
})
// 验证手机号
function isPhoneNo(phone) {
    var pattern = /^1[34578]\d{9}$/;
    return pattern.test(phone);
}
//手机号验证
function isMobile(val) {
    var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
    if (!myreg.test(val)) {
        return false;
    } else {
        return true;
    }
}
// 验证email
function isEmail(email) {
    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    return reg.test(email);
}
/*
 用途：检查输入的电话号码格式是否正确
 */
function isPhone(strPhone) {
    if (!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(strPhone)) {
        return false;
    } else {
        return true;
    }
}
/*  身份证验证  开始  */
function idCard(identNumber) {
    if (!(/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(identNumber))) {
//        layer.msg("身份证号码格式错误！", {icon: 2});
        return false;
    }
    //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X。  
    if (!(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(identNumber))) {
//        layer.msg("身份证号码格式错误！", {icon: 2});
        return false;
    }
    //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
    //下面分别分析出生日期和校验位
    var len, re;
    len = identNumber.length;
    //判断18位身份证号码，现在在国家统一身份证为18位。
    if (len == 18) {
        re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/);
        var arrSplit = identNumber.match(re);
        //检查生日日期是否正确
        var dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
        var bGoodDay;
        bGoodDay = (dtmBirth.getFullYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
        if (!bGoodDay) {
//            layer.msg("身份证号码日期不匹配！", {icon: 2});
            return false;
        } else {
            //检验18位身份证的校验码是否正确。
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            var valnum;
            var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            var nTemp = 0, i;
            for (i = 0; i < 17; i++) {
                nTemp += identNumber.substr(i, 1) * arrInt[i];
            }
            valnum = arrCh[nTemp % 11];
            if (valnum != identNumber.substr(17, 1)) {
//                layer.msg("身份证号码校验位不正确！", {icon: 2});
                return false;
            }
//            alert("身份证合法");
            return true;
        }
    } else {
//        layer.msg("身份证号码位数不足18位！", {icon: 2});
        return false;
    }
}
/*  身份证验证  结束  */

//验证护照号码
function checkPassport(code) {
    var tip = "OK";
    var pass = true;

    if (!code || !/^((1[45]\d{7})|(G\d{8})|(P\d{7})|(S\d{7,8}))?$/.test(code)) {
        tip = "护照号码格式错误";
        pass = false;
    }
    return pass;
}

//选择
function getChecked() {
    var idstr = $('input[type=checkbox]:checked').map(function () {
        return this.value
    }).get().join(',');
    return idstr;
}
//去左右空格;
function trim(str) {
    return $.trim(str);
}
