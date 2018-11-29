<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>eSignasure - @yield('title')</title>
        <base href="/">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/element.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="wrapper">
            @include('layouts.header')

            <div class="main-content">
                @yield('content')
            </div>

            @include('layouts.footer')

        </div>
        <!-- ./wrapper -->
        <!-- jQuery 3 -->
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/libs/jquery-3.2.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/libs/popper.min.js') }}"></script>
        <script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
        
        @yield('scripts')
    </body>
</html>
