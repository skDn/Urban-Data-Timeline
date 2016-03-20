/**
 * code that works with the timeline
 */
$(document).ready(function () {
    // $('.timeline .timeline_nav').stickyfloat({duration:400});
    $('html, body').animate({scrollTop: ($('#' + googleChart).offset().top) - 150}, 1500);

    $('document').on('event:success', function () {
        console.log('good event');
    });

    var $timeline_nav = $('.timeline_nav');
    var $infoBox = $('.infoBox');
    var $timeline = $('#' + googleChart);
    var offset = 150;

    /**
     * on scroll hide or show navigation bar and information box but only after
     * specific location is passed
     */
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


    function changeCurrentInNavBar() {
        $('.timeline .section').each(function () {
            $(this).afterScroll(function () {
                // After we have scolled past the top
                var year = $(this).attr('id');
                $('ol.timeline_nav li').removeClass('current');
                $('ol.timeline_nav li#menu_year_' + year).addClass('current');
            });
        });
    }
    changeCurrentInNavBar();
    /**
     * change current section on every completed request
     */
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (settings.url.indexOf('infinite') > -1) {
            changeCurrentInNavBar();
            //makeNonVisibleEventsHidden();
            //animateEvenets();
        }
    });
});