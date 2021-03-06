<!--[if HTML5]><![endif]-->
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <!--[if !HTML5]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?php echo URL::to(''); ?>">
        <title>Nook  | Social Networking Service</title>
        <meta name="description" content="A social networking website">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Kosta Rashev">

        <!-- Styles -->
        {{ HTML::style('css/all.min.css') }}

        <!-- Modernizr -->
        {{ HTML::script('js/modernizr.min.js') }}
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Page Wrapper -->
        <div class="wrapper">
            <!-- Navigation Bar -->
            @include('partials.navbar')

            <!-- Alerts Content Area -->
            <div class="container" id="alert-container">

                <div class="alert-info-wrapper">
                    @include('flash::message')
                </div>
                @include('partials.errors')

            </div>

            <!-- Main Content Area -->
            <div id="main-container">
                @yield('content')
            </div>

            <!-- Sticky Footer Fix -->
            <div class="push"></div>
        </div>

        <!-- Footer -->
        @include('partials.footer')

        <!-- JavaScript -->
        {{ HTML::script('js/all.min.js') }}

        @yield('page-scripts')
    </body>
</html>