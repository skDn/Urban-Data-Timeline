/**
 * Created by skDn on 16/02/2016.
 */

// modified afterscroll to return bottom of screen
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
// start of event template
const eventStart = '<li class="event">' +
    '<i class="event_pointer"></i>' +

    '<div class="event_container">';
// end of event template
const eventEnd = '</div>' + '</li>';

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
        /**
         * make ajax call if user is about to hit the bottom of the page
         */
        $(document).on('scroll', function () {
            $timeline_block.each(function (event) {
                //$timeline_elements.each(function () {
                if (counter >= countRangePlusMinus + 1) {
                    if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.9) {
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

        /**
         * get all inputs from form and url
         * @param id
         * @returns {{}}
         */
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
            var searchToken = getParameterByName('searchToken');
            var twitterAccount = getParameterByName('twitterAccount');
            if (twitterAccount !== null) {
                dict['twitterAccount'] = twitterAccount;
            }
            if (searchToken !== null) {
                dict['searchToken'] = searchToken;
            }
            dict['sectionID'] = id;
            return dict;
        }

        /**
         * extract parameter from current url
         * @param name
         * @param url
         * @returns {*}
         */
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        /**
         * call the server for the events in section with id
         * @param id
         */
        function ajaxCall(id) {
            $loading.show();

            var markers = [];
            var marker;
            if (getParameterByName('querySecond') !== null) {
                marker = $(timelineFirst + ' #' + id + ' ol.events');
                markers.push(marker);
                marker = $(timelineSecond + ' #' + id + ' ol.events');
                markers.push(marker);
            }
            else {
                marker = $('#' + id + ' ol.events');
                markers.push(marker);
            }

            //console.log(markers[currentMarker]);
            $.ajax({
                url: '/infinite/single',
                method: 'get',
                data: getInputs(id),
                dataType: 'json',
                success: function (data) {
                    //$loading.hide();
                    if (data != '') {
                        for (var currentMarker in markers) {
                            hideLoadingEvenetsFromSection(markers[currentMarker]);
                            getEventsHtmlRepresentation(data, markers[currentMarker]);
                        }
                    } else {
                        $loading.hide();
                    }
                }
            });

        }

        /**
         * remove loading events, that were put from the View
         * @param marker
         */
        function hideLoadingEvenetsFromSection(marker) {
            marker.children(".loading").removeClass('zoomIn').addClass('zoomOut').hide();
        }

        /**
         * template for venue time series
         * @param event
         * @returns {string}
         */
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

        /**
         * template for Venue
         * @param event
         * @returns {string}
         */
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

        /**
         * template for Tweet
         * @param event
         * @returns {string}
         */
        function getHtmlForTweet(event) {
            return eventStart +
                '<div class="event_title">' +
                    //'<i class="fa fa-twitter fa-2x profile_image twitter"> </i>' +
                '<i class="profile_image"> <img src="' + event.image + '"> </i>' +
                '<h3>' + event['screen_name'] + '</h3>' +
                '<span class="subtitle">@' + event.screen_name + '</span>' +
                '</div>' +
                '   <!-- end of event title -->' +
                '<div class="event_content">' +
                '<p>' + event.text + '</p>' +
                '</div>' +
                '  <!-- event timestamp -->' +
                '<span class="next_to_title"><i' +
                'class="fa fa-clock-o fa-1x"></i>' + event.dateString + '</span>' +
                '<!-- end of event timestamp -->'
                + eventEnd;
        }

        /**
         * template for twitter timeline
         * @param event
         * @returns {string}
         */
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

        /**
         * check if comparison view and put the events in the appropriate section
         * @param data
         * @param objectToAppend
         */
        function getEventsHtmlRepresentation(data, objectToAppend) {
            var dataToUse;
            if (objectToAppend.selector.indexOf(timelineFirst) > -1) {
                dataToUse = data.first;
            }
            else if (objectToAppend.selector.indexOf(timelineSecond) > -1) {
                dataToUse = data.second;
            }
            else {
                dataToUse = data;
            }
            for (var event in dataToUse) {
                if (dataToUse[event].class === 'tweet') {
                    objectToAppend.append(getHtmlForTweet(dataToUse[event]));
                }
                else if (dataToUse[event].class === 'tweetFromTimeline') {
                    objectToAppend.append(getHtmlForTwitterTimeLine(dataToUse[event]));
                }
                else if (dataToUse[event].class === 'venueTimeSeries') {
                    objectToAppend.append(getHtmlForVenueTimeSeries(dataToUse[event]));
                }
                else if (dataToUse[event].class === 'venue') {
                    objectToAppend.append(getHtmlForVenue(dataToUse[event]));
                }
            }

        }
    }
);

jQuery.fn.getSelector = function () {
    return jQuery(this).data('selector');
};