<div class="section" id="{{$section['id']}}">
    <div class="title">
        <a>{{$section['id']}}</a>
    </div>

    <ol class="events">
        @foreach($section['events'] as $event)
            <li class="event">
                {{--<!-- style="margin-top: {!! event['diff'] !!}px;"> -->--}}
                <i class="event_pointer"></i>

                <div class="event_container">
                    @if($event['class'] === 'tweetFromTimeline')
                            <!-- event title -->
                    <div class="event_title">
                        <i class="fa fa-twitter fa-2x profile_image twitter"> </i>

                        <h3>{{$event['name']}}</h3>
                        <span class='subtitle'>{{'@'.$event['screen_name']}}</span>
                    </div>
                    <!-- end of event title -->
                    <div class="event_content">
                        <p>{!! $event['text'] !!}</p>
                        <!-- adding link to original tweet -->
                        <br>

                        <p>
                            <strong>Original Tweet:</strong>
                            <a href="{!! $event['original'] !!}">{!! $event['original'] !!}</a>
                        </p>
                        <!-- end of link to original tweet -->
                        <!-- <a data-readmore-toggle="" aria-controls="info">Read more</a> -->
                    </div>
                    <!-- event timestamp -->
                            <span class='next_to_title'><i
                                        class="fa fa-clock-o fa-1x"></i> {{$event['dateString']}}</span>
                    <!-- end of event timestamp -->


                    @elseif($event['class'] === 'venueTimeSeries')
                            <!-- event title -->
                    <div class="event_title">
                        <i class="fa fa-spoon fa-2x profile_image venue"> </i>

                        <h3>{{$event['name']}}</h3>
                                        <span class='next_to_title'><i
                                                    class="fa fa-map-marker fa-1x"></i> {{$event['location']}}</span>
                    </div>
                    <!-- end of event title -->
                    <div class="event_content">
                        <p>
                            <strong>Phone:</strong>
                            {!! $event['phone'] !!}</p>

                        <p>
                            <strong>Number of check-ins:</strong>
                            {{$event['value'] }}
                        </p>
                        <!-- adding link to original tweet -->
                        <br>
                        @if(isset($event['menuURL']))
                            <p>
                                <strong>Menu:</strong>
                                <a href="http:{!! $event['menuURL'] !!}">http:{!! $event['menuURL'] !!}</a>
                            </p>
                            @endif
                                    <!-- end of link to original tweet -->
                            <!-- <a data-readmore-toggle="" aria-controls="info">Read more</a> -->
                    </div>
                    <!-- event timestamp -->
                            <span class='next_to_title'><i
                                        class="fa fa-clock-o fa-1x"></i> {{$event['dateString']}}</span>
                    <!-- end of event timestamp -->
                    @elseif($event['class'] === 'venue')
                        <div class="event_title">
                            <i class="fa fa-spoon fa-2x profile_image venue"> </i>

                            <h3>{{$event['venue']}}</h3>
                                        <span class='next_to_title'><i
                                                    class="fa fa-map-marker fa-1x"></i> {{$event['location']}}</span>
                        </div>
                        <!-- end of event title -->
                        <div class="event_content">
                            {{--<p>--}}
                            {{--<strong>Phone:</strong>--}}
                            {{--{!! $event['phone'] !!}</p>--}}

                            <p>
                                <strong>Number of check-ins:</strong>
                                {{$event['checkins'] }}
                            </p>

                            <p>
                                <strong>Number of users:</strong>
                                {{$event['users'] }}
                            </p>
                            <!-- adding link to original tweet -->
                            <br>
                            @if(isset($event['menuURL']))
                                <p>
                                    <strong>Menu:</strong>
                                    <a href="http:{!! $event['menuURL'] !!}">http:{!! $event['menuURL'] !!}</a>
                                </p>
                                @endif
                                        <!-- end of link to original tweet -->
                                <!-- <a data-readmore-toggle="" aria-controls="info">Read more</a> -->
                        </div>
                        <!-- event timestamp -->
                        <span class='next_to_title'><i
                                    class="fa fa-clock-o fa-1x"></i> {{$event['dateString']}}</span>

                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</div>