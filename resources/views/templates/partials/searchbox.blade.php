<div class="row" xmlns="http://www.w3.org/1999/html">
    <form class="col-md-6 center-block" role="search" action="{{ route('search.results') }} " methond = "get" id = "searchForm">
        <div class="inner-addon left-addon form-search form-inline">
            <i class="glyphicon glyphicon-search"></i>
            <input type="text" class="form-control" style="width: 100%;" placeholder="Search" name="query" value="{{ $data['search']['query'] or '' }}">
        </div>
        @include('templates.partials.datepicker')
        {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
    </form>
</div>