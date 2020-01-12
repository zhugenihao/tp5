$(function () {
    $(".directory-oneul li").click(function () {
        var index = $(this).index();
        $(".directory-oneul li a").removeClass('diractive');
        $(this).find('a').addClass('diractive');
        var dir_id = $(this).data('dirid');
        directoryPider(dir_id);
    });
    var dirId = $(".directory-oneul li").eq(0).data('dirid');
    $(".directory-oneul li").eq(0).find('a').addClass('diractive');
    directoryPider(dirId);
})

function directoryPider(dir_id) {
    ajaxMethods({
        url: 'directory/directoryPider/',
        type: 'get',
        data: {dir_id: dir_id},
        sCallback: function (data) {
            directoryPiderHtml(data);
        }
    });
}
function directoryPiderHtml(data) {
    $("#directory-lister li").remove();
    var advert = '';
    if (data['advert']['dire'] != '') {
        var advert = '<a href="'+data['advert']['adv_link']+'"><img src="' + files_url(data['advert']['dire']) + '"/></a>';
    }
    var html = `<li class="directory-sli">
                    <div class="directory-guanggao">
                        ` + advert + `
                    </div>
                    <div class="directory-list">`;
    $.each(data.directory_list, function (index, val) {
        html += ` <div class="directory-listone floatfalse">
                            <a href="`+tp5_url('goods/goods_all?dir_id='+val['id']+'&typeclassif=classification')+`">
                                <h3 class="directory-h3">` + val['alias'] + `</h3>
                            </a>
                            <ul class="directory-listul">`;
        $.each(val['directory_er'], function (indexer, valer) {
            html += `<li class="directory-listli">
                                    <a href="`+tp5_url('goods/goods_all?dir_id='+valer['id']+'&typeclassif=classification')+`">
                                        <p class="directory-imgs">
                                            <img src="` + weburl + valer['images'] + `"/>
                                        </p>
                                        <p class="directory-title">` + valer['alias'] + `</p>
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

