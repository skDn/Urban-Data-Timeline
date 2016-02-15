@section('styles')
    @parent
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        /*.fixed {*/
        /*position: fixed;*/
        /*top: 0;*/
        /*z-index: 2000000;*/
        /*}*/

        td, th {
            text-align: center;
            border: 2px solid #ddd;
            border-top-width: 0;
        }

        th {
            background-color: #ddd;
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
<nav id="infoBox" class="navbar navbar-default navbar-fixed-top container is-hidden infoBox"
     style="padding-left: 0;padding-right: 0">
    @if (array_key_exists("twitter",$data['info']))
        <table class="table table-condensed" style="margin-bottom: 0">
            <thead>
            <tr>
                <th><i class="fa fa-search fa-1"></i> Query</th>
                <th><i class="fa fa-calendar fa-1"></i> Date</th>
                <th><i class="fa fa-twitter fa-1"></i> Twitter Users</th>
                <th><i class="fa fa-twitter fa-1"></i> All Tweets for query</th>
                <th><i class="fa fa-twitter fa-1"></i> All Tweets for day</th>
                <th><i class="fa fa-hashtag fa-1"></i> Popular tags, tweeted together with
                    {{$data['info']['twitter']['query']}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$data['info']['twitter']['query']}}</td>
                <td>{{$data['info']['twitter']['date']}}</td>
                <td>{{$data['info']['twitter']['nUsers']}}</td>
                <td>{{$data['info']['twitter']['nTweets']}}</td>
                <td>{{$data['info']['twitter']['nTweetsForDay']}}</td>
                <td>
                    @foreach($data['info']['twitter']['popularHTags'] as $tag)
                        {{$tag['hashtag']}}<sup>{{$tag['count']}}</sup>
                    @endforeach
                </td>
            </tr>
            </tbody>
        </table>
    @endif
</nav>
