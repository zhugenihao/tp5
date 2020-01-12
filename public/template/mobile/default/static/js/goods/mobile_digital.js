var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    loop: true,
    autoplay: 2000,
    paginationClickable: true,
    //控制左右按钮
    nextEl: '.swiper-button-next', //对应左边按钮类名
    prevEl: '.swiper-button-prev', //对应右边按钮类名
    autoplayDisableOnInteraction: false, //用户操作后不停止

});

