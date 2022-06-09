<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Consolidated system using laravel PHP framework.">
    <meta name="keywords" content="Consolidated System, Laravel, genesedan">
    <meta name="author" content="Gene Arthur Sedan">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Laravel Web App v2.0') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/resources/css/app.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="app">
        @guest     
            <main class="py-4 min-vh-100 d-flex align-items-center">
                @yield('content')
            </main>
        @else
            <main class="py-4">
                @yield('content')
            </main>
        @endguest
    </div> 

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var capslock = $('#capslock');

            $('#password, #username').on('keypress', function(e){
                var s = String.fromCharCode( e.which );
                if (( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey )
                ||  ( s.toLowerCase() === s && s.toUpperCase() !== s && e.shiftKey )) {
                    $(capslock).css('background-color', '#0f0');
                }
                else {
                    $(capslock).css('background-color', '#fff');   
                }
            });

            $('#dwnlink').on('click', function() {
                $('.modal').show();
            });

            $('#closebtn').on('click', function() {
                $('.modal').hide();
            });

            PayPal.Donation.Button({
                env:'production',
                hosted_button_id:'RTNBQFUDN867N',
                image: {
                    src:'https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif',
                    alt:'Donate with PayPal button',
                    title:'PayPal - The safer, easier way to pay online!',
                }
            }).render('#donate-button');
        });
    </script>
</body>
</html>
