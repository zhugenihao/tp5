var flag = 1;
var lianjie_is = false;
var ws = new WebSocket("ws://" + infos.socket_ip);
ws.onopen = function () {
    console.log("握手成功");
    var content = infos.content ? infos.content : '欢迎光临!'
    var dataone = {
        type: 2,
        member_id: infos.member_id,
        kefu_id: infos.kefu_id,
        content: content,
    };
    $.post(module + 'api/getToken', dataone, function (res) {
        ws.send(res.data.mytoken);
    });
}
ws.onmessage = function (e) {
    $.get(module + 'api/getTokenInfo', {mytoken: e.data}, function (res) {
        console.log(infos.kefu_id + ',' + res.data.kefu_id);
        if (Number(infos.member_id) == Number(res.data.member.member_id)) {
            contentHtml(res.data);
        }
    });
    console.log("message:" + e.data);
    lianjie_is = true;
}

ws.onerror = function () {
    console.log("error");
    $(".socket-top").text("已断开，请重新进入。");
    $("#up-image").css({'pointer-events': 'none'});//设置禁止点击
}



$(function () {
    //发送商品链接
    $("#btn_goods").click(function () {
        if (lianjie_is === false) {
            layer.msg("暂不能发送");
            return;
        }
        $(".socket-top").text("正在发送...");
        var goods_id = $(this).data('id');
        var data = {
            type: 1,
            go_type: 'goods',
            id: goods_id,
            member_id: infos.member_id,
            kefu_id: infos.kefu_id,
        };
        $.post(module + 'api/getToken', data, function (res) {
            ws.send(res.data.mytoken);
        });
    });
    //发送订单链接
    $("#btn_order").click(function () {
        if (lianjie_is === false) {
            layer.msg("暂不能发送");
            return;
        }
        $(".socket-top").text("正在发送...");
        var goods_id = $(this).data('id');
        var data = {
            type: 1,
            go_type: 'order',
            id: goods_id,
            member_id: infos.member_id,
            kefu_id: infos.kefu_id,
        };
        $.post(module + 'api/getToken', data, function (res) {
            ws.send(res.data.mytoken);
        });
    });

    $("#send").click(function () {
        if (lianjie_is === false) {
            layer.msg("暂不能发送");
            return;
        }
        $(".socket-top").text("正在发送...");
        var content = $("#content").val();
        if (!content) {
            layer.msg("内容不能为空", {icon: 5});
            return;
        }
        var data = {
            type: 1,
            member_id: infos.member_id,
            kefu_id: infos.kefu_id,
            content: content,
        };
        $.post(module + 'api/getToken', data, function (res) {
            ws.send(res.data.mytoken);
        });

        $("#content").val('');

        return false;
    })

    $("#up-face").click(function (e) {
        e.stopPropagation();
        if (1 == flag) {
            showFaces();
            document.getElementById('face-box').style.display = 'block';
            flag = 2;
        } else {
            document.getElementById('face-box').style.display = 'none';
            flag = 1;
        }
    })
    $(document).click(function () {
        if (2 == flag) {
            document.getElementById('face-box').style.display = 'none';
            flag = 1;
        }
    })

    // 图片 文件上传
    layui.use(['upload', 'layer'], function () {
        var upload = layui.upload;
        var layer = layui.layer;
        // 执行实例
        var uploadInstImg = upload.render({
            elem: '#up-image' // 绑定元素
            , accept: 'images'
            , exts: 'jpg|jpeg|png|gif'
            , url: '/socket/upload/uploadImg' // 上传接口
            , done: function (res) {
                var data = {
                    type: 1,
                    member_id: infos.member_id,
                    kefu_id: infos.kefu_id,
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
    });

})
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
function contentHtml(msg, obj) {
    var content = msg.content;
    if (msg.go_type == 'goods') {
        var content = goodsHtml(content);
    } else if (msg.go_type == 'order') {
        var content = orderHtml(content);
    } else {
        var content = replaceContent(content);
    }

    if (!content) {
        layer.msg("发生错误", {icon: 2});
        return;
    }

    if (msg.type == 1) {
        var html = `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img2">
                            <img src="` + msg.member.member_avatar + `" />
                        </div>
                        <div class="contentdiv-text2">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
    } else {
        var html = `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img">
                            <i class="layui-icon">&#xe770;</i>
                        </div>
                        <div class="contentdiv-text">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
    }
    $(".socket-top").text("咨询客服");
    $("#contentul").append(html);
    $('html,body').animate({scrollTop: $(document).height()}, 1000);
}
function goodsHtml(data) {
    var goods = JSON.parse(data);
    var html = `<div class="mallzdiv-auto2">
                    <a href="` + goods.url + `" target="_blank">
                        <div class="mallzdiv-img">
                            <img src="` + goods.thecover + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name3">` + goods.goods_name + `</div>
                            <div class="color-red">单价：￥<span>` + goods.goods_price + `</span></div>
                        </div>
                    </a>
                </div>`;
    return html;
}

function orderHtml(data) {
    var order = JSON.parse(data);
    console.log(order);
    var html = `<div class="mallzdiv-auto2">
                        <div class="mallzdiv-img">
                            <img src="` + order.goods_img + `" />
                        </div>
                        <div class="mallzdiv-text2">
                            <div class="goods_name3">订单：` + order.order_no + `</div>
                            <div class="color-red">实付：￥<span>` + order.total_price + `</span></div>
                        </div>
                </div>`;
    return html;
}



getkefuChatList();
function getkefuChatList(member_id) {
    var member_id = member_id ? member_id : infos.member_id;
    $.post(module + 'api/getkefuChatList', {member_id: member_id, kefu_id: infos.kefu_id}, function (res) {
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
                        <div class="contentdiv-img2">
                            
                           <img src="/static/` + res.data.member_avatar + `" />
                        </div>
                        <div class="contentdiv-text2">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
            } else {
                if (res.data.kefu_avatar) {
                    var kefu_avatar = '<img src="/static/' + res.data.kefu_avatar + '">';
                } else {
                    var kefu_avatar = '<i class="layui-icon">&#xe770;</i>';
                }
                html += `<li class="contentdiv-li">
                    <div class="contentdiv-auto">
                        <div class="contentdiv-img">
                            
                           ` + kefu_avatar + `
                        </div>
                        <div class="contentdiv-text">
                            ` + content + `
                        </div>
                    </div>
                </li>`;
            }
        })
        $("#contentul").append(html);
        $('html,body').animate({scrollTop: $(document).height()}, 1000);
    });
}
// 展示表情数据
function showFaces() {
    var alt = getFacesIcon();
    var _html = '<ul>';
    var len = alt.length;
    for (var index = 0; index < len; index++) {
        _html += '<li title="' + alt[index] + '" onclick="checkFace(this)"><img src="/static/images/icon/face/' + index + '.gif" /></li>';
    }
    _html += '</ul>';

    document.getElementById('face-box').innerHTML = _html;
}

// 选择表情
function checkFace(obj) {
    var msg = document.getElementById('content').value;
    document.getElementById('content').value = msg + ' face' + obj.title + ' ';
    document.getElementById('content').focus();
    document.getElementById('face-box').style.display = 'none';
    flag = 1;
}