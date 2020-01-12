$(function () {
    var i;
    var wuliucont_li = $(".wuliucont-li");
    for (i in wuliucont_li) {
      var height = wuliucont_li.eq(i).height();
      wuliucont_li.eq(i).find(".wuliucont-su").height(height);
    }
})