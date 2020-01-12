

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
        async:false,
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
//底部弹窗
function popupWindow(obj) {
    var style = 'position: fixed;width:100%;height:100%;background: #000;opacity: 0.5;z-index:100;top:0px;';
    var darkall = '<div class="darkall floatfalse" style="' + style + '" onclick="wshutDown(this)"></div>';
    $('body').after(darkall);
    $(".choose").show();
    $(".choose").stop().animate({bottom: '0px'}, 300);
}
//关闭底部弹窗
function wshutDown(obj) {
    $(".choose").stop().animate({bottom: '-200px'}, 300);
    setTimeout(function () {
        $(".darkall").remove();
        $(".choose").hide(100);
    }, 300);
}
$(function () {
    $(".choose div").click(function () {
        wshutDown();
    });
});
//跳转1
function pageJump(url) {
    window.location.href = url;
}
//跳转2
function href_url(url) {
    window.location.href = module + url;
}
//链接
function tp5_url(url){
    return module + url;
}
//文件地址
function files_url(url){
    return staticurl + url;
}
//用户已登录可跳转指定连接
function isLogin_url(url) {
    ajaxMethods({
        url: 'is_mid/',
        sCallback: function (data) {
            if (!data.mid) {
                headMessageBox({type: 2, title: '你还未登录！'});
                setTimeout(function () {
                    href_url(url);
                }, 1000);
            }
        }
    });
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
//手机端弹窗确认框
function confirmWdman(confirmArray) {
    var btnTitle = confirmArray.btnTitle ? confirmArray.btnTitle : '弹窗标题';
    var text = confirmArray.text ? confirmArray.text : '确认信息';
    var btnText = confirmArray.btnText ? confirmArray.btnText : '确 定';
    var consText = confirmArray.consText ? confirmArray.consText : '取 消';
    popTipShow.confirm(btnTitle, text, [btnText, consText],
            function (e) {
                //callback 处理按钮事件		  
                var button = $(e.target).attr('class');
                if (button == 'ok') {
                    confirmArray.sCallback && confirmArray.sCallback();
                }
                if (button == 'cancel') {
                    //按下取消按钮执行的操作
                }
                this.hide();
            })
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
$(function () {
    $('body').click(function () {
//     headMessageBox({type:3,title:''});
    })
    changeImageCss({setTime: 200});
})

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
function trim(s) {
    return s.replace(/(^\s*)|(\s*$)/g, "");
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
function getChecked(){
    var idstr = $('input[type=checkbox]:checked').map(function () {
        return this.value
    }).get().join(',');
    return idstr;
}




