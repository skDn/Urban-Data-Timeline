
{{--@section('title')--}}
    {{--<title>Search</title>--}}
{{--@stop--}}

{{--@section('append_header_style')--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">--}}
{{--@stop--}}

{{--@section('content')--}}
    {{--<section id="cd-timeline" class="cd-container"/>--}}
    {{--<div class="container" style="margin-top: 15px;">--}}
    {{--@include('templates.partials.searchbox')--}}
    {{--</div>--}}
    {{--@yield('results')--}}
{{--@stop--}}


@extends('layout.master')

@section('title')
<title>Search</title>
@stop

@section('styles')
    @parent
    {!! Html::style('css/search.css') !!}
    {!! Html::style('css/style.css')  !!}
@stop


@section('scripts')
    {{--TODO: transfer everything to js files and don't use parent--}}
    @parent
    {{--{!! Html::script('js/app.js')  !!}--}}
@stop


@section('content')

    @include('templates.partials.searchbox')

    @yield('results')
@stop
