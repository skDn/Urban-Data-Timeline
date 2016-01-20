{{--navbar-fixed-top--}}
{{--<nav class="navbar navbar-default navbar-fixed-top" role="navigation">--}}
    {{--<div class="container">--}}
        {{--<div class="navbar-header">--}}
            {{--<a class="navbar-brand">Urban-Data-Timeline</a>--}}
        {{--</div>--}}
        {{--<div class="collapse navbar-collapse">--}}
            {{--<ul class="nav navbar-nav navbar-right">--}}
                {{--<li><a href="{{ route('comparison') }}">Compare</a> </li>--}}
                {{--<li><a href="{{ route('event') }}">Search</a> </li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</nav>--}}


<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
    <div class="container topnav">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topnav" href="/">Urban-Data-Timeline</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('comparison') }}">Compare</a>
                </li>
                <li>
                    <a href="{{ route('event') }}">Search</a>
                </li>
                <li>
                    <a href="/">API</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>