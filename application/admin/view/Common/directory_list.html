<script type="text/javascript">
    //类目选择
    $(function () {
        $("#directory1_id").on('change', function () {
            var directory_id = $(this).val();
            directoryHtml(directory_id, 2);
        })
        $("#directory2_id").on('change', function () {
            var directory_id = $(this).val();
            directoryHtml(directory_id, 3);
        })

        var directory1_show = $("#directory1_show").val();
        var directory2_show = $("#directory2_show").val();
        var directory3_show = $("#directory3_show").val();
        console.log(directory1_show+","+directory2_show+","+directory3_show);
        directoryHtml("dir1", 1, directory1_show);
        if (directory2_show != undefined) {
            setTimeout(function () {
                directoryHtml(directory1_show, 2, directory2_show);
            }, 200);
        }
        if (directory3_show != undefined) {
            setTimeout(function () {
                directoryHtml(directory2_show, 3, directory3_show);
            }, 400);
        }
    })
    function directoryHtml(directory_id, type, show_id) {
        if (Number(directory_id) <= 0) {
            return false;
        }
        console.log(directory_id);
        if (directory_id == 'dir1') {
            var directory_id = 0;
        }
        ajaxMethods({
            url: 'directory/getDirectory/',
            type: 'get',
            data: {pid: directory_id},
            sCallback: function (data) {
                var html1 = '<option value="0">请选择一级类目</option>';
                var html2 = '<option value="0">请选择二级类目</option>';
                var html3 = '<option value="0">请选择三级类目</option>';
                if (type === 1) {
                    $("#directory1_id option").remove();
                    $("#directory2_id option").remove();
                    $("#directory3_id option").remove();

                    $.each(data, function (index, val) {
                        var show_text = "";
                        if (show_id == val['id']) {
                            var show_text = "selected ";
                        }
                        html1 += '<option value="' + val['id'] + '" ' + show_text + '>' + val['title'] + '</option>';
                    })
                    $("#directory1_id").prepend(html1);
                    $("#directory2_id").prepend(html2);
                } else if (type === 2) {
                    $("#directory2_id option").remove();
                    $("#directory3_id option").remove();

                    $.each(data, function (index, val) {
                        var show_text = "";
                        if (show_id == val['id']) {
                            var show_text = "selected ";
                        }
                        html2 += '<option value="' + val['id'] + '" ' + show_text + '>' + val['title'] + '</option>';
                    })
                    $("#directory2_id").prepend(html2);
                } else if (type === 3) {
                    $("#directory3_id option").remove();

                    $.each(data, function (index, val) {
                        var show_text = "";
                        if (show_id == val['id']) {
                            var show_text = "selected ";
                        }
                        html3 += '<option value="' + val['id'] + '" ' + show_text + '>' + val['title'] + '</option>';
                    })
                }
                $("#directory3_id").prepend(html3);
            }
        });
    }
</script>