<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
        integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
        crossorigin="anonymous"></script>
{{--{{ HTML::script('packages/bs/js/bootstrap.min.js') }}--}}
{!! Html::script('js/global.js') !!}
{!! Html::script('js/toolTips.js') !!}

@yield('scripts')