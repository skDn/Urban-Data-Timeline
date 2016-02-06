@extends('comparison.comparison')

@section('styles')
    @parent
    {{--@if(config('view.version')!=2)--}}
        {{--<script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>--}}
        {{--<script src="{{ URL::to('js/index.js') }}" type="text/javascript"></script>--}}
    {{--@else--}}
        <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css"/>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        {!! Html::style('css/testStyle.css')  !!}
        {!! Html::style('css/animate.css')  !!}
    {{--@endif--}}
@stop

@section('scripts')
    @parent

    {!! Html::script('js/jquery.afterscroll.js')  !!}
    {!! Html::script('js/jquery.mf_timeline.js')  !!}

@stop

@section('results')

    @if (!count($data))
        <p> No results found </p>

    @else

        <div class="col-lg-12" style="margin-bottom: 15px">
            @include('templates.partials.lineGraph')
        </div>
        @if(config('view.version')!=2)
            {{--<style> .is-hidden {display: none} </style>--}}
            <section id="cd-timelineFirst" class="cd-container col-lg-6 col-xs-6">
                @foreach ($data['responseFirst'] as $event)
                    <div class="cd-timeline-block">
                        @if ($event['class'] == 'tweet')
                            <div class="cd-timeline-img cd-tweet">
                                <img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
                            </div>
                            <!-- cd-timeline-img -->
                            <div class="cd-timeline-content">
                                <h2>{{ $event['screen_name'] }}</h2>

                                <p>{{ $event['count'] }}</p>
                                <a href="#" class="cd-read-more">Read more</a>
                                <span class="cd-date">{{ date("d - H:i", strtotime($event['dateString'])) }}</span>
                            </div>
                        @elseif($event['class'] == 'venue')
                            <div class="cd-timeline-img cd-venue">
                                <img src="http://www.mobilemerit.com/mobile/restaurant/restaurant/images/icon-location.png"
                                     alt="Venue">
                            </div>
                            <!-- cd-timeline-img -->
                            <div class="cd-timeline-content">
                                <h2>{{ $event['venueInfo']['name'] }}</h2>

                                <p>{{ $event['venue'] }}</p>
                                <a href="#" class="cd-read-more">Read more</a>
                                <span class="cd-date">{{ date("d - H:i", strtotime($event['dateString'])) }}</span>
                            </div>
                            @endif
                                    <!-- cd-timeline-content -->
                    </div> <!-- cd-timeline-block -->
                @endforeach
            </section>

            <section id="cd-timelineSecond" class="cd-container col-lg-6">
                @foreach ($data['responseSecond'] as $event)
                    <div class="cd-timeline-block">
                        @if ($event['class'] == 'tweet')
                            <div class="cd-timeline-img cd-tweet">
                                <img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
                            </div>
                            <!-- cd-timeline-img -->
                            <div class="cd-timeline-content">
                                <h2>{{ $event['screen_name'] }}</h2>

                                <p>{{ $event['count'] }}</p>
                                <a href="#" class="cd-read-more">Read more</a>
                                <span class="cd-date">{{ date("d - H:i", strtotime($event['dateString'])) }}</span>
                            </div>
                        @elseif($event['class'] == 'venue')
                            <div class="cd-timeline-img cd-venue">
                                <img src="http://www.mobilemerit.com/mobile/restaurant/restaurant/images/icon-location.png"
                                     alt="Venue">
                            </div>
                            <!-- cd-timeline-img -->
                            <div class="cd-timeline-content">
                                <h2>{{ $event['venueInfo']['name'] }}</h2>

                                <p>{{ $event['venue'] }}</p>
                                <a href="#" class="cd-read-more">Read more</a>
                                <span class="cd-date">{{ date("d - H:i", strtotime($event['dateString'])) }}</span>
                            </div>
                            @endif
                                    <!-- cd-timeline-content -->
                    </div> <!-- cd-timeline-block -->
                @endforeach
            </section>
            <!-- cd-timeline -->

            {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}
        @else
            <div id="timelineFirst" class="timeline col-lg-6 col-xs-6">
                <a href="" class="timeline_spine"></a>
                <ol class="timeline_nav is-hidden" style="/*position: fixed;*/">
                    @foreach ($data['responseFirst']['sections'] as $section)
                        <li id="menu_year_{{$section['id']}}">
                            <a type="button">{{$section['id']}}</a>
                        </li>
                    @endforeach
                </ol>
                @foreach ($data['responseFirst']['sections'] as $section)
                    @include('templates.partials.section')
                @endforeach
            </div>
            <div id="timelineSecond" class="timeline col-lg-6 col-xs-6">
                <a href="" class="timeline_spine"></a>
                @foreach ($data['responseSecond']['sections'] as $section)
                    @include('templates.partials.section')
                @endforeach
            </div>

        @endif

    @endif

@stop