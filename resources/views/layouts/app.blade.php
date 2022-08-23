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

    <title>{{ ('Laravel Web App v2.0.9') }}</title>
    
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9822106822353440"
     crossorigin="anonymous"></script>
</head>
<body>
    <noscript>
        <div class="fw-bold h4 d-flex justify-content-center pt-3">
            <span class="text-danger p-4 border rounded shadow">{{ __('This web app requires javascript, dont block javascript from your web browser.') }}</span>
        </div>
    </noscript>
    <div>
        @guest     
            <main class="min-vh-100 d-flex align-items-center">
                @yield('content')
            </main>
        @else
            <main class="py-4">
                @yield('content')
            </main>
        @endguest
    </div> 
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    
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
