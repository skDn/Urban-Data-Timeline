@extends('search.search')

@section('scripts')
    @parent
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
    <script src="{{ URL::to('js/index.js') }}" type="text/javascript"></script>
@stop

@section('results')

    @if (!count($data))
        <p> No results found </p>

    @else

        @include('templates.partials.lineGraph')
        @include('templates.partials.infoBox')
        {{--<style> .is-hidden {display: none} </style>--}}
        <section id="cd-timeline" class="cd-container">
            @foreach ($data['response'] as $event)
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
                            <img src="http://www.mobilemerit.com/mobile/restaurant/restaurant/images/icon-location.png" alt="Venue">
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

    @endif

@stop