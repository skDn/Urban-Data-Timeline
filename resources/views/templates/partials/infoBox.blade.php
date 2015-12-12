@section('styles')
    @parent
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .fixed {
            position: fixed;
            top:0;
            z-index: 2000000;
        }
    </style>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    {!! Html::style('css/weather.css')  !!}
@stop
@section('scripts')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.0.2/jquery.simpleWeather.min.js'></script>
    {!! Html::script('js/fixingOnScroll.js')  !!}
    {!! Html::script('js/getWeatherData.js')  !!}
@stop
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
                <div class="panel-body alert-info" id="weather">
                </div>
            </div>
        </div>
    </div>
</div>

