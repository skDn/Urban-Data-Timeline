@extends('templates.default')

@section('title')
    <title>Search</title>
@stop

@section('append_header_style')
    <link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
@stop

@section('content')
    {{--<section id="cd-timeline" class="cd-container"/>--}}
    <div class="container" style="margin-top: 15px;">
    @include('templates.partials.searchbox')
    </div>
    @yield('results')
@stop

