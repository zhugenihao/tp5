function deleteWatchHistory(obj) {
    layer.confirm('确定清空么？', {
        btn: ['确认', '取消']
    }, function () {
        deleteWatchHistoryAjax(obj);
    });
}
function deleteWatchHistoryAjax(obj) {
    ajaxMethods({
        url: 'watch_history/deleteWatchHistory',
        type: 'get',
        data: {},
        sCallback: function (data) {
            if (data.types === 1) {
                layer.msg(data.prompt, {icon: 1});
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                layer.msg(data.prompt, {icon: 5});
            }
        }
    });
}