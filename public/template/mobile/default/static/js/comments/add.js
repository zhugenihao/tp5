$(function () {
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;
    });
    $("#comaddimg img").click(function () {
        var src1 = $("#star-simg1").val();
        var src2 = $("#star-simg2").val();
        var index = $(this).index();
        var score = $(this).attr('score');
        var name = $(this).attr('name');
        var length = $("#comaddimg img").length;
        $("#comaddimg img").attr('src', src1);
        for (var i = 0; i <= index; i++) {
            $("#comaddimg img").eq(i).attr('src', src2);
        }
        $("#scorespan").text(score + "分（" + name + "）");
        $("#score").val(score);
    })
});

function comimgFile(obj) {
    $("#comimg-file").click();
}
function imgFileas(obj) {
    var clcomimgLength = $(".clcomimg").length;
    if (clcomimgLength >= 5) {
        layer.msg('只能上传5张图片', function () {});
        return false;
    }
    layer.load(1);
    ajaxForm({
        url: 'comments/imgFileas/',
        type: 'post',
        formName: 'formfileas',
        sCallback: function (data) {
            if (data.types === 1) {
                $(".comimg-in").append('<input type="hidden" value="' + data.content + '" name="comimg[]" class="clcomimg"/>');
                var imgHtml = `<li class="comadd-imgli">
                                <img src="` + files_url(data.content) + `"/>
                            </li>`;
                $(".comadd-imgul").append(imgHtml);
            } else {
                layer.msg(data.prompt, function () {});
            }
            layer.closeAll('loading');

        }
    });
}
function commentsAdd(obj) {
    var texts = $(".comadd-tares").val();
    if (!trim(texts)) {
        layer.msg('内容不能为空！', function () {});
        return false;
    }
    layer.msg('你确定要发布么？', {
        time: 0 //不自动关闭
        , btn: ['确认', '取消']
        , yes: function (index) {
            layer.close(index);
            commentsAddAjax(obj);
        }
    });
}
function commentsAddAjax(obj) {
    $(obj).css({'pointer-events': 'none'})
    ajaxForm({
        url: 'comments/commentsAdd/',
        type: 'post',
        formName: 'comments-add',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt);
                setTimeout(function () {
                    history.back();
                    returnOnPageReload();
                }, 1000);
            } else {
                layer.msg(data.prompt, function () {});
            }
            setTimeout(function () {
                $(obj).css({'pointer-events': 'auto'})
            }, 2000);
        }
    });
}
