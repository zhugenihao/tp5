layui.use(['form', 'laydate'], function () {
    var laydate = layui.laydate;
    form = layui.form;
    //常规用法
    laydate.render({
        elem: '#effective_start_time'
    });
    laydate.render({
        elem: '#effective_end_time'
    });
    // select下拉框选中触发事件
    form.on("select(province_id)", function (data) {
        var province_id = data.value;
        console.log(province_id);
        regionHtml(province_id, 1);
    });
    form.on("select(city_id)", function (data) {
        var city_id = data.value;
        regionHtml(city_id, 2);
    });
    form.on('checkbox(long_time)', function (obj) {
        //遍历父级tr，取第一个，然后查找第二个td，取值
        var check = obj.elem.checked;
        $("#div_end_time input").remove();
        if (check === true) {
            $("#div_end_time").prepend('<input type="text" value="长期" name="effective_end_time" class="loginli-input2"/>');
        } else {
            $("#div_end_time").prepend('<input type="text" value="" name="effective_end_time" class="loginli-input2" id="effective_end_time"/>');
            laydate.render({
                elem: '#effective_end_time'
            });
        }
    });
});
function companySubmit(obj) {
    var company_name = $("#company_name").val();
    var company_url = $("#company_url").val();
    var province_id = $("#province_id").val();
    var city_id = $("#city_id").val();
    var county_id = $("#county_id").val();
    var detaddress = $("#detaddress").val();
    var fixed_telephone = $("#fixed_telephone").val();
    var email = $("#email").val();
    var fax = $("#fax").val();
    var thezipcode = $("#thezipcode").val();
    var registered_capital = $("#registered_capital").val();
    var credit_code = $("#credit_code").val();
    var legal_rep_name = $("#legal_rep_name").val();
    var effective_start_time = $("#effective_start_time").val();
    var scope_business = $("#scope_business").val();
    var taxpayers_type = $("#taxpayers_type").val();
    var taxtypetaxcode = $("#taxtypetaxcode").val();

    if (!trim(company_name) || !trim(company_url) || !trim(province_id) || !trim(city_id) || !trim(county_id) || !trim(detaddress)
            || !trim(fixed_telephone) || !trim(email) || !trim(fax) || !trim(thezipcode) || !trim(registered_capital) || !trim(credit_code)
            || !trim(legal_rep_name) || !trim(effective_start_time) || !trim(scope_business) || !trim(taxpayers_type) || !trim(taxtypetaxcode)) {

        layer.msg("缺一不可！", {icon: 2});
        return;
    }
    if (!isPhone(fixed_telephone)) {
        layer.msg("固定电话格式不正确！", {icon: 2});
        return;
    }
    if (!isEmail(email)) {
        layer.msg("邮箱不正确！", {icon: 2});
        return;
    }
    $(obj).css({'pointer-events': 'none'});//设置禁止点击
    $(obj).val('正在提交中...');
    ajaxForm({
        url: 'seller/seller_company/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            href_url('seller/seller_store?application_type='+2);
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