<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Inventory system using laravel PHP framework.">
    <meta name="keywords" content="Inventory System, Laravel, genesedan">
    <meta name="author" content="Gene Arthur Sedan">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Inventory System - Laravel') }} &nbsp; {{ app()->version() }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
    
</head>
<body>
    <noscript>
        <div class="fw-bold h4 d-flex justify-content-center pt-3">
            <span class="text-danger p-4 border rounded shadow">
                {{ __('This web app requires javascript, dont block javascript from your web browser.') }}
            </span>
        </div>
    </noscript>
    <div id="customApp">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" 
                    href="{{ url('/inventory/') }}">
                    {{ ('Inventory System - Laravel') }} &nbsp; {{ app()->version() }}
                </a>
                <button class="navbar-toggler" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" 
                    aria-expanded="false" 
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" 
                    id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <div class="navbar-nav me-auto d-md-none d-lg-none d-sm-block">
                        <ul class="list-unstyled fw-bolder">
                            <li class="">
                                <a href="{{ route('inventorydashboard.index') }}" 
                                    class="sidebar-link">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ route('deliver.index') }}" 
                                    class="sidebar-link">
                                    {{ __('Receive Item') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ route('order.index') }}" 
                                    class="sidebar-link">
                                    {{ __('Order Item') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ route('product.create') }}" 
                                    class="sidebar-link">
                                    {{ __('New Product') }}
                                </a>
                            </li>
                            @hasrole('Admin')
                                <li class="">
                                    <a href="{{ route('employeelogs.index') }}" 
                                        class="sidebar-link">
                                        {{ __('Employee Logs') }}
                                    </a>
                                </li>
                            @endhasrole
                            <li class="d-md-none d-lg-none d-sm-block">
                                <a class="sidebar-link" 
                                    href="{{ route('index') }}">
                                    {{ __('Home') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto me-5 d-none d-md-block d-lg-block">
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdown" 
                                class="nav-link dropdown-toggle" 
                                href="#" role="button" 
                                data-bs-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false" 
                                v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" 
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" 
                                    href="{{ route('index') }}">
                                    {{ __('Home') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="list-unstyled fw-bolder">
                <li class="">
                    <a href="{{ route('inventorydashboard.index') }}" 
                        class="sidebar-link @if(Route::current()->getName() === 'inventorydashboard.index') selected-link @endif">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @if(Route::current()->getName() === 'product.index')
                    <li class="">
                        <a href="#" 
                            class="sidebar-link selected-link">
                            {{ __('Inventory') }}
                        </a>
                    </li>
                @endif
                <li class="">
                    <a href="{{ route('deliver.index') }}" 
                        class="sidebar-link @if(Route::current()->getName() === 'deliver.index') selected-link @endif">
                        {{ __('Receive Item') }}
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('order.index') }}" 
                        class="sidebar-link @if(Route::current()->getName() === 'order.index') selected-link @endif">
                        {{ __('Order Item') }}
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('product.create') }}" 
                        class="sidebar-link @if(Route::current()->getName() === 'product.create') selected-link @endif">
                        {{ __('New Product') }}
                    </a>
                </li>
                @hasrole('Admin')
                    <li class="">
                        <a href="{{ route('employeelogs.index') }}" 
                            class="sidebar-link @if(Route::current()->getName() === 'employeelogs.index' || Route::current()->getName() === 'employee.edit') selected-link @endif">
                            {{ __('Employee Logs') }}
                        </a>
                    </li>
                @endhasrole
                <li class="d-md-none d-lg-none d-sm-block">
                    <a class="sidebar-link" href="{{ route('index') }}">
                        {{ __('Home') }}
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main -->
        <main class="main">
            <v-app>
                @yield('inventorycontent')
            </v-app>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('/customjs/customjs.js') }}"></script>
</body>
</html>
