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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/resources/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style="background-color: #C8C8C8;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light sticky-top shadow-sm payroll-nav-bg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('payroll.dashboard.index') }}">
                    {{ ('Payroll System - Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- mobile Navbar -->
                    <div class="navbar-nav me-auto d-md-none d-lg-none d-sm-block">
                        <ul class="list-unstyled">
                            @if (session('user_access') == '1') 
                                <li class="">
                                    <a href="{{ route('payroll.admin.deduction.index') }}" class="payroll-mobile-link">{{ __('Deduction') }}</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('payroll.admin.addition.index') }}" class="payroll-mobile-link">{{ __('Addition') }}</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('payroll.admin.salarygrade.index') }}" class="payroll-mobile-link">{{ __('Salary Grade') }}</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('payroll.admin.holiday.index') }}" class="payroll-mobile-link">{{ __('Holiday') }}</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('payroll.admin.user.index') }}" class="payroll-mobile-link">{{ __('Employee') }}</a>
                                </li>
                            @else
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('') }}</a>
                                </li>
                            @endif
                            <li class="d-md-none d-lg-none d-sm-block">
                                @if (session('user_access') == '1')
                                    <a class="payroll-mobile-link" href="{{ route('payroll.admin.password.index') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                @else
                                    <a class="payroll-mobile-link" href="{{ route('payroll.employee.password.index') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                @endif
                                <a class="payroll-mobile-link" href="{{ route('home') }}">
                                    {{ __('Home') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Left Side Of Navbar -->
                    <!-- employee -->
                    @if (session('user_access') == '2') 
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Attendance') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Home') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    <!-- end of employee -->
                    <!-- admin -->
                    @else 
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown ">
                                <a id="navbarDropdownAdmin1" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Maintenance') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin1">
                                    <a class="dropdown-item" href="{{ route('payroll.admin.deduction.index') }}">
                                        {{ __('Deduction') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('payroll.admin.addition.index') }}">
                                        {{ __('Addition') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('payroll.admin.salarygrade.index') }}">
                                        {{ __('Salary Grade') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('payroll.admin.holiday.index') }}">
                                        {{ __('Holiday') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin2" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Employee') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin2">
                                    <a class="dropdown-item" href="{{ route('payroll.admin.user.index') }}">
                                        {{ __('Add') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endif
                    <!-- end admin -->
                    <!-- End Left side -->
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto me-5 d-none d-md-block d-lg-block">
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdownEmployee" class="nav-link dropdown-toggle" href="#" role="button" 
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> &nbsp;{{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownEmployee">
                                @if (session('user_access') == '1') 
                                    <a class="dropdown-item" href="{{ route('payroll.admin.password.index') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ route('payroll.employee.password.index') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Main -->
        <main class="py-4">
            @yield('payrollcontent')
        </main>
    </div>
    <script src="{{ asset('public/js/app.js') }}" defer></script>
</body>
</html>
