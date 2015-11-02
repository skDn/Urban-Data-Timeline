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
    @include('templates.partials.searchbox')
    @yield('results')
@stop

