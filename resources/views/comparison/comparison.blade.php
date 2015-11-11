@extends('layout.master')

@section('title')
<title>Compare</title>
@stop

@section('content')
<style type="text/css">
	.myHalfCol .col-lg-6{
		width:48%; 
		margin:0 1%; /* or auto */
	}
	.center-block {float: none !important}
</style>


<div class="center-block col-lg-12 myHalfCol">
    <div class="col-lg-6">
        @include('templates.partials.searchbox')
    </div>
    <div class="col-lg-6">
    	@include('templates.partials.searchbox')
    </div>
    @yield('result')
</div>
@include('templates.partials.scrollTop')
@stop