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
                if (!scrolled && $win.scrollTop() + $win.height() >= elTopPos) {
                    after_top.apply(t)
                    scrolled = true
                }
                // have scrolled past yet
                else if (scrolled && $win.scrollTop() + $win.height() < elTopPos) {
                    before_top.apply(t)
                    scrolled = false
                }


                /* Bottom of element*/
                // haven't scrolled past yet
                if (!scrolled && $win.scrollTop() + $win.height() >= elBottomPos) {
                    after_bottom.apply(t)
                    scrolled = true
                }
                // have scrolled past yet
                else if (scrolled && $win.scrollTop() + $win.height() < elBottomPos) {
                    before_bottom.apply(t)
                    scrolled = false
                }
            }).scroll()
        })
    }
})(jQuery);
const $loading = $('#loading');

const eventStart = '<li class="event">' +
    '<i class="event_pointer"></i>' +

    '<div class="event_container">';
const eventEnd = '</li>' + '</div>';

$(function () {
    var prevSection;
    var listOfFilledSections = [];
    $loading.hide();
    var counter = 0;
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (settings.url.indexOf('count') > -1) {
            counter++;
        }
    });
    $(window).on('scroll', function () {
        $timeline_block.each(function () {
            //$timeline_elements.each(function () {
            if (counter >= countRangePlusMinus + 1) {
                if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.9) {
                    console.log($(this).attr('id'));
                    var sectionID = $(this).attr('id');
                    if (prevSection !== sectionID && $.inArray(sectionID, listOfFilledSections) === -1) {
                        listOfFilledSections.push(sectionID);
                        /// substitude with ajax calls;
                        ajaxCall(sectionID);

                    }
                    prevSection = sectionID;
                }
            }
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

    function getHtmlForVenueTimeSeries(event) {
        return eventStart +
            '<div class="event_title">' +
            '<i class="fa fa-spoon fa-2x profile_image venue"> </i>' +

            '<h3>' + event.name + '</h3>' +
            '<span class="next_to_title"><i' +
            'class="fa fa-map-marker fa-1x"></i>' + event.location + '</span>' +
            '</div>' +
            '<!-- end of event title -->' +
            '<div class="event_content">' +
            ((event.phone !== undefined) ?
            '<p>' +
            '<strong>Phone:</strong>' +
            event.phone + '</p>' : ' ' ) +

            '<p>' +
            '<strong>Number of check-ins:</strong>' +
            event.value +
            '</p>' +
            '<!-- adding link to original tweet -->' +
            '<br>' +
            ((event.menuURL !== undefined ) ?
            '<p>' +
            '<strong>Menu:</strong>' +
            '<a href="http:' + event.menuURL + '">http:' + event.menuURL + '</a>' +
            '</p>' : ' ') +
            '<!-- end of link to original tweet -->' +
            '</div>' +
            '<!-- event timestamp -->' +
            '<span class="next_to_title"><i' +
            'class="fa fa-clock-o fa-1x"></i>' + event.dateString + '</span>' +
            '<!-- end of event timestamp -->'
            + eventEnd;

    }

    function getHtmlForVenue(event) {
        return eventStart +
            '<div class="event_title">' +
            '<i class="fa fa-spoon fa-2x profile_image venue"> </i>' +

            '<h3>' + event.venue + '</h3>' +
            '<span class="next_to_title"><i' +
            'class="fa fa-map-marker fa-1x"></i>' + event.location + '</span>' +
            '</div>' +
            '<!-- end of event title -->' +
            '<div class="event_content">' +
            ((event.phone !== undefined) ?
            '<p>' +
            '<strong>Phone:</strong>' +
            event.phone + '</p>' : ' ' ) +

            '<p>' +
            '<strong>Number of check-ins:</strong>' +
            event.checkins +
            ' </p>' +

            '<p>' +
            '<strong>Number of users:</strong>' +
            event.users +
            '</p>' +
            '<!-- adding link to original tweet -->' +
            '<br>' +
                //(event.menuURL) ?
                //'<p>' +
                //'<strong>Menu:</strong>' +
                //'<a href="http:' + event.menuURL + '">http:' + event.menuURL + '</a>' +
                //'</p>' : ' ' +
            '<!-- end of link to original tweet -->' +
            '<!-- <a data-readmore-toggle="" aria-controls="info">Read more</a> -->' +
            '</div>' +
            '<!-- event timestamp -->' +
            '<span class=' +
            'next_to_title' +
            '><i' +
            'class="fa fa-clock-o fa-1x"></i> ' + event.dateString + ' </span>'
            + eventEnd;

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
            '<div class="event_title">' +
            '<i class="fa fa-twitter fa-2x profile_image twitter"> </i>' +

            '<h3>' + event['screen_name'] + '</h3>' +
            '<span class="subtitle">@' + event.screen_name + '</span>' +
            '</div>' +
            '   <!-- end of event title -->' +
            '<div class="event_content">' +
                //'<p>Count:' + event.count + '</p>' +
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

    function getEventsHtmlRepresentation(data, objectToAppend) {
        for (var event in data) {
            if (data[event].class === 'tweet') {
                objectToAppend.append(getHtmlForTweet(data[event]));
            }
            else if (data[event].class === 'tweetFromTimeline') {
                objectToAppend.append(getHtmlForTwitterTimeLine(data[event]));
            }
            else if (data[event].class === 'venueTimeSeries') {
                objectToAppend.append(getHtmlForVenueTimeSeries(data[event]));
            }
            else if (data[event].class === 'venue') {
                objectToAppend.append(getHtmlForVenue(data[event]));
            }
        }
    }
});