@section('styles')
    @parent
    {!! Html::style('css/search.css') !!}
@stop

<form class="col-md-12 center-block" role="search" action="{{ route('search.results') }} " methond="get"
      id="searchForm">
    <div class="inner-addon left-addon form-search form-inline">
        <i class="glyphicon glyphicon-search"></i>
        <input type="text" class="form-control" style="width: 100%;font-size: inherit !important;" placeholder="Search"
               name="query{{$element['id']}}"
               value="{{ $element['query'] or '' }}"
               id="query_{{ $element['id'] }}"
                >
    </div>
    @include('templates.partials.datepicker')
    {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
</form>
