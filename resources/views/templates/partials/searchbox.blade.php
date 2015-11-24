@section('styles')
    @parent
    {!! Html::style('css/search.css') !!}
@stop
{{-- TODO: change every component to be a row and remove margin-top from everywhere--}}
<form class="col-md-12 center-block" style="padding: 0 !important;" role="search"
      action="{{ route('search.results') }} " methond="get"
      id="searchForm">
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
        <div class="alert alert-danger" style="margin-top: 15px;margin-bottom: 0; text-align: center;">
            {{ head($errors->get('query'.$element['id'])) }}
        </div>
    @endif

    @include('templates.partials.datepicker')

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

@include('templates.partials.googleMap')

<input type="submit" class="center-block btn btn-primary" form="searchForm" style="margin-top: 15px;" value="Search">
