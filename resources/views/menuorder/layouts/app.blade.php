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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <noscript>
        <div class="fw-bold h4 d-flex justify-content-center pt-3">
            <span class="text-danger p-4 border rounded shadow">{{ __('This web app requires javascript, dont block javascript from your web browser.') }}</span>
        </div>
    </noscript>
    <div id="app">
        <main>
            @yield('ordercontent')
        </main>
    </div> 
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
