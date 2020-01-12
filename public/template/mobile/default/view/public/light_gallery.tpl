
<link rel="stylesheet" type="text/css" href="__STATIC__/plugin/lightGallery/css/lightGallery.css" />
<script type="text/javascript" src="__STATIC__/plugin/lightGallery/js/lightGallery.js"></script>
<script type="text/javascript">

    function lightGallery(obj) {
        var children = $(obj).children();
        children.one('click');
        $(obj).lightGallery({
            loop: true,
            auto: true,
            lang: {allPhotos: '一共有图片'},
            speed: 300,
            pause: 3000,
        });
    }
    $(function () {
        var lightGallery = '#lightGallery';
        $(document).on('click', lightGallery, function () {
            var indexer = $(".indexer").val();
//            console.log(indexer);

            $(this).lightGallery({
                loop: true,
                auto: true,
                counter: true,
                lang: {allPhotos: '一共有图片'},
                speed: 300,
                pause: 3000,
                indexer: indexer,
                clickOnMultipleNested:true
            })
        })
        var children = lightGallery+' div,'+lightGallery+ ' li,'+lightGallery+ ' span,'+lightGallery+ ' img';
        $(document).on('click', children, function () {
            $(".indexer").remove();
            var index = $(this).index();
            var html = '<input type="hidden" value="' + index + '" class="indexer" />';
            $("body").append(html);
        })


    })

</script>