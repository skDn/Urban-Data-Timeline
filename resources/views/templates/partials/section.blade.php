<div class="section" id="{{$section['id']}}">
    <div class="title">
        <a>{{$section['id']}}</a>
    </div>
    {{--http://www.i4vegas.com/img/i4content/process_barnew.gif--}}
    <ol class="events">
        @if (strpos(Route::currentRouteName(),'comparison') === false)
            @for($int = 0; $int<2; $int++)
                <li class="event loading">
                    <i class="event_pointer"></i>
                    <div class="event_container">
                        <!-- event title -->
                        <div class="event_title">
                            <i class="profile_image">
                                <img src="http://www.cgi.com/sites/all/themes/cgi/images/loading_icon.gif" width="50%"
                                     height="50%"/>
                            </i>

                            <h3>
                                <img src="http://www.i4vegas.com/img/i4content/process_barnew.gif" width="50%"/>
                            </h3>
                        </div>
                        <!-- end of event title -->
                        {{--<div class="event_content"/>--}}
                                <!-- event timestamp -->
                <span class='next_to_title'>
                    <img src="http://www.i4vegas.com/img/i4content/process_barnew.gif" width="30%"/>
                </span>
                        <!-- end of event timestamp -->
                    </div>
                </li>
            @endfor
        @else
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
                                @if (array_key_exists('phone',$event))
                                    <p>
                                        <strong>Phone:</strong>
                                        {!! $event['phone'] !!}</p>

                                    <p>
                                        @endif

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
                        @elseif($event['class'] === 'tweet')
                            <div class="event_title">
                                {{--<i class="fa fa-twitter fa-2x profile_image twitter"> </i>--}}
                                <i class="profile_image"> <img src="{{$event['image']}}"> </i>
                                <h3>{{$event['screen_name']}}</h3>
                                <span class='subtitle'>{{ $event['screen_name']}}</span>
                            </div>
                            <!-- end of event title -->
                            <div class="event_content">
                                {{--TODO: fix when service is returning more data--}}
                                <p>{!! $event['text'] !!}</p>
                                <!-- adding link to original tweet -->
                                <!-- end of link to original tweet -->
                                <!-- <a data-readmore-toggle="" aria-controls="info">Read more</a> -->
                            </div>
                            <!-- event timestamp -->
                            <span class='next_to_title'><i
                                        class="fa fa-clock-o fa-1x"></i> {{$event['dateString']}}</span>
                            <!-- end of event timestamp -->
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
    </ol>
</div>
