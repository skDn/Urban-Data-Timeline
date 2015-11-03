@extends('search.search')

@section('append_header_js')
    @parent
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
@stop

@section('results')

@if (!count($data))
	<p> No results found </p>

@else

<section id="cd-timeline" class="cd-container">
	@foreach ($data as $event) 
    	<div class="cd-timeline-block">
		<div class="cd-timeline-img cd-tweet">
			<img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
		</div> <!-- cd-timeline-img -->
 
		<div class="cd-timeline-content">
			<h2>{{ $event['title'] }}</h2>
			<p>{{ $event['text'] }}</p>
			<a href="#" class="cd-read-more">Read more</a>
			<span class="cd-date">Jan 14</span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->
	@endforeach
</section>
	<!-- cd-timeline -->

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="{{ URL::asset('js/index.js') }}"></script>
@endif

@stop