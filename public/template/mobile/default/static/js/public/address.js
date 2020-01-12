$(function () {
    $("#addressbtn").click(function(){
        $(".all-div").show();
    });
    $("#addrehide").click(function(){
        $(".all-div").hide();
    });
    $(".allautoas-ul").on('click', 'li', function () {
        var text = $(this).text();
        var id = $(this).data('id');
        $(".allautoas-title .ada-active").text(text);
        var index = $(".allautoas-title .ada-active").index();
        var index2 = index + 1;
        $(".allautoas-title div").removeClass('ada-active');
        $(".allautoas-title div").eq(index2).addClass('ada-active');
        $(".allautoas-title div").eq(index2).text(text);
        $(".allautoas-title div").eq(index2).attr('data-id', id);
        
        $("#addresstext span").eq(index).text(text);
        $(".addressid input").eq(index).val(id);
        if(index===3){
            $(".all-div").hide();
        }
        addressHtml(id);

    });
    $(".allautoas-title div").click(function () {
        var id = $(this).data('id');
        if (!id && id!==0) {
            return false;
        }
        $(".allautoas-title div").removeClass('ada-active');
        $(this).addClass('ada-active');
        addressHtml(id);
    });
})
function addressHtml(id) {
    ajaxMethods({
        url: 'onethink_district/otDisList/',
        type: 'get',
        data: {upid: id},
        sCallback: function (data) {
            var html = '';
            $(".allautoas-ul li").remove();
            $.each(data, function (index, val) {
                html += '<li data-id="' + val['id'] + '">' + val['name'] + '</li>';
            })
            $(".allautoas-ul").prepend(html);
        }
    });

}