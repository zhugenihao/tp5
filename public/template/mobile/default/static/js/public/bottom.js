$(function () {
    var types = getUrlParms('type');
    var types = types ? types : 'home';
    $("#bottom-ul li").removeClass('botm-active');
    $("#"+types).addClass('botm-active');
})