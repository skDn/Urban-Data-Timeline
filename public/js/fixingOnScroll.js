/**
 * Created by skDn on 02/12/2015.
 */
/*
$(function () {
    var elem = $('#infoBox'),
        elemTop = elem.offset().top;
    $(window).scroll(function () {
        elem.toggleClass('navbar-fixed-top', $(window).scrollTop() > elemTop);
    }).scroll();
});
/*
var navOffsetTop = $('#infoBox').offset().top;

$(window).scroll(function() {
    var currentScroll = $(window).scrollTop();
    if (currentScroll >= navOffsetTop) {
        $(‘#infoBox').css({
            position: 'fixed',
            top: '0',

        });
    } else {
        $('#infoBox').css({
            position: 'static'
        });
    }
});
*/