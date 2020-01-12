<script charset="utf-8" src="__STATIC__/plugin/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="__STATIC__/plugin/kindeditor/lang/zh_CN.js"></script>
<script>
    function getKindEditor(selector) {
        KindEditor.ready(function (K) {
            window.editor = K.create(selector, {
                afterBlur: function () {
                    this.sync();
                }
            });
        });
    }

</script>