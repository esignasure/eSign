<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>eSignasure - Home</title>
        <base href="/">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
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
        <script src="{{ asset('js/libs/jquery-3.2.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/libs/popper.min.js') }}"></script>
        <script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
    </body>
</html>
