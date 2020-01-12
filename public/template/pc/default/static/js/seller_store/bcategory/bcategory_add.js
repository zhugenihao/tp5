$(function () {
    $("#directory1_id").on('change', function () {
        var directory_id = $(this).val();
        directoryHtml(directory_id, 1);
    })
    $("#directory2_id").on('change', function () {
        var directory_id = $(this).val();
        directoryHtml(directory_id, 2);
    })
})
function addBcategory(obj) {
    var directory1_id = $("#directory1_id").val();
    var directory2_id = $("#directory2_id").val();
    var directory3_id = $("#directory3_id").val();
    if (!trim(directory1_id) && !trim(directory2_id) && !trim(directory3_id)) {
        layer.msg("三个类目缺一不可！", {icon: 5});
        return;
    }
    ajaxForm({
        url: 'seller_store.business_category/bcategory_add/',
        type: 'post',
        formName: 'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    returnOnPage();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}
function directoryHtml(directory_id, type) {
    if (Number(directory_id) < 1) {
        return;
    }
    ajaxMethods({
        url: 'directory/getDirectory/',
        type: 'get',
        data: {pid: directory_id},
        sCallback: function (data) {

            var directory3html = '<option value="0">请选择三级类目</option>';
            if (type === 1) {
                $("#directory2_id option").remove();
                $("#directory3_id option").remove();
                var directory2html = '<option value="0">请选择二级类目</option>';
                $.each(data, function (index, val) {
                    directory2html += '<option value="' + val['id'] + '">' + val['title'] + '</option>';
                })
            } else if (type === 2) {
                $("#directory3_id option").remove();
                $.each(data, function (index, val) {
                    directory3html += '<option value="' + val['id'] + '">' + val['title'] + '</option>';
                })
            }
            $("#directory2_id").prepend(directory2html);
            $("#directory3_id").prepend(directory3html);
        }
    });
}