@extends('search.search')

@section('styles')
    @parent

    <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    {!! Html::style('css/testStyle.css')  !!}
    {!! Html::style('css/animate.css')  !!}
@stop


@section('scripts')
    @parent

    {!! Html::script('js/jquery.afterscroll.js')  !!}
    {!! Html::script('js/jquery.mf_timeline.js')  !!}
    <script>
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

        $(function () {
            var prevYear;
            var listOfFilledSections = [];
            $('#loading').hide();
            $('.timeline .section').each(function () {
                $(this).afterScrollPast(function () {
                    // After we have scolled past the top
                    var year = $(this).attr('id');
                    if (prevYear !== year && $.inArray(year, listOfFilledSections) === -1) {
                        listOfFilledSections.push(year);
                        /// substitude with ajax calls;
                        console.log('this is ' + year);
                    }
                    prevYear = year;
                });
            });
        });


        $('#loading').hide();
        flag = true;
        $(window).scroll(function () {
            var lastChild = $('.timeline').children().last().attr('id');
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                no_data = true;
                if (flag && no_data) {
                    flag = false;
                    $('#loading').show();
                    $.ajax({
                        url: '/infinite/single',
                        method: 'get',
                        data: getInputs(),
                        success: function (data) {
                            flag = true;
                            //console.log(data);
                            $('#loading').hide();
                            if (data != '') {
                                //console.log($(lastChild + ' ol.events'));
                                $('#' + lastChild + ' ol.events').append(
                                        '<li class="event animated zoomIn">' +
                                        '<i class="event_pointer"></i>' +

                                        '<div class="event_container">' +
                                        '<div class="event_title">' +
                                        '<i class="fa fa-twitter fa-2x profile_image twitter"> </i>' +

                                        '<h3>Web_Monocle</h3>' +
                                        '<span class="subtitle">@Web_Monocle</span>' +
                                        '</div>' +
                                        '    <!-- end of event title -->' +
                                        '<div class="event_content">' +
                                        '<p>Count: 1</p>' +

                                        '<!-- end of link to original tweet -->' +
                                        '</div>' +
                                        '   <!-- event timestamp -->' +
                                        '<span class="next_to_title"><i' +
                                        'class="fa fa-clock-o fa-1x"></i> 2014-08-25 22:10</span>' +
                                        '<!-- end of event timestamp -->' +
                                        '</div>' +
                                        '</li>'
                                );
                            } else {
//                                alert('No more data to show');
                                no_data = false;
                                $('#loading').hide();
                            }
                        },
                        error: function (data) {
                            flag = true;
                            $('#loading').hide();
                            no_data = false;
                            alert('Something went wrong, Please contact admin');
                        }
                    });
                }


            }
        });

        function getInputs() {
            var dict = {};

            $("form").find(':input').each(function () {
                if ($(this).attr('name') === 'date') {
                    dict['date'] = getDate();
                }
                else {
                    dict[$(this).attr('name')] = $(this).val()
                }
            });
            return dict;

        }
    </script>

@stop

@section('results')

    @if (!count($data))
        <p> No results found </p>

    @else

        @include('templates.partials.lineGraph')
        @include('templates.partials.infoBox')
        {{--<style> .is-hidden {display: none} </style>--}}
        <div class="timeline">
            <a href="" class="timeline_spine"></a>

            <ol class="timeline_nav is-hidden" style="/*position: fixed;*/">
                @foreach ($data['sections'] as $section)
                    <li id="menu_year_{{$section['id']}}">
                        <a type="button">{{$section['id']}}</a>
                    </li>
                @endforeach
            </ol>
            @foreach ($data['sections'] as $section)
                @include('templates.partials.section')
            @endforeach

        </div>
        <div id="loading" class="row text-center">
            <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif"
                 width="32"
                 height="32" alt="tweet loader"/>
        </div>
        <!-- cd-timeline -->

        {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}

    @endif

@stop