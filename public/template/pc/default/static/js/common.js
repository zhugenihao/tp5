layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
});
$(function () {
    $('body').click(function () {
//     headMessageBox({type:3,title:''});
    })
    changeImageCss({setTime: 200});

    //111实现全选与反选
    $("#checkedAll").click(function () {
        console.log(21323);
        if ($(this).prop("checked")) {
            $("input:checkbox").each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("input:checkbox").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    $("#detailstitle div").click(function () {
        $("#detailstitle div").removeClass("detls-act");
        $(this).addClass("detls-act");
        var index = $(this).index();
        $(".detlstextone").hide();
        $(".detlstextone").eq(index).show();
    })
})
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
        async: false,
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
            changeImageCss({setTime: 500});
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
        url: module + ajaxArray.url,
        type: ajaxArray.type,
        data: form,
        cache: false, //上传文件不需要缓存
        processData: false, // 告诉jQuery不要去处理发送的数据
        contentType: false, // 告诉jQuery不要去设置Content-Type请求头
        dataType: 'json',
        success: function (data) {
            ajaxArray.sCallback && ajaxArray.sCallback(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
    });
}

//获取地址栏参数，name:参数名称
function getUrlParms(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return unescape(r[2]);
    return null;
}
//判断字符串是否包含某个字符
function stringContaCharacter(string, character) {
    var reg = RegExp(character);
    if (string.match(reg)) {
        return true;
    } else {
        return false;
    }
}
//返回上一页
function returnOnPage() {
    history.back();
}
//返回上一页并刷新
function returnOnPageReload() {
    history.back();
    setTimeout(function () {
        location.reload();
    }, 1000);
}
//关闭当前并刷新
function closeRefresh() {
    var index = parent.layer.getFrameIndex(window.name);//获取当前弹出层的层级
    window.parent.location.reload();//刷新父页面
    parent.layer.close(index);//关闭弹出层
}
function shutDown(obj) {
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    //layer.msg(index);
    parent.layer.close(index); //再执行关闭   
}
//跳转1
function pageJump(url) {
    window.location.href = url;
}
//跳转2
function href_url(url) {
    window.location.href = module + url;
}
//链接
function tp5_url(url) {
    return module + url;
}
//文件地址
function files_url(url) {
    return staticurl + url;
}

//弹窗
function alertWindow(arraylist) {
    var type = arraylist.type ? arraylist.type : 2;
    var text = arraylist.text ? arraylist.text : '弹窗';
    var html = '<div class="alewdw"></div>';
    if (type == 1) {
        html += '<div class="alewdw-auto" >';
        html += '<div class="alewdw-top" ></div>';
        html += '<div class="alewdw-text">' + text + '</div>';
        html += '<div class="alewdw-btn"><div class="aldwcos" onclick="guanAlert(this)">取消</div><div class="alagreed" onclick="guanAlert(this)">确定</div></div>';
        html += '</div>';
    }
    if (type == 2) {
        html += '<div class="alewdw-auto" >';
        html += '<div class="alewdw-top" ></div>';
        html += '<div class="alewdw-text">' + text + '</div>';
        html += '<div class="alewdw-btn bacbntal" onclick="guanAlert(this)">确&nbsp;&nbsp;&nbsp;定</div>';
        html += '</div>';
    }
    if (type == 3) {
        html += '<div class="alewdw-auto" >';
        html += '<div class="alewdw-top" ></div>';
        html += '<div class="alewdw-text errcolor">' + text + '</div>';
        html += '<div class="alewdw-btn bacbntal" onclick="guanAlert(this)">确&nbsp;&nbsp;&nbsp;定</div>';
        html += '</div>';
    }
    $("body").prepend(html);
    $(".alewdw-auto").stop().animate({top: '35%', opacity: '1'}, 200);
}
//关闭弹窗
function guanAlert(obj) {
    setTimeout(function () {
        $(".alewdw,.alewdw-auto").remove();
    }, 200);
    return false;
}
//弹窗确定
function agreedAlert(obj) {
    $(".alewdw,.alewdw-auto").remove();
    return false;
}
//开启加载
function openLoading(text) {
    var text = text ? text : '';
    var html = '<div class="loadings"><img src="' + weburl + '/static/images/loading-3.gif" style="width:30px;"/>';
    html += '<p>' + text + '</p></div>';
    html += '<div class="alewdw"></div>';
    $("body").prepend(html);
}
//关闭加载
function guanLoading() {
    $(".loadings,.alewdw").remove();
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
/*
 用途：检查输入的Email信箱格式是否正确
 输入：
 strEmail：字符串
 返回：
 如果通过验证返回true,否则返回false
 */
function isEmail(strEmail) {
//var emailReg = /^[_a-z0-9]+@([_a-z0-9]+\.)+[a-z0-9]{2,3}$/;
    var emailReg = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
    if (emailReg.test(strEmail)) {
        return true;
    } else {
        return false;
    }
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

//滚动
function scrollList(scrollArray) {
    changeImageCss(2000);
    var idClass = scrollArray.idClass;
    idClass.scroll(function () {
        var ScrollHight = $(this)[0].scrollHeight;
        var scrollTop = $(this).scrollTop();
        var scrollHeight = idClass.height();
        if (idClass == $(window)) {//自定义
            var scrollHeight = $(document).height();
        }
        if (scrollTop + scrollHeight == ScrollHight) {
            //加载数据
            scrollArray.sCallback && scrollArray.sCallback();

        } else {
            console.log('数据加载完毕！');
        }
    })
}
//滚动是否拉倒底部
function is_scrollbottom(arraylist) {
    var that = arraylist.obj;
    var ScrollHight = $(that)[0].scrollHeight;
    var scrollTop = $(that).scrollTop();
    var scrollHeight = arraylist.idClass.height();
    if (arraylist.idClass == $(window)) {//自定义
        var scrollHeight = $(document).height();
    }
    if (scrollTop + scrollHeight == ScrollHight) {
        return true;
    } else {
        return false;
    }
}

//图片上传显示
function imgShow(list) {
    var that = list.that;
    var idName = list.idName;
    var file = that.files[0];
    if (window.FileReader) {
        var fr = new FileReader();
        var mysubimgas = document.getElementById(idName);
        fr.onloadend = function (e) {
            if (e.total > 8000000) {
                alertWindow({type: 2, text: "文件太大！"});
                return false;
            }
            openLoading('图片正在压缩中...');
            lrz(e.target.result, {quality: 0.6}).then(function (data) {
                guanLoading();
                mysubimgas.src = e.target.result;
                list.sCallback && list.sCallback();
            }).catch(function (err) {
                console.log(err);
            });
        };
        fr.readAsDataURL(file);
    }
}


//头部提示信息框
function headMessageBox(arrayList) {
    var html = '';
    var typeClass;
    switch (arrayList.type) {
        case 1:
            typeClass = 'successfulBackground';
            break;
        case 2:
            typeClass = 'failureBackground';
            break;
        case 3:
            typeClass = 'loadingBackground';
            break;
        default:
    }
    var title = arrayList.title ? arrayList.title : '正在加载中...';
    var alewdw = arrayList.alewdw ? arrayList.alewdw : false;
    var html = '<div class="headMessageBox ' + typeClass + '">' + title + '</div>';
    if (alewdw == true) {//禁止操作的遮罩
        html += '<div class="alewdwer"></div>';
    }
    $('body').prepend(html);
    var headMessageBox = $(".headMessageBox");
    setTimeout(function () {
        headMessageBox.stop().animate({opacity: '1'}, 500);
    }, 500);

    if (arrayList.type === 3) {//加载类型
        return false;
    }
    stopHeadMessageBox();
}
//停止提示信息框
function stopHeadMessageBox() {
    var headMessageBox = $(".headMessageBox");
    setTimeout(function () {
        headMessageBox.stop().animate({opacity: '0'}, 500);
    }, 3000);
    setTimeout(function () {
        headMessageBox.remove();
        $(".alewdwer").remove();
    }, 3500);
}
//延时事件
function sleep(numberMillis) {
    var now = new Date();
    var exitTime = now.getTime() + numberMillis;
    while (true) {
        now = new Date();
        if (now.getTime() > exitTime)
            return;
    }
}


function changeImageCss(arrayList) {
    var setTime = arrayList.setTime ? arrayList.setTime : 2000;
    setTimeout(function () {
        $(".imgcssA").addClass("imgSecond");
    }, setTime);

}
function imgExists(e) {
    //默认图片
    var img = event.srcElement;
    var imgUrl = staticurl + 'images/user.png';
    e.src = imgUrl;
    img.onerror = null;// 控制不要一直跳动
}
//去左右空格;
function trim(str) {
    return $.trim(str);
}
//正整数
function is_pinteger(str) {
    if (!(/^(\+|-)?\d+$/.test(str)) || str < 0) {
        return false;
    } else {
        return true;
    }
}
//制保留2位小数，如：2，会在2后面补上00.即2.00 
function returnFloat(value) {
    var value = Math.round(parseFloat(value) * 100) / 100;
    var xsd = value.toString().split(".");
    if (xsd.length == 1) {
        value = value.toString() + ".00";
        return value;
    }
    if (xsd.length > 1) {
        if (xsd[1].length < 2) {
            value = value.toString() + "0";
        }
        return value;
    }
}

//选择
function getChecked() {
//    $("#checkedAll").remove();
    var idstr = $('input[type=checkbox]:checked').map(function () {
        if (this.value == 'on' || this.value == '') {
            return;
        }
        return this.value
    }).get().join(',');
    console.log(idstr);
    return idstr;
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
    $(".fileimg_" + _class).attr('src', imgRUL);
    $(".fileimg_" + _class).css({'width': width, 'height': height});
}
function imgBigShow(obj, title, closeBtn) {
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




