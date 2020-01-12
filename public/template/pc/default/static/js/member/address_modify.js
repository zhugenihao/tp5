layui.use(['form', 'layedit', 'laydate'], function () {
    form = layui.form, layer = layui.layer;
    // select下拉框选中触发事件
    form.on("select(province)", function (data) {
        var province_id = data.value;
        console.log(province_id);
        addressHtml(province_id, 1);
    });
    form.on("select(city)", function (data) {
        var city_id = data.value;
        addressHtml(city_id, 2);
    });
    form.on("select(county)", function (data) {
        var county_id = data.value;
        addressHtml(county_id, 3);
    });
});
$(function(){
    $("#address_sign li").click(function () {
        var sign_id = $(this).data('id');
        $(".sign_id").val(sign_id);
        $("#address_sign li").removeClass('sign_active');
        $(this).addClass('sign_active');
    })
    $("#del_sign").click(function(){
        var is_show = $(this).attr('show');
        if(is_show==1){
            $(".delsigns").show();
            $(this).attr('show',2);
        }else{
            $(".delsigns").hide();
            $(this).attr('show',1);
        }
    })
    $(".delsigns").click(function () {
        var id = $(this).data('id');
        layer.confirm('你确定要删除么？', {
            time: 20000, //20s后自动关闭
            btn: ['确定', '取消']
        }, function () {
            ajaxDelSign(id);
        });
    });
    $("#add_sign").click(function () {
        layer.prompt({title: '添加地址标志', formType: 3}, function (sign_name, index) {
            layer.close(index);
            submitSign(sign_name);
        });
    });
})
function ajaxDelSign(id) {
    ajaxMethods({
        url: 'member/delSign/',
        type: 'get',
        data: {id: id},
        sCallback: function (data) {
            console.log(data);
            if (data.types === 1) {
                layer.msg(data.prompt, {'icon': 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {'icon': 5});
            }
        }
    });
}
function addressHtml(id, type) {
    ajaxMethods({
        url: 'onethink_district/otDisList/',
        type: 'get',
        data: {upid: id},
        sCallback: function (data) {
            if (type === 1) {
                $("#city option").remove();
                $("#county option").remove();
                $("#town option").remove();
                var html = '<option value="0">请选择市级</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
                $("#city").prepend(html);
            } else if (type === 2) {
                $("#county option").remove();
                $("#town option").remove();
                var html = '<option value="0">请选择县级</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
                $("#county").prepend(html);
            } else if (type === 3) {
                $("#town option").remove();
                var html = '<option value="0">请选择镇级</option>';
                $.each(data, function (index, val) {
                    html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                })
                $("#town").prepend(html);
            }
            form.render();//注意渲染页面表单，否则不显示数据
        }
    });
}
function modifyAddress(obj) {
    var ads_name = $("#ads_name").val();
    var ads_mobile = $("#ads_mobile").val();
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var detaddress = $("#detaddress").val();
    console.log(province);
    if (!trim(ads_name)) {
        layer.msg("收货人不能为空！", {'icon': 5});
        return;
    }
    if (!isMobile(ads_mobile)) {
        layer.msg("联系方式不正确！", {'icon': 5});
        return;
    }
    if (Number(province) <= 0) {
        layer.msg("省份不能为空！", {'icon': 5});
        return;
    }
    if (Number(city) <= 0) {
        layer.msg("市级不能为空！", {'icon': 5});
        return;
    }
    if (Number(county) <= 0) {
        layer.msg("县级不能为空！", {'icon': 5});
        return;
    }
    if (!trim(detaddress)) {
        layer.msg("详细地址不能为空！", {'icon': 5});
        return;
    }
    layer.confirm('你确定要修改么？', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    }, function () {
        ajaxModifyAddress(obj);
    });
}
function ajaxModifyAddress(obj) {
    ajaxForm({
        url: 'Address/modifyAddress/',
        type: 'post',
        formName: 'formsubmit',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {'icon': 1});
                setTimeout(function () {
                    href_url('member/member_address?type=7');
                }, 1000);
            } else {
                layer.msg(data.prompt, {'icon': 5});
            }
        }
    });
}
function submitSign(sign_name) {
    ajaxMethods({
        url: 'member/addSign/',
        data: {'sign_name': sign_name},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {'icon': 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {'icon': 5});
            }
        }
    });
}