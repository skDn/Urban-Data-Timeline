$(document).ready(function () {
    // $('.timeline .timeline_nav').stickyfloat({duration:400});

    $('.timeline .section').each(function () {
        $(this).afterScroll(function () {
            // After we have scolled past the top
            var year = $(this).attr('id');
            $('ol.timeline_nav li').removeClass('current');
            $('ol.timeline_nav li#menu_year_' + year).addClass('current');
        });
    });

    var $timeline_block = $('.section');
    var $timeline_elements = $('.event');

    //hide timeline blocks which are outside the viewport
    $timeline_block.each(function () {
        $timeline_elements.each(function () {
            if ($(this).offset().top > $(window).scrollTop() + $(window).height() * 0.75) {
                $(this).addClass('is-hidden');
            }
        });
    });

    //on scolling, show/animate timeline blocks when enter the viewport
    $(window).on('scroll', function () {
        $timeline_block.each(function () {
            $timeline_elements.each(function () {
                if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.75 && $(this).hasClass('is-hidden')) {
                    $(this).removeClass('is-hidden').addClass('animated zoomIn');
                }
            });
        });
    });

    $(".timeline_nav li").click(function () {
        $('html, body').animate({scrollTop: ($('#' + $(this).first().text().trim()).offset().top)}, 500);
    });

});
$(function () { // document ready
    fixElement('.timeline_nav');
});

function fixElement(elementClass) {
    if (!!$(elementClass).offset()) { // make sure ".sticky" element exists

        var stickyTop = $(elementClass).offset().top; // returns number

        $(window).scroll(function () { // scroll event

            var windowTop = $(window).scrollTop(); // returns number

            if (stickyTop < windowTop) {
                $(elementClass).css({position: 'fixed', top: 140});
                if (!$('#infoBox').hasClass('navbar-fixed-top')) {
                    $('#infoBox').toggleClass('navbar-fixed-top');
                    $('#infoBox').toggleClass('hidden');
                }
                //fixBootstrapNav('#infoBox');
            }
            else {
                $(elementClass).css('position', 'absolute');
                $(elementClass).css('top', '10px');
                //fixBootstrapNav('#infoBox');
                if ($('#infoBox').hasClass('navbar-fixed-top')) {
                    $('#infoBox').removeClass('navbar-fixed-top');
                    $('#infoBox').addClass('hidden');
                    console.log('removed');
                }
            }

        });

    }
}

function fixBootstrapNav(elementClass) {
    if (!!$(elementClass).offset()) { // make sure ".sticky" element exists

        var stickyTop = $(elementClass).offset().top; // returns number

        $(window).scroll(function () { // scroll event

            var windowTop = $(window).scrollTop(); // returns number

            if (stickyTop < windowTop) {
                if (!$(elementClass).hasClass('navbar-fixed-top')) {
                    $(elementClass).toggleClass('navbar-fixed-top');
                    $(elementClass).toggleClass('hidden');
                }
            }
            else {
                if ($(elementClass).hasClass('navbar-fixed-top')) {
                    $(elementClass).removeClass('navbar-fixed-top');
                    $(elementClass).addClass('hidden');
                    console.log('removed');
                }
            }

        });

    }
}