
var flag = 1;
var ws = new WebSocket("ws://" + info.socket_ip);
ws.onopen = function () {
    console.log("握手成功");
}
ws.onmessage = function (e) {

    $.get(module + 'api/getTokenInfo', {mytoken: e.data}, function (res) {
        if (Number(info.kefu_id) == Number(res.data.kefu_id)) {
            contentHtml(res.data);
        }
    });
    $.get(module + 'api/getMemberOnlineList', {mytoken: e.data}, function (res) {
        addUser(res.data);
    });

    console.log("message:" + e.data);
}
ws.onerror = function () {
    console.log("error");
    layer.msg("已断开，请重新进入。");
    $("#contentul").append('<li class="contentdiv-li">已断开，请重新进入。</li>');
    $("#up-image").css({'pointer-events': 'none'});//设置禁止点击
}
var isShow = false;
$(function () {
    $("#user_list").on('click', 'li', function () {
        var member_id = $(this).data('id');
        $("#member_id").val(member_id);
        $("#user_list li").removeClass('active');
        $(this).addClass('active');
        $("#contentul li").remove();
        getkefuChatList();
    });
    $("#send").click(function () {
        var content = $("#content").val();
        console.log(content);
        if (!content) {
            layer.msg("内容不能为空", {icon: 5});
            return;
        }
        var member_id = $("#member_id").val();
        var data = {
            type: 2,
            member_id: member_id,
            kefu_id: info.kefu_id,
            content: content,
        };
        $.post(module + 'api/getToken', data, function (res) {
            ws.send(res.data.mytoken);
        });
        return false;
    })

    $("#up-face").click(function (e) {
        e.stopPropagation();
        e.stopPropagation();
        layui.use(['layer'], function () {
            var layer = layui.layer;

            var isShow = $(".layui-mylink-face").css('display');
            if ('block' == isShow) {
                layer.close(index);
                return;
            }
            var height = $(".chat-box").height() - 110;
            layer.ready(function () {
                index = layer.open({
                    type: 1,
                    offset: [height + 'px', $(".layui-side").width() + 'px'],
                    shade: false,
                    title: false,
                    closeBtn: 0,
                    area: '395px',
                    content: showFaces()
                });
            });
        });
    })
    $(document).click(function () {
        layui.use(['layer'], function () {
            var layer = layui.layer;
            if (isShow) {
                layer.close(index);
                return false;
            }
        });
    })
    // 图片 文件上传
    layui.use(['upload', 'layer', 'element'], function () {
        var upload = layui.upload;
        var layer = layui.layer;
        var element = layui.element;

        // 执行实例
        var uploadInstImg = upload.render({
            elem: '#up-image' // 绑定元素
            , accept: 'images'
            , exts: 'jpg|jpeg|png|gif'
            , url: '/socket/upload/uploadImg' // 上传接口
            , done: function (res) {
                var data = {
                    type: 2,
                    member_id: $("#member_id").val(),
                    kefu_id: info.kefu_id,
                    content: 'img[' + res.data.src + ']',
                };
                $.post(module + 'api/getToken', data, function (res2) {
                    mytoken = res2.data.mytoken;
                    ws.send(mytoken);
                });
                showBigPic();
            }
            , error: function () {
                // 请求异常回调
            }
        });
        var uploadInstFile = upload.render({
            elem: '#file' // 绑定元素
            , accept: 'file'
            , exts: 'zip|rar'
            , url: '/socket/upload/uploadFile' // 上传接口
            , done: function (res) {
                ws.send('file(' + res.data.src + ')[' + res.msg + ']');
            }
            , error: function () {
                // 请求异常回调
            }
        });

    });
    // 会员转接
    $("#scroll-link").click(function () {
        layer.msg("暂不开放", {icon: 5});
        return;
        var id = $("#active-user").attr('data-id');
        var name = $("#active-user").attr('data-name');
        var avatar = $("#active-user").attr('data-avatar');
        var ip = $("#active-user").attr('data-ip');

        if (id == '' || name == '') {
            layer.msg("请选择要转接的会员");
        }

        // 二次确认
        var layerIndex = null;
        layerIndex = layer.confirm('确定转接 ' + name + ' ？', {
            title: '转接提示',
            closeBtn: 0,
            icon: 3,
            btn: ['确定', '取消'] // 按钮
        }, function () {
            layer.close(layerIndex);
            layerIndex = layer.open({
                title: '',
                type: 1,
                area: ['30%', '40%'],
                content: $("#change-box")
            });

            // 监听选择
            layui.use(['form'], function () {
                var form = layui.form;

                form.on('select(group)', function (data) {
                    if (infos.group == data.value) {
                        layer.msg("已经在该分组，不需要转接！");
                    } else {

                        layer.close(layerIndex);
                        var group = data.value; // 分组
                        // 交换分组
                        var change_data = '{"type":"changeGroup", "uid":"' + id + '", "name" : "' + name + '", "avatar" : "'
                                + avatar + '", "group": ' + group + ', "ip" : "' + ip + '"}';

                        //console.log(change_data);
                        socket.send(change_data);

                        // 将该会员从我的会话中移除
                        delUser({id: id});

                        layer.msg('转接成功');
                    }
                });
            });

        }, function () {

        });
    });
})
// 添加用户到面板
var member_is = false;
function addUser(data) {

    var member = data.member;
    var length = $("#user_list li").length;
    for (var i = 0; i < length; i++) {
        var member_id = $("#user_list li").eq(i).data('id');

        if (Number(member_id) == Number(member.member_id)) {
            member_is = true;
        }
    }
    if (member_is === false) {
        var _html = '<li class="layui-nav-item" data-id="' + member.member_id + '" id="f-' + member.member_id + '"' +
                ' data-name="' + member.member_name + '" data-avatar="' + member.avatar + '" data-ip="' + member.ip + '">';
        _html += '<img src="/static/' + member.avatar + '">';
        _html += '<span class="user-name">' + member.member_name + '</span>';
        _html += '<span class="layui-badge" style="margin-left:5px">' + member.chat_count + '</span>';
        _html += '<i class="layui-icon close" style="display:none">ဇ</i>';
        _html += '</li>';
        // 添加左侧列表
        $("#user_list").append(_html);
    }
//    $("#member_id").val(member.member_id);
//    $("#user_list li").removeClass("active");
//    $("#f-" + member.member_id).addClass('active');
    $("#f-" + member.member_id + " .layui-badge").text(data.chat_count);

}
// 双击图片
function showBigPic() {
    layui.use('jquery', function () {
        var $ = layui.jquery;

        $(".layui-mylink-photos").on('click', function () {
            var src = this.src;
            layer.photos({
                photos: {
                    data: [{
                            "alt": "大图模式",
                            "src": src
                        }]
                }
                , shade: 0.5
                , closeBtn: 2
                , anim: 0
                , resize: false
                , success: function (layero, index) {

                }
            });
        });
    });
}
// 滚动条自动定位到最底端
function wordBottom() {
    var box = $(".chat-box");
//    box.scrollTop(box[0].scrollHeight);
    box.animate({scrollTop: box[0].scrollHeight}, 1000);
}
function wordBottom2() {
    var box = $(".chat-box");
    box.scrollTop(box[0].scrollHeight);
}
// 消息发送工厂
function contentHtml(info, obj) {
    var member_id = $("#member_id").val();
    console.log(member_id + ',' + info.member.member_id);
    if (Number(member_id) != Number(info.member.member_id)) {
//        $("#contentul li").remove();
//        getkefuChatList();
        return;
    }
    var image = '<i class="layui-icon">&#xe770;</i>';
//    if (info.member.kefu_avatar) {
//        var image = '<img src="'+info.member.kefu_avatar+'" />';
//    } else {
//        var image = '<i class="layui-icon">&#xe770;</i>';
//    }

    var content = info.content;
    if (info.go_type == 'goods') {
        var content = goodsHtml(content);
    } else if (info.go_type == 'order') {
        var content = orderHtml(content);
    } else {
        var content = replaceContent(content);
    }
    if (!content) {
        layer.msg("发生错误", {icon: 2});
        return;
    }
    if (info.type == 1) {
        var html = `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img">
                            
                           <img src="` + info.member.member_avatar + `" />
                        </div>
                        <div class="contentdiv-text">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
    } else {
        var html = `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img2">
                            
                           ` + image + `
                        </div>
                        <div class="contentdiv-text2">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
    }

    $("#contentul").append(html);
    $("#content").val('');
    wordBottom();
}
function goodsHtml(data) {
    console.log(data);
    var goods = JSON.parse(data);
    var html = `<div class="mallzdiv-auto">
                    <a href="` + goods.url + `" target="_blank">
                        <div class="mallzdiv-img">
                            <img src="` + goods.thecover + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name2">` + goods.goods_name + `</div>
                            <div class="color-red">单价：￥<span>` + goods.goods_price + `</span></div>
                        </div>
                    </a>
                </div>`;
    return html;
}
function orderHtml(data) {

    var order = JSON.parse(data);

    var html = `<div class="mallzdiv-auto">
                        <div class="mallzdiv-img">
                            <img src="` + order.goods_img + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name2">订单：` + order.order_no + `</div>
                            <div class="color-red">实付：￥<span>` + order.total_price + `</span></div>
                        </div>
                </div>`;
    return html;
}

getkefuChatList();
function getkefuChatList(member_id) {
    var member_id = member_id ? member_id : $("#member_id").val();
    $.post(module + 'api/getkefuChatList', {member_id: member_id, kefu_id: info.kefu_id}, function (res) {
        var html = '';

        var list = res.data.data;

        $.each(list, function (index, val) {
            if (val.go_type == 'goods') {
                var content = goodsHtml(val.content);
            } else if (val.go_type == 'order') {
                var content = orderHtml(val.content);
            } else {
                var content = replaceContent(val.content);
            }
            if (val.type == 1) {
                html += `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img">
                            
                           <img src="/static/` + res.data.member_avatar + `" />
                        </div>
                        <div class="contentdiv-text">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
            } else {
                if (res.data.kefu_avatar) {
                    var kefu_avatar = res.data.kefu_avatar;
                } else {
                    var kefu_avatar = '<i class="layui-icon">&#xe770;</i>';
                }
                html += `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img2">
                            
                           ` + kefu_avatar + `
                        </div>
                        <div class="contentdiv-text2">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
            }
        })
        $("#contentul").append(html);

        $("#f-" + member_id + " .layui-badge").text(res.data.chat_count);
        wordBottom2();
    });
}

// 获取日期
function getDate() {
    var d = new Date(new Date());

    return d.getFullYear() + '-' + digit(d.getMonth() + 1) + '-' + digit(d.getDate())
            + ' ' + digit(d.getHours()) + ':' + digit(d.getMinutes()) + ':' + digit(d.getSeconds());
}
//补齐数位
var digit = function (num) {
    return num < 10 ? '0' + (num | 0) : num;
};
// 展示表情数据
function showFaces() {
    isShow = true;
    var alt = getFacesIcon();
    var _html = '<div class="layui-mylink-face"><ul class="layui-clear mylink-face-list">';
    layui.each(alt, function (index, item) {
        _html += '<li title="' + item + '" onclick="checkFace(this)"><img src="/static/images/icon/face/' + index + '.gif" /></li>';
    });
    _html += '</ul></div>';

    return _html;
//    document.getElementById('face-box').innerHTML = _html;
}

// 选择表情
function checkFace(obj) {
    var msg = document.getElementById('content').value;
    document.getElementById('content').value = msg + ' face' + obj.title + ' ';
    document.getElementById('content').focus();
    document.getElementById('face-box').style.display = 'none';
    flag = 1;
}
function statementsUse(obj) {
    var id = $(obj).data('id');
    layer.confirm('确定使用么？', {
        title: '使用提示',
        closeBtn: 0,
        icon: 3,
        btn: ['确定', '取消'] // 按钮
    }, function () {
        ajaxMethods({
            url: 'service/statementsUse',
            type: 'get',
            data: {id: id},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    layer.msg(data.prompt, {icon: 2});
                }
            }
        })
    });
}