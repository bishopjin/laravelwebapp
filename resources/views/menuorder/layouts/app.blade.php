<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Online Menu Ordering using laravel PHP framework.">
    <meta name="keywords" content="Online Menu, Online Menu Ordering Laravel, Laravel, genesedan">
    <meta name="author" content="Gene Arthur Sedan">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Online Menu Ordering - Laravel') }} &nbsp; {{ app()->version() }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- Scripts -->
    <!-- use this if using artisan serve -->
    <!-- <script src="{{ asset('/js/app.js') }}" defer></script> -->

    <!-- use this if not -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- use this if using artisan serve -->
    <!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->

    <!-- use this if not -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="app">
        <main class="min-vh-100 d-flex align-items-center">
            @yield('content')
        </main>
        <!-- back -->
        <div class="container">
            <div class="row fixed-bottom d-flex justify-content-center ps-2">
                <div class="col">
                    <a href="/" class="btn btn-outline-dark rounded-circle mb-2 p-3">
                        <span class="small font-weight-bold">Main</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
