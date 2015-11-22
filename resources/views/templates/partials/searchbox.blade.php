@section('styles')
    @parent
    {!! Html::style('css/search.css') !!}
@stop

<form class="col-md-12 center-block" style="padding: 0 !important;" role="search" action="{{ route('search.results') }} " methond="get"
      id="searchForm">
    <div class="inner-addon left-addon form-search form-inline">
        <i class="glyphicon glyphicon-search"></i>
        <input type="text" class="form-control" style="width: 100%;font-size: inherit !important;" placeholder="Input a query"
               name="query{{$element['id']}}"
               value="{{ $element['query'] or '' }}"
               id="query_{{ $element['id'] }}"
                >
    </div>
    @include('templates.partials.datepicker')

    <label for="latInput"></label><input id="latInput" type="hidden" name="lat">
    <label for="lonInput"></label><input id="lonInput" type="hidden" name="lng">

    {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
</form>

@include('templates.partials.googleMap')

<input type="submit" class="center-block btn btn-primary" form="searchForm" style="margin-top: 15px;" value="Search">
