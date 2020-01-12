$(function () {

    $("#clickphoto").click(function () {
        $("#idphoto").click();
    });
    $("#idphoto").on('change', function () {
        layer.load(2);
        ajaxForm({
            url: 'member/account_settings/',
            type: 'post',
            formName: 'formsubmit',
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
    });
})