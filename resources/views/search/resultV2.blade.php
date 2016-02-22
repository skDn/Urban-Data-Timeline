@extends('search.search')

@section('styles')
    @parent

    <link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    {!! Html::style('css/testStyle.css')  !!}
    {!! Html::style('css/animate.css')  !!}
@stop


@section('scripts')
    @parent
    {!! Html::script('js/infinite.js')  !!}
    {!! Html::script('js/jquery.afterscroll.js')  !!}
    {!! Html::script('js/jquery.mf_timeline.js')  !!}
@stop

@section('results')

    @if (!count($data))
        <p> No results found </p>

    @else

        @include('templates.partials.lineGraph')
        @include('templates.partials.infoBox')
        {{--<style> .is-hidden {display: none} </style>--}}
        <div class="timeline">
            <a href="" class="timeline_spine"></a>

            <ol class="timeline_nav is-hidden" style="/*position: fixed;*/">
                @foreach ($data['sections'] as $section)
                    <li id="menu_year_{{$section['id']}}">
                        <a type="button">{{$section['id']}}</a>
                    </li>
                @endforeach
            </ol>
            @foreach ($data['sections'] as $section)
                @include('templates.partials.section')
            @endforeach

        </div>
        <div id="loading" class="row text-center">
            <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif"
                 width="32"
                 height="32" alt="tweet loader"/>
        </div>
        <!-- cd-timeline -->

        {{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}

    @endif

@stop