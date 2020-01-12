layui.use(['form', 'laydate'], function () {
    var laydate = layui.laydate;
    form = layui.form;
    // select下拉框选中触发事件
    form.on("select(province_id)", function (data) {
        var province_id = data.value;
        console.log(province_id);
        regionHtml(province_id, 1);
    });
    form.on("select(directory1_id)", function (data) {
        var province_id = data.value;
        directoryHtml(province_id, 1);
    });
    form.on("select(directory2_id)", function (data) {
        var province_id = data.value;
        directoryHtml(province_id, 2);
    });
});
function storeSubmit(obj) {
    var store_name = $("#store_name").val();
    var directory_big_id = $("#directory_big_id").val();
    var head_name = $("#head_name").val();
    var head_mobile = $("#head_mobile").val();
    var head_qq = $("#head_qq").val();
    var email = $("#email").val();
    var store_address = $("#store_address").val();
    var bank_name = $("#bank_name").val();
    var bank_account = $("#bank_account").val();
    var bank_branch_name = $("#bank_branch_name").val();
    var main_channel = $("#main_channel").val();
    var sales = $("#sales").val();
    var sales_quantity = $("#sales_quantity").val();
    var average_price = $("#average_price").val();
    var warehouse = $("#warehouse").val();

    if (!trim(store_name) || !trim(directory_big_id) || !trim(head_name) || !trim(head_mobile) || !trim(head_qq) || !trim(email)
            || !trim(store_address) || !trim(bank_name) || !trim(bank_account) || !trim(bank_branch_name) || !trim(main_channel)
            || !trim(sales) || !trim(sales_quantity) || !trim(average_price) || !trim(warehouse)) {

        layer.msg("缺一不可！", {icon: 2});
        return;
    }
    if (!isMobile(head_mobile)) {
        layer.msg("固定电话格式不正确！", {icon: 2});
        return;
    }
    if (!isEmail(email)) {
        layer.msg("邮箱不正确！", {icon: 2});
        return;
    }
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在提交中...');
    var application_type = $("#application_type").val();
    ajaxForm({
        url: 'seller/seller_store/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if(application_type=='1'){
                href_url('seller/seller_audit');
            }else{
                href_url('seller/seller_qualification');
            }
        }
    });
}
function regionHtml(id, type) {
    ajaxMethods({
        url: 'onethink_district/otDisList/',
        type: 'get',
        data: {upid: id},
        sCallback: function (data) {
            if (type === 1) {
                $("#city_id option").remove();
                $("#county_id option").remove();
                var html = '<option value="0">请选择市级</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
                $("#city_id").prepend(html);
            } else if (type === 2) {
                $("#county_id option").remove();
                var html = '<option value="0">请选择县级</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
                $("#county_id").prepend(html);
            }
            form.render();//注意渲染页面表单，否则不显示数据
        }
    });
}
function directoryHtml(directory_id, type) {
    ajaxMethods({
        url: 'directory/getDirectory/',
        type: 'get',
        data: {pid: directory_id},
        sCallback: function (data) {
            if (type === 1) {
                $("#directory2_id option").remove();
                $("#directory3_id option").remove();
                var html = '<option value="0">请选择二级类目</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['title'] + '</option>';
                })
                $("#directory2_id").prepend(html);
            } else if (type === 2) {
                $("#directory3_id option").remove();
                var html = '<option value="0">请选择三级类目</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['title'] + '</option>';
                })
                $("#directory3_id").prepend(html);
            }
            form.render();//注意渲染页面表单，否则不显示数据
        }
    });
}
function addBusCategory(obj) {
    var directory1_id = $("#directory1_id").val();
    var directory2_id = $("#directory2_id").val();
    var directory3_id = $("#directory3_id").val();
    ajaxMethods({
        url: 'business_category/addBusCategory/',
        type: 'post',
        data: {directory1_id: directory1_id, directory2_id: directory2_id, directory3_id: directory3_id},
        sCallback: function (data) {
            if (data.types === 1) {
                businessCategoryList(obj);
            } else {
                layer.msg(data.prompt, {icon: 2});
            }
        }
    });
}
businessCategoryList();
function businessCategoryList(obj) {
    ajaxMethods({
        url: 'business_category/businessCategoryList/',
        type: 'post',
        data: {},
        sCallback: function (data) {
            $(".buscategory_list").remove();
            var html = '';
            $.each(data, function (index, val) {
                html += `<tr class="buscategory_list">
                            <td>` + val['directory1_name'] + `</td>
                            <td>` + val['directory2_name'] + `</td>
                            <td>` + val['directory3_name'] + `</td>
                            <td><a href="javascript:;" onclick="delbuscategory(this)" data-id="` + val['id'] + `">删除</a></td>
                        </tr>`;
            })
            $("#directory_table").append(html);
        }
    });
}
function delbuscategory(obj) {
    var buscategory_id = $(obj).data('id');
    ajaxMethods({
        url: 'business_category/delbuscategory/',
        type: 'post',
        data: {buscategory_id: buscategory_id},
        sCallback: function (data) {
            if (data.types === 1) {
                businessCategoryList(obj);
            } else {
                layer.msg(data.prompt, {icon: 2});
            }
        }
    });
}