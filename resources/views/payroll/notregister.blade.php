<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Payroll system using laravel PHP framework.">
    <meta name="keywords" content="Payroll System, Laravel, genesedan">
    <meta name="author" content="Gene Arthur Sedan">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Payroll System - Laravel') }} &nbsp; {{ app()->version() }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>
</head>
<body style="background-color: #C8C8C8;">
    <noscript>
        <div class="fw-bold h4 d-flex justify-content-center pt-3">
            <span class="text-danger p-4 border rounded shadow">
                {{ __('This web app requires javascript, dont block javascript from your web browser.') }}
            </span>
        </div>
    </noscript>
   	<div class="container">
		<div class="row min-vh-100 d-flex justify-content-center align-items-center">
			<div class="col-md-10">
				<div class="card shadow border rounded text-center">
					<div class="card-body py-4">
						<div class="h4 fw-bold">
							{{ __('User is not registered in the payroll.') }}
						</div>
						<div class="text-center">
							<div>
                                {{ __('Ask admin user to register your account in the payroll system.') }}
                            </div>
							<a href="{{ route('index') }}" 
                                class="text-decoration-none fw-bold pt-3">
                                {{ __('Home') }}
                            </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div>
</body>
</html>