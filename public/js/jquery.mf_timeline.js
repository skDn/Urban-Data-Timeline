//function animateEvenets() {
//    $(window).on('scroll', function () {
//        $timeline_block.each(function () {
//            $timeline_elements.each(function () {
//                if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.9 && $(this).hasClass('is-hidden')) {
//                    $(this).removeClass('is-hidden').addClass('animated zoomIn');
//                }
//            });
//        });
//    });
//}
$(document).ready(function () {
    // $('.timeline .timeline_nav').stickyfloat({duration:400});
    $('html, body').animate({scrollTop: ($('#' + googleChart).offset().top) - 150}, 1500);


    //hide timeline blocks which are outside the viewport
    //function makeNonVisibleEventsHidden() {
    //    $timeline_block.each(function () {
    //        $timeline_elements.each(function () {
    //            if ($(this).offset().top > $(window).scrollTop() + $(window).height() * 0.75) {
    //                if (!$(this).hasClass('is-hidden')) {
    //                    $(this).addClass('is-hidden');
    //                }
    //                if (!$(this).hasClass('loading')) {
    //                    console.log('here');
    //                }
    //
    //            }
    //        });
    //    });
    //}

    //makeNonVisibleEventsHidden();

    $('document').on('event:success', function () {
        console.log('good event');
    });

    var $timeline_nav = $('.timeline_nav');
    var $infoBox = $('.infoBox');
    //var $timeline = $('.timeline');
    var $timeline = $('#' + googleChart);
    var offset = 150;

    //$timeline_nav.addClass('is-hidden');
    //$infoBox.addClass('is-hidden');
    //animateEvenets();
    //on scolling, show/animate timeline blocks when enter the viewport
    $(window).on('scroll', function () {


        if ($timeline.offset().top <= $(window).scrollTop() + offset) {
            showHiddenWithAnimation($timeline_nav, 'fadeInLeft');
            showHiddenWithAnimation($infoBox, 'fadeInDown');
        }
        else {
            removeVisibleWithAnimation($timeline_nav, 'fadeOutLeft', 'fadeInLeft');
            removeVisibleWithAnimation($infoBox, 'fadeOutUp', 'fadeInDown');
        }


    });

    $(".timeline_nav li").click(function () {
        $('html, body').animate({scrollTop: ($('#' + $(this).first().text().trim()).offset().top) - 140}, 500);
    });

    function showHiddenWithAnimation(element, animation) {
        if (element.hasClass('is-hidden')) {
            element.removeClass('is-hidden').addClass('animated ' + animation);
        }
        if (element.hasClass('animated')) {

            var classList = element.attr('class').split(/\s+/);

            for (var i = 0; i < classList.length; i++) {
                if (classList[i] === 'animated') {
                    element.removeClass(classList[i]);
                    element.removeClass(classList[i + 1]);
                    break;
                }
            }
            element.addClass('animated ' + animation);
        }
    }

    function removeVisibleWithAnimation(element, newAnimation, oldAnimation) {
        if (!element.hasClass('is-hidden')) {
            element.removeClass(oldAnimation);
            element.addClass(newAnimation);
            //element.addClass('is-hidden');
        }
    }


    // check if in comparison view
    var tlFstSelector = $('#timelineFirst');
    var tlSecSelector = $('#timelineSecond');
    var sectionId;
    var corSection;

    if (tlFstSelector.length && tlSecSelector.length) {
        tlFstSelector.find('.section').each(function () {
            //console.log($(this).height())
            sectionId = $(this).attr('id');
            corSection = tlSecSelector.find('#' + sectionId);
            if ($(this).height() > corSection.height()) {
                corSection.height($(this).height());
            }
            if ($(this).height() < corSection.height()) {
                $(this).height(corSection.height());
            }
            //console.log($(this).attr('id'))
        });
    }


    $(document).ajaxComplete(function (event, xhr, settings) {
        if (settings.url.indexOf('infinite') > -1) {
            $('.timeline .section').each(function () {
                $(this).afterScroll(function () {
                    // After we have scolled past the top
                    var year = $(this).attr('id');
                    $('ol.timeline_nav li').removeClass('current');
                    $('ol.timeline_nav li#menu_year_' + year).addClass('current');
                });
            });
            //makeNonVisibleEventsHidden();
            //animateEvenets();
        }
    });
});