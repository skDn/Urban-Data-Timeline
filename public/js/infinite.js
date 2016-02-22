/**
 * Created by skDn on 16/02/2016.
 */
(function ($) {
    $.fn.afterScrollPast = function (after_top, before_top, after_bottom, before_bottom) {
        var $win = $(window)
        after_top = after_top || $.noop
        before_top = before_top || $.noop
        after_bottom = after_bottom || $.noop
        before_bottom = before_bottom || $.noop

        return this.each(function () {
            var t = this,
                self = $(t),
                elOffset = self.offset(),
                elBottomPos = self.outerHeight() + elOffset.top,
                elTopPos = elOffset.top,
                scrolled = false
            /* make it scrolled && $win.scrollTop() + $win.height()
             if want to change when element is comming from bottom of screen*/
            $win.scroll(function () {
                /* Top of element */
                // haven't scrolled past yet
                if (!scrolled && $win.scrollTop() + $win.height()+1000 >= elTopPos) {
                    after_top.apply(t)
                    scrolled = true
                }
                // have scrolled past yet
                else if (scrolled && $win.scrollTop() + $win.height()+1000 < elTopPos) {
                    before_top.apply(t)
                    scrolled = false
                }


                /* Bottom of element*/
                // haven't scrolled past yet
                if (!scrolled && $win.scrollTop() + $win.height()+1000 >= elBottomPos) {
                    after_bottom.apply(t)
                    scrolled = true
                }
                // have scrolled past yet
                else if (scrolled && $win.scrollTop() + $win.height()+1000 < elBottomPos) {
                    before_bottom.apply(t)
                    scrolled = false
                }
            }).scroll()
        })
    }
})(jQuery);
const $loading = $('#loading');

const eventStart = '<li class="event animated zoomIn">' +
    '<i class="event_pointer"></i>' +

    '<div class="event_container">';
const eventEnd = '</li>' + '</div>';

$(function () {
    var prevSection;
    var listOfFilledSections = [];
    $loading.hide();
    $('.timeline .section').each(function () {
        $(this).afterScrollPast(function () {
            // After we have scolled past the top
            var sectionID = $(this).attr('id');
            if (prevSection !== sectionID && $.inArray(sectionID, listOfFilledSections) === -1) {
                listOfFilledSections.push(sectionID);
                /// substitude with ajax calls;
                ajaxCall(sectionID);

            }
            prevSection = sectionID;
        });
    });


    function getInputs(id) {
        var dict = {};

        $("form").find(':input').each(function () {
            if ($(this).attr('name') === 'date') {
                dict['date'] = getDate();
            }
            else {
                dict[$(this).attr('name')] = $(this).val()
            }
        });
        dict['sectionID'] = id;
        return dict;
    }

    function ajaxCall(id) {
        $loading.show();
        var marker;
        $.ajax({
            url: '/infinite/single',
            method: 'get',
            data: getInputs(id),
            dataType: 'json',
            success: function (data) {
                //$loading.hide();
                if (data != '') {
                    marker = $('#' + id + ' ol.events');
                    hideLoadingEvenetsFromSection(marker);
                    getEventsHtmlRepresentation(data, marker);
                } else {
                    $loading.hide();
                }
            }
        });
    }

    function hideLoadingEvenetsFromSection(marker) {
        marker.children(".loading").removeClass('zoomIn').addClass('zoomOut').hide();
    }

    function getEventsHtmlRepresentation(data, objectToAppend) {
        for (var event in data) {
            if (data[event].class === 'tweet') {
                for (var i = 0; i < 10; i++)
                    objectToAppend.append(getHtmlForTweet(data[event]));
            }
        }
    }

    function getHtmlForTweet(event) {
        return eventStart +
            '<div class="event_title">' +
            '<i class="fa fa-twitter fa-2x profile_image twitter"> </i>' +

            '<h3>' + event['screen_name'] + '</h3>' +
            '<span class="subtitle">@' + event.screen_name + '</span>' +
            '</div>' +
            '   <!-- end of event title -->' +
            '<div class="event_content">' +
            '<p>Count:' + event.count + '</p>' +
            '</div>' +
            '  <!-- event timestamp -->' +
            '<span class="next_to_title"><i' +
            'class="fa fa-clock-o fa-1x"></i>' + event.dateString + '</span>' +
            '<!-- end of event timestamp -->'
            + eventEnd;
    }

    function getHtmlForTwitterTimeLine(event) {
        return eventStart +
            '<div class="event_title is-hidden">' +
            '<i class="fa fa-twitter fa-2x profile_image twitter"> </i>' +

            '<h3>' + event['screen_name'] + '</h3>' +
            '<span class="subtitle">@' + event.screen_name + '</span>' +
            '</div>' +
            '   <!-- end of event title -->' +
            '<div class="event_content">' +
            '<p>Count:' + event.count + '</p>' +
            '<p>' + event['text'] + '</p>' +
            ' <!-- adding link to original tweet -->' +
            '<br>' +

            '<p>' +
            '<strong>Original Tweet:</strong>' +
            '<a href="' + event['original'] + '">' + event['original'] + '</a>' +
            ' </p>' +
            '    <!-- end of link to original tweet -->' +
            '</div>' +
            '  <!-- event timestamp -->' +
            '<span class="next_to_title"><i' +
            'class="fa fa-clock-o fa-1x"></i>' + event.dateString + '</span>' +
            '<!-- end of event timestamp -->'
            + eventEnd;
    }
});