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

//window.onscroll = function (oEvent) {
//    var mydivpos = document.getElementById("page").offsetTop;
//    var scrollPos = document.getElementsByTagName("body")[0].scrollTop;
//
//    if(scrollPos >= mydivpos)
//        document.getElementById("infoBox").className = "";
//    else
//        document.getElementById("infoBox").className = "hidden";
//};