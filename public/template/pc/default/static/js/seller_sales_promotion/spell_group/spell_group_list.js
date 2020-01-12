
function delSecondskill(obj) {
    var spellgroup_id = $(obj).data('spellgroupid');
    var spellgroupid_str = spellgroup_id ? spellgroup_id : getChecked();
    if(!trim(spellgroupid_str)){
        layer.msg("您未选择！", {icon: 5});
        return;
    }
    layer.confirm('确定要删除么？', {
        btn: ['确认', '取消']
    }, function () {
        ajaxMethods({
            url: 'seller_sales_promotion.spell_group/delSpellGroup/',
            type: 'post',
            data: {spellgroupid_str: spellgroupid_str},
            sCallback: function (data) {
                if (data.types === 1) {
                    layer.msg(data.prompt, {icon: 1});
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                } else {
                    layer.msg(data.prompt, {icon: 5});
                }
            }
        });
    });

}