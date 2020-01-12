$(function () {
    var store_id = $("#store_id").val();
    console.log(store_id);
    var storeid_length = $(".storeid_a").length;
    for (var i = 0; i < storeid_length; i++) {
        var href = $(".storeid_a").eq(i).attr('href');
        $(".storeid_a").eq(i).attr('href', href + "?store_id=" + store_id);
    }
})