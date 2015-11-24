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
    {{--{!! Html::script('js/datepicker.js') !!}--}}
@stop


@section('content')
    <div class="center-block col-lg-12 myHalfCol">
        <form class="col-md-12 center-block" role="search" action="{{ route('comparison.results') }} " methond="get"
              id="searchForm">
            <div class="row">
                @foreach ($data['elements'] as $element)
                    <div class="col-lg-6">
                        <div class="inner-addon left-addon form-search form-inline">
                            <i class="glyphicon glyphicon-search"></i>
                            <input type="text" class="form-control" style="width: 100%;font-size: inherit !important;"
                                   placeholder="Input a query"
                                   name="query{{$element['id']}}"
                                   @if ( Input::has('query'.$element['id']))
                                   value="{{ Input::get('query'.$element['id'])}}"
                                   @elseif(Input::old('query'.$element['id']))
                                   value="{{ Input::old('query'.$element['id'])}}"
                                   @else
                                   value=""
                                   @endif
                                   id="query_{{ $element['id'] }}"
                                    >
                        </div>

                        @if (head($errors->get('query'.$element['id'])))
                            <div class="alert alert-danger"
                                 style="margin-top: 15px;margin-bottom: 0; text-align: center;">
                                {{ head($errors->get('query'.$element['id'])) }}
                            </div>
                        @endif
                        {{--@include('templates.partials.datepicker')--}}
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-10 center-block" style="padding: 0;">
                    @include('templates.partials.datepicker')
                </div>
            </div>

            <label for="latInput"></label><input id="latInput" type="hidden" name="lat"
                                                 @if ( Input::has('lat'))
                                                 value="{{ Input::get('lat')}}">
            @elseif(Input::old('lat'))
                value="{{ Input::old('lat')}}"
            @else
                value="">
            @endif

            <label for="lonInput"></label><input id="lonInput" type="hidden" name="lng"
                                                 @if ( Input::has('lng'))
                                                 value="{{ Input::get('lng')}}">
            @elseif(Input::old('lng'))
                value="{{ Input::old('lng')}}"
            @else
                value="">
            @endif

            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
        <div class="row">
            <div class="col-lg-10 center-block">
                @include('templates.partials.googleMap')
            </div>
        </div>

        <div class="row" style="margin-top: 15px">
            <input type="submit" class="center-block btn btn-primary" form="searchForm"
                   value="Search">
        </div>
        @yield('results')
    </div>
    @include('templates.partials.scrollTop')
@stop