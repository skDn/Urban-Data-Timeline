@extends('comparison.comparison')

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
        {{--<style> .is-hidden {display: none} </style>--}}
        <section id="cd-timelineFirst" class="cd-container col-lg-6">
            @foreach ($data['responseFirst'] as $event)
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-tweet">
                        <img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
                    </div>
                    <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>{{ $event['screen_name'] }}</h2>

                        <p>{{ $event['count'] }}</p>
                        <a href="#" class="cd-read-more">Read more</a>
                        <span class="cd-date">Jan 14</span>
                    </div>
                    <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            @endforeach
        </section>

        <section id="cd-timelineSecond" class="cd-container col-lg-6">
            @foreach ($data['responseSecond'] as $event)
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-tweet">
                        <img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
                    </div>
                    <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>{{ $event['screen_name'] }}</h2>

                        <p>{{ $event['count'] }}</p>
                        <a href="#" class="cd-read-more">Read more</a>
                        <span class="cd-date">Jan 14</span>
                    </div>
                    <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            @endforeach
        </section>
        <!-- cd-timeline -->

        {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}

    @endif

@stop