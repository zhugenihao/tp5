function detailsComplaints(obj) {
    ajaxForm({
        url: 'seller_after_sales.complaints/complaints_details/',
        type: 'post',
        formName:'submitfrom',
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    closeRefresh();
                }, 500);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}