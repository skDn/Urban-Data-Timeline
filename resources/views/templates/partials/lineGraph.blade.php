<div id="googleChart" style="width: 80%;margin:auto;margin-top:40px;">
    <div id="loading-container" class="row text-center">
        <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif" width="32"
             height="32" alt="tweet loader"/>
    </div>
    {{--<div id="loading-container" class="progress">--}}
        {{--<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:0%">--}}
            {{--0%--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
@section('scripts')
    @parent
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
    {!! Html::script('js/drawChart.js') !!}
@stop