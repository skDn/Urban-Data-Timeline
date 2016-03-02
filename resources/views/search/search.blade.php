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
        @foreach ($data['elements'] as $element)
            @include('templates.partials.searchbox')
        @endforeach

    {{--@include('templates.partials.scrollTop')--}}

    @yield('results')
    </div>
@stop
