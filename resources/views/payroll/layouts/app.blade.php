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
</head>
<body style="background-color: #C8C8C8;">
    <noscript>
        <div class="fw-bold h4 d-flex justify-content-center pt-3">
            <span class="text-danger p-4 border rounded shadow">{{ __('This web app requires javascript, dont block javascript from your web browser.') }}</span>
        </div>
    </noscript>
    <div id="">
        <nav class="navbar navbar-expand-md navbar-light sticky-top shadow-sm payroll-nav-bg">
            <div class="container">
                <span class="navbar-brand pe-4">
                    {{ ('Payroll System - Laravel') }}
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- mobile Navbar -->
                    <div class="navbar-nav me-auto d-md-none d-lg-none d-sm-block">
                        <ul class="list-unstyled">
                            @if(Auth::user()->can('payroll admin access') AND str_contains(url()->current(), 'payroll/payrolladmin'))
                                <li class="">
                                    <a class="payroll-mobile-link" href="{{ route('payrolladmin.index') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Deduction') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Addition') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Salary Grade') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Holiday') }}</a>
                                </li>
                                <li>
                                    <a href="#" class="payroll-mobile-link">{{ __('Work Schedule') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Register') }}</a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Attendance Change Request') }}</a>
                                </li>
                            @elseif(Auth::user()->can('payroll employee access'))
                                <li class="">
                                    <a class="payroll-mobile-link" href="{{ route('payrollemployee.index') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#" class="payroll-mobile-link">{{ __('Daily Time Recorder') }}</a>
                                </li>
                                <li class="">
                                    <a class="payroll-mobile-link" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#laModal">
                                        {{ __('Payslip') }}
                                    </a>
                                    {{-- <a href="#" class="payroll-mobile-link">{{ __('Payslip') }}</a> --}}
                                </li>
                            @endif
                            <li>
                                <a class="payroll-mobile-link" href="{{ route('changepassword.create') }}">
                                    {{ __('Change Password') }}
                                </a>
                            </li>
                            <li>
                                <a class="payroll-mobile-link" href="/">
                                    {{ __('Home') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Left Side Of Navbar -->
                    <!-- employee -->
                    @if(Auth::user()->can('payroll employee access') AND str_contains(url()->current(), 'payroll/payrollemployee')) 
                        <a class="navbar-nav text-decoration-none d-none d-md-block d-lg-block text-dark pe-2" 
                            href="{{ route('payrollemployee.index') }}">
                            {{ ('Dashboard') }}
                        </a>
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Attendance') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="#">
                                        {{ __('Daily Time Recorder') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Payslip') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#laModal">
                                        {{ __('View') }}
                                    </a>
                                    {{-- <a class="dropdown-item" href="#">
                                        {{ __('View') }}
                                    </a> --}}
                                </div>
                            </li>
                        </ul>
                    <!-- end of employee -->
                    <!-- admin -->
                    @elseif(Auth::user()->can('payroll admin access'))
                        <a class="navbar-nav text-decoration-none d-none d-md-block d-lg-block text-dark pe-2" 
                            href="{{ route('payrolladmin.index') }}">
                            {{ ('Dashboard') }}
                        </a>
                        <ul class="navbar-nav d-none d-md-block d-lg-block">
                            <li class="nav-item dropdown ">
                                <a id="navbarDropdownAdmin1" class="nav-link dropdown-toggle" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ __('Maintenance') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-2 payroll-nav-bg" aria-labelledby="navbarDropdownAdmin1">
                                    <a class="dropdown-item" href="#">
                                        {{ __('Deduction') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Addition') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Salary Grade') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Holiday') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Work Schedule') }}
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
                                    <a class="dropdown-item" href="#">
                                        {{ __('Register') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        {{ __('Attendance Change Request') }}
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
                                <a class="dropdown-item" href="{{ route('changepassword.create') }}">
                                    {{ __('Change Password') }}
                                </a>
                                <a class="dropdown-item" href="/">
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
        <!-- modal -->
        <div class="modal pt-2 pt-md-5 fade" role="dialog" aria-labelledby="aModalLabel" aria-hidden="true" id="laModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header h5">{{ __('404') }}</div>
                    <div class="modal-body h4">
                        {{ __('Sorry, application under development.') }}
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
