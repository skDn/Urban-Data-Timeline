<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        @yield('title')
        @yield('append_header_js')
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
              integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
              crossorigin="anonymous">
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/148866/reset.css">

        @yield('append_header_style')
    </head>
    <body>
        @include('templates.partials.navigation')

        {{--<div class="container">--}}
        @yield('content')
        {{--</div>--}}
        @yield('append_js')
    </body>
</html>
