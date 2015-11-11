@section('styles')
    @parent
    {!! Html::style('css/scrollTop.css') !!}
@stop
<div class="scroll-top-wrapper">
	<i class="glyphicon glyphicon-menu-up text-center">
<!-- 		<i class="fa fa-2x fa-arrow-circle-up"></i> -->
	</i>
</div>

@section('scripts')
	@parent
	{!! Html::script('js/scrollTop.js') !!}
@stop