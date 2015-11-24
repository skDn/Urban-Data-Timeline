<style type="text/css">
    .btn {
        border: 0px solid transparent; /* this was 1px earlier */
    }

    .btn-group-justified div, a:not(:last-of-type) {
        border-right: 1px solid #ccc;
    }

    div > ul {
        box-sizing: border-box;
    }

    .choice {
        width: 600px;
    }
</style>
{{--TODO: remove hardcoded code and make javascript to add each field automatically --}}

<div class="form-inline" style="margin-top:15px;">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">

        <a type="button" title="Decrement Day" id="decrement_" class="btn btn-default" data-action="decrementDays"><span
                    class="glyphicon glyphicon-menu-left"></span></a>

        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="day_" data-toggle="dropdown">
                @if ( Input::has('date'))
                    {{ date("d", strtotime(Input::get('date'))) }}
                @elseif ( Input::old('date'))
                    {{ date("d", strtotime(Input::old('date'))) }}
                @else
                    Day <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            {{--<input type="hidden" name="day"/>--}}
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">1</a></li>

                <li><a type="button" class="btn btn-default">2</a></li>

                <li><a type="button" class="btn btn-default">3</a></li>

                <li><a type="button" class="btn btn-default">4</a></li>

                <li><a type="button" class="btn btn-default">25</a></li>

            </ul>
        </div>
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="month_" data-toggle="dropdown">
                @if ( Input::has('date'))
                    {{ date("m", strtotime(Input::get('date'))) }}
                @elseif ( Input::old('date'))
                    {{ date("m", strtotime(Input::old('date'))) }}
                @else
                    Month <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            {{--<input type="hidden" name="month">--}}
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">1</a></li>

                <li><a type="button" class="btn btn-default">2</a></li>

                <li><a type="button" class="btn btn-default">3</a></li>

                <li><a type="button" class="btn btn-default">8</a></li>

            </ul>

        </div>
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="year_" data-toggle="dropdown">
                @if ( Input::has('date'))
                    {{ date("Y", strtotime(Input::get('date'))) }}
                @elseif ( Input::old('date'))
                    {{ date("Y", strtotime(Input::old('date'))) }}
                @else
                    Year <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            {{--<input type="hidden" name="year">--}}
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">2015</a></li>

                <li><a type="button" class="btn btn-default">2014</a></li>

                <li><a type="button" class="btn btn-default">2013</a></li>

                <li><a type="button" class="btn btn-default">2012</a></li>

            </ul>

        </div>

        <a type="button" title="Increment Day" id="increment_" class="btn btn-default" data-action="incrementDays"><span
                    class="glyphicon glyphicon-menu-right"></span></a>

        <input type="hidden" id="date_" name="date"/>

    </div>
</div>

@if (head($errors->get('date')))
    <div class="alert alert-danger" style="margin-top: 15px;margin-bottom: 0; text-align: center;">
        {{ head($errors->get('date')) }}
    </div>
@endif

@section('scripts')
    @parent
    {!! Html::script('js/datepicker.js') !!}
@stop