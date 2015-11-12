@extends('layout.master')

@section('title')
    <title>Compare</title>
@stop

@section('styles')
    @parent
    {!! Html::style('css/search.css') !!}
    <style type="text/css">
        .myHalfCol .col-lg-6 {
            width: 48%;
            margin: 0 1%; /* or auto */
        }

        .center-block {
            float: none !important
        }
    </style>
@stop

@section('scripts')
    @parent
    {!! Html::script('js/datepicker.js') !!}
@stop


@section('content')
    <div class="center-block col-lg-12 myHalfCol">
        <form class="col-md-12 center-block" role="search" action="{{ route('comparison.results') }} " methond="get"
              id="searchForm">
            @foreach ($data['elements'] as $element)
                <div class="col-lg-6">
                    <div class="inner-addon left-addon form-search form-inline">
                        <i class="glyphicon glyphicon-search"></i>
                        <input type="text" class="form-control" style="width: 100%;font-size: inherit !important;"
                               placeholder="Search" name="query{{ $element['id'] }}"
                               value="{{ $element['query'] or '' }}">
                    </div>
                    @include('templates.partials.datepicker')
                </div>
            @endforeach
            {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
                <input type="submit" value="Submit">
        </form>
        @yield('results')
    </div>
    @include('templates.partials.scrollTop')
@stop