@section('styles')
    @parent
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .fixed {
            position: fixed;
            top: 0;
            z-index: 2000000;
        }
        td, th {
            text-align: center;
            border-left: 2px solid black;
            border-right: 2px solid black;
        }
        th {
            background-color: #b2b2b2;
        }
        
    </style>
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>--}}
    {{--{!! Html::style('css/weather.css')  !!}--}}
@stop
@section('scripts')
    @parent
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.0.2/jquery.simpleWeather.min.js'></script>--}}
{{--    {!! Html::script('js/fixingOnScroll.js')  !!}--}}
    {{--{!! Html::script('js/getWeatherData.js')  !!}--}}
@stop
{{--
<div class="row" id="infoBox">
    <div class="col-lg-12">
        <div class="col-lg-3">
            <div class="panel panel-default ">
                <div class="panel-body alert-info">
                    <div class="col-xs-5">
                        <i class="fa fa-map-marker fa-4x"></i>
                    </div>
                    <div class="col-xs-5 ">
                        <p class="alerts-heading">Glasgow</p>

                        <p class="alerts-text">Byres Road</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default ">
                <div class="panel-body alert-info">
                    <div class="col-xs-5">
                        <i class="fa fa-calendar fa-4x"></i>
                    </div>
                    <div class="col-xs-5 text-right">
                        <p class="alerts-heading">Monday</p>

                        <p class="alerts-text">25/08/2014</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default ">
                <div class="panel-body alert-info">
                    <div class="col-xs-5">
                        <i class="fa fa-twitter fa-4x"></i>
                    </div>
                    <div class="col-xs-5 text-right">
                        <p class="alerts-heading">743</p>

                        <p class="alerts-text">Mentions</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default ">
                <div class="panel-body alert-info" id="wasWeather">
                </div>
            </div>
        </div>
    </div>
</div>
--}}
{{--navbar-fixed-top--}}
{{--<nav class="navbar navbar-default">--}}
{{--<div class="container">--}}
{{--<div class="collapse navbar-collapse">--}}
{{--<ul class="nav navbar-nav nav-justified">--}}
<nav id="infoBox" class="navbar navbar-default hidden container" style="padding-left: 0;padding-right: 0">
    {{--<div class="container">--}}
        {{--<ul class="nav nav-justified">--}}
            @if (array_key_exists("twitter",$data['info']))
                <table class="table table-condensed" style="margin-bottom: 0">
                    <thead>
                        <tr>
                            <th>Query</th>
                            <th>Twitter Users</th>
                            <th><i class="fa fa-calendar fa-1"></i> Date </th>
                            <th>All Tweets for query</th>
                            <th>All Tweets for day</th>
                            <th>Query</th>
                            <th>Twitter Users</th>
                            <th>Date</th>
                            <th>All Tweets for query</th>
                            <th>All Tweets for day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$data['info']['twitter']['query']}}</td>
                            <td>{{$data['info']['twitter']['nUsers']}}</td>
                            <td>{{$data['info']['twitter']['date']}}</td>
                            <td>{{$data['info']['twitter']['nTweets']}}</td>
                            <td>{{$data['info']['twitter']['nTweetsForDay']}}</td>
                            <td>{{$data['info']['twitter']['query']}}</td>
                            <td>{{$data['info']['twitter']['nUsers']}}</td>
                            <td>{{$data['info']['twitter']['date']}}</td>
                            <td>{{$data['info']['twitter']['nTweets']}}</td>
                            <td>{{$data['info']['twitter']['nTweetsForDay']}}</td>
                        </tr>
                    </tbody>
                </table>


                {{--<li>--}}
                {{--<div>--}}
                {{--<div class="col-xs-5">--}}
                {{--<i class="fa fa-twitter fa-4x"></i>--}}
                {{--</div>--}}
                {{--<div class="col-xs-5 text-right">--}}
                {{--<p class="alerts-heading">{{$data['info']['twitter']['query']}}</p>--}}

                {{--<p class="alerts-text">Query</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<div>--}}
                {{--<div class="col-xs-5">--}}
                {{--<i class="fa fa-twitter fa-4x"></i>--}}
                {{--</div>--}}
                {{--<div class="col-xs-5 text-right">--}}
                {{--<p class="alerts-heading">{{$data['info']['twitter']['nUsers']}}</p>--}}

                {{--<p class="alerts-text">Number of unique twitter users</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<div>--}}
                {{--<div class="col-xs-5">--}}
                {{--<i class="fa fa-twitter fa-4x"></i>--}}
                {{--</div>--}}
                {{--<div class="col-xs-5 text-right">--}}
                {{--<p class="alerts-heading">{{$data['info']['twitter']['date']}}</p>--}}

                {{--<p class="alerts-text">Date</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<div>--}}
                {{--<div class="col-xs-5">--}}
                {{--<i class="fa fa-twitter fa-4x"></i>--}}
                {{--</div>--}}
                {{--<div class="col-xs-5 text-right">--}}
                {{--<p class="alerts-heading">--}}
                {{--{{$data['info']['twitter']['nTweets']}}--}}
                {{--</p>--}}

                {{--<p class="alerts-text">Number of tweets for this date</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<div>--}}
                {{--<div class="col-xs-5">--}}
                {{--<i class="fa fa-twitter fa-4x"></i>--}}
                {{--</div>--}}
                {{--<div class="col-xs-5 text-right">--}}
                {{--<p class="alerts-heading">{{$data['info']['twitter']['nTweetsForDay']}}</p>--}}

                {{--<p class="alerts-text">Number of all the tweets for this date</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</li>--}}

            @endif
            {{--<li>--}}

            {{--<div id="weather">--}}
            {{--</div>--}}

            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
</nav>

{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</nav>--}}

