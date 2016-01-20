{{--{{ HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') }}--}}

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
crossorigin="anonymous">
{!! Html::style('css/bootstrap.css')  !!}
{!! Html::style('css/global.css')  !!}

@if(config('view.version')!=2)
<link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/148866/reset.css">
{{--<link rel="stylesheet" src="//normalize-css.googlecode.com/svn/trunk/normalize.css" />--}}
{!! Html::style('css/style.css')  !!}

@endif
@yield('styles')