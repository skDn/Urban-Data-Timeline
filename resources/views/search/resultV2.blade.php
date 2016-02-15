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
        flag = true;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                no_data = true;
                if (flag && no_data) {
                    flag = false;
                    $('#loader').show();
                    $.ajax({
                        url: '/infinite/single',
                        method: 'get',
//                        data: {
//                            start : first,
//                            limit : limit
//                        },
                        success: function (data) {
                            flag = true;
                            $('#loader').hide();
                            if (data != '') {
                                console.log(data);
                                $('#11am ol.events ').append(
                                        '<li class="event">' +
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
                                alert('No more data to show');
                                no_data = false;
                            }
                        },
                        error: function (data) {
                            flag = true;
                            $('#loader').hide();
                            no_data = false;
                            alert('Something went wrong, Please contact admin');
                        }
                    });
                }


            }
        });
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