<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="css/normalize.css"> -->
    <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    {!! Html::style('css/testStyle.css')  !!}
    {!! Html::style('css/animate.css')  !!}

</head>

<body>


<div class="timeline">
    <a href="" class="timeline_spine"></a>

    <div class="section">
        <ol class="events">
            <li class="featured event">
                <i class="event_pointer"></i>

                <div class="event_container">
                    <div class="event_title">
                        <img class="profile_image" src="{{$data['info']['profile_image_url']}}">
                        <h3>{{$data['info']['name']}}</h3>
                        <span class='subtitle'>{{$data['info']['screen_name']}}</span>
                    </div>
                    <div class="event_content">
                        <p>{{$data['info']['description']}}</p>
                    </div>
                    <span class='next_to_title'><i class="fa fa-map-marker fa-1x"></i> {{$data['info']['location']}}</span>
                </div>
            </li>
        </ol>
    </div>

    <ol class="timeline_nav" style="position: fixed;">
        @foreach ($data['section'] as $section)
            <li id="menu_year_{{$section['id']}}">
                <a type="button">{{$section['id']}}</a>
            </li>
        @endforeach
    </ol>
    @foreach ($data['section'] as $section)
        <div class="section" id="{{$section['id']}}">
            <div class="title">
                <a>{{$section['id']}}</a>
            </div>

            <ol class="events">
                @foreach($section['tweets'] as $tweet)
                    <li class="event"> 
                    <!-- style="margin-top: {!! $tweet['diff'] !!}px;"> -->
                        <i class="event_pointer"></i>

                        <div class="event_container">
                            <!-- event title -->
                            <div class="event_title">
                                <i class="fa fa-twitter fa-2x profile_image twitter"> </i>

                                <h3>{{$tweet['name']}}</h3>
                                <span class='subtitle'>{{'@'.$tweet['screen_name']}}</span>
                            </div>
                            <!-- end of event title -->
                            <div class="event_content">
                                <p>{!! $tweet['text'] !!}</p>
                                <!-- adding link to original tweet -->
                                <br>
                                <p>
                                <strong>Original Tweet:</strong>
                                <a href="http:{!! $tweet['original'] !!}">http:{!! $tweet['original'] !!}</a>
                                </p>
                                <!-- end of link to original tweet -->
                            </div>
                            <!-- event timestamp -->
                            <span class='next_to_title'><i
                                        class="fa fa-clock-o fa-1x"></i> {{$tweet['created_at']}}</span>
                            <!-- end of event timestamp -->
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @endforeach


</div>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

{!! Html::script('js/jquery.afterscroll.js')  !!}
{!! Html::script('js/jquery.mf_timeline.js')  !!}


</body>
</html>