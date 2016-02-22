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


@section('scripts')
    {{--TODO: transfer everything to js files and don't use parent--}}
    @parent
@stop


@section('content')
    {{--@foreach (Input::old() as $key=>$error)--}}
    {{--        {{ head($errors->get('date')) }}<br>--}}
    {{--{{Input::get('date')}}<br>--}}
    {{--@endforeach--}}
    <div class="container">
        <div class="formatter">
            @foreach ($data['elements'] as $element)
                @include('templates.partials.searchbox')
            @endforeach
        </div>

        @include('templates.partials.scrollTop')

        @yield('results')
    </div>
@stop
