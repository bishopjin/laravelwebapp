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
                @yield('content')
            </main>
        @else
            <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
                <div class="container">
                    @php
                        if(Auth::user()->access_level === 1)
                        {
                            $route_name = 'admin.index';
                        }
                        elseif(Auth::user()->access_level === 2)
                        {
                            $route_name = 'faculty.index';
                        }
                        else { $route_name = 'student.index'; }
                    @endphp
                    <a class="navbar-brand me-4" href="{{ route($route_name) }}">
                        {{ __('Online Examination - Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto d-block d-md-none">
                            @if(Auth::user()->access_level === 1)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownSettings" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ __('Maintenance') }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left mt-1 border-0 bg-primary" aria-labelledby="navbarDropdownSettings">
                                        <a class="dropdown-item" href="{{ route('admin.index') }}">
                                            {{ __('Dashboard') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('course.show') }}">
                                            {{ __('Courses') }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @if(Auth::user()->access_level === 1 OR Auth::user()->access_level === 3)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownSettings" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ __('Examination') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-left mt-1 border-0 bg-primary" aria-labelledby="navbarDropdownSettings">
                                        <a class="dropdown-item" href="#">
                                            {{ __('New Examination') }}
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            {{ __('Exam Result') }}
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if(Auth::user()->access_level === 1 OR Auth::user()->access_level === 2)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownSettings" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ __('Maintenance') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-left mt-1 border-0 bg-primary" aria-labelledby="navbarDropdownSettings">
                                        <a class="dropdown-item" href="#">
                                            {{ __('Student List') }}
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            {{ __('Examination List') }}
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i> &nbsp; {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right mt-1 border-0 bg-primary" aria-labelledby="navbarDropdown">
                                    @php
                                        if(Auth::user()->access_level === 1)
                                        {
                                            $profile_route = 'admin.profile.edit';
                                        }
                                        elseif(Auth::user()->access_level === 2)
                                        {
                                            $profile_route = 'faculty.profile.edit';
                                        }
                                        else { $profile_route = 'student.profile.edit'; }
                                    @endphp
                                    <a class="dropdown-item" href="{{ route($profile_route, Auth::user()->id) }}">
                                        <i class="fa fa-cog" aria-hidden="true"></i> &nbsp; {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        @endguest
        <!-- back -->
        <div class="container">
            <div class="row fixed-bottom d-flex justify-content-center ps-2">
                <div class="col">
                    <a href="/" class="btn btn-outline-light rounded-circle mb-2 p-3">
                        <span class="small font-weight-bold">Main</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
