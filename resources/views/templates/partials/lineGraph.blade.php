<style type="text/css">
    div.circle {
        width: 20px;
        height: 20px;
        background: red;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
</style>

<div id="page" style="width: 80%;margin:auto;margin-top:40px;">
    <div id="loading-container" class="row text-center">
        <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif" width="32"
             height="32" alt="tweet loader"/>
    </div>
</div>
@section('scripts')
    @parent
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
    {!! Html::script('js/drawChart.js') !!}
@stop