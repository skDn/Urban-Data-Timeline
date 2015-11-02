@extends('search.search')

@section('append_header_js')
    @parent
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
@stop

@section('results')
<section id="cd-timeline" class="cd-container"></section>
<!-- cd-timeline -->

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="{{ URL::asset('js/index.js') }}"></script>
@stop