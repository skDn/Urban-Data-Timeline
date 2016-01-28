@extends('layout.master')


@section('title')
    <title>Urban Data Timeline</title>
@stop

@section('styles')
    @parent

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    {{--<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"--}}
          {{--type="text/css">--}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    {!! Html::style('css/home.css')  !!}
    {{--{!! Html::style('css/animate.css')  !!}--}}
@stop

@section('scripts')
    {{--TODO: transfer everything to js files and don't use parent--}}
    @parent
@stop


@section('content')

    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Urban Data Timeline</h1>

                        <h3>Level 4 project</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="/event" class="btn btn-default btn-lg"><i class="fa fa-search fa-fw"></i> <span
                                            class="network-name">Explore Event</span></a>
                            </li>
                            <li>
                                <a href="/comparison" class="btn btn-default btn-lg"><i
                                            class="fa fa-exchange fa-fw"></i> <span
                                            class="network-name">Compare Events</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->

    <div class="content-section-a">

        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Urban Big Data Center</h2>

                    <p class="lead">A special thanks to <a target="_blank" href="http://ubdc.ac.uk/">Urban Big Data
                            Center</a> for sharing their stored data for this project.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="http://ubdc.ac.uk/media/1102/ubdc_ubdc_logo.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="content-section-b">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">More stuff here<br>by PSDCovers</h2>


                </div>
                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                    <img class="img-responsive" src="http://terrierteam.dcs.gla.ac.uk/img/CompScience_colour_stk-2.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">More Stuff here<br>Font Awesome Icons</h2>


                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->
@stop