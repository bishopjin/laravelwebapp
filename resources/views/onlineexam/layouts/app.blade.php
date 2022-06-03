<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Online examination using laravel PHP framework.">
    <meta name="keywords" content="Online Examination, Online Quiz, Laravel, genesedan">
    <meta name="author" content="Gene Arthur Sedan">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Online Examination - Laravel') }} &nbsp; {{ app()->version() }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9822106822353440"
     crossorigin="anonymous"></script>
</head>
<body style="background-color: #E64A19;">
    <div>
        @guest
            <main class="py-4 min-vh-100 d-flex align-items-center">
                @yield('onlinecontent')
            </main>
        @else
            <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
                <div class="container">
                    @php
                        if(session('user_access') == '1')
                        {
                            $route_name = 'online.admin.index';
                        }
                        elseif(session('user_access') == '2')
                        {
                            $route_name = 'online.faculty.index';
                        }
                        else 
                        { 
                            $route_name = 'online.student.index';
                        }
                    @endphp
                    <a class="navbar-brand me-4" href="{{ route($route_name) }}">
                        {{ __('Online Examination - Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- mobile -->
                        @if(session('user_access') == '1')
                            <div class="d-block d-md-none mt-1 bg-primary">
                                <a class="dropdown-item" 
                                    href="@if(Route::current()->getName() === 'online.admin.index') # @else {{ route('online.admin.index') }} @endif">
                                    {{ __('Dashboard') }}
                                </a>
                                <a class="dropdown-item" 
                                    href="@if(Route::current()->getName() === 'online.course.show') # @else {{ route('online.course.show') }} @endif">
                                    {{ __('Courses') }}
                                </a>
                            </div>
                        @endif
                        @if(session('user_access') == '3')
                            <div class="d-block d-md-none mt-1 bg-primary">
                                <a class="dropdown-item" 
                                    href="@if(Route::current()->getName() === 'online.student.index') # @else {{ route('online.student.index') }} @endif">
                                    {{ __('Exam Result') }}
                                </a>
                            </div>
                        @endif
                        @if(session('user_access') == '2')
                            <div class="d-block d-md-none mt-1 bg-primary">
                                <a class="dropdown-item" 
                                    href="@if(Route::current()->getName() === 'online.faculty.index') # @else {{ route('online.faculty.index') }} @endif">
                                    {{ __('Student List') }}
                                </a>
                                <a class="dropdown-item" 
                                    href="@if(Route::current()->getName() === 'online.exam.show') # @else {{ route('online.exam.show') }} @endif">
                                    {{ __('Examination List') }}
                                </a>
                            </div>
                        @endif
                        <div class="d-block d-md-none mt-1 bg-primary">
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; {{ __('Home') }}
                            </a>
                        </div>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto d-none d-md-block">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i> &nbsp; {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-1 border-0 bg-primary" aria-labelledby="navbarDropdown">
                                    @php
                                        if(session('user_access') == '1')
                                        {
                                            $profile_route = 'online.admin.profile.edit';
                                        }
                                        elseif(session('user_access') == '2')
                                        {
                                            $profile_route = 'online.faculty.profile.edit';
                                        }
                                        else 
                                        { 
                                            $profile_route = 'online.student.profile.edit'; 
                                        }
                                    @endphp
                                    <a class="dropdown-item" href="{{ route($profile_route, Auth::user()->id) }}">
                                        <i class="fa fa-cog" aria-hidden="true"></i> &nbsp; {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; {{ __('Home') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('onlinecontent')
            </main>
        @endguest
    </div>
</body>
</html>
