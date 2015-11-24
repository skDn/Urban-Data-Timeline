@section('styles')
    @parent
    {!! Html::style('css/googleMaps.css') !!}
@stop

<input id="pac-input" class="controls" type="text" placeholder="Input a location">
<div id="googleMap" class="col-md-12 center-block"></div>

@section('scripts')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>
    {!! Html::script('js/googleMaps.js') !!}
@stop