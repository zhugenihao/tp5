$(function () {
    $(".directory-oneul li").click(function () {
        var index = $(this).index();
        $(".directory-oneul li a").removeClass('diractive');
        $(this).find('a').addClass('diractive');
        var directory1_id = $(this).data('directory1id');
        bcategoryList(directory1_id);
    });
    var directory1_id = $(".directory-oneul li").eq(0).data('directory1id');
    $(".directory-oneul li").eq(0).find('a').addClass('diractive');
    bcategoryList(directory1_id);
})

function bcategoryList(directory1_id) {
    var store_id = $("#store_id").val();
    ajaxMethods({
        url: 'store/bcategory_index/',
        type: 'get',
        data: {store_id: store_id, directory1_id: directory1_id},
        sCallback: function (data) {
            bcategoryHtml(data, store_id);
        }
    });
}
function bcategoryHtml(data, store_id) {
    $("#directory-lister li").remove()
    var html = `<li class="directory-sli">
                    <div class="directory-list">`;
    $.each(data.list, function (index, val) {
        html += ` <div class="directory-listone floatfalse">
                            <a href="` + tp5_url('store/category_index?directory2_id=' + val['directory2_id'] + '&store_id=' + store_id) + `">
                                <h3 class="directory-h3">` + val['directory2_name'] + `</h3>
                            </a>
                            <ul class="directory-listul">`;
        $.each(val['bCategory3'], function (indexer, valer) {
            html += `<li class="directory-listli">
                                    <a href="` + tp5_url('store/category_index?directory3_id=' + valer['directory3_id'] + '&store_id=' + store_id) + `">
                                        
                                        <p class="directory-title">` + valer['directory3_name'] + `</p>
                                    </a>
                                </li>`;
        });
        html += `    
                            </ul>
                        </div>`;
    });
    html += `       </div>
            </li>`;
    $("#directory-lister").prepend(html);
}

