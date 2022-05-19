@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row">
            <div class="col">
                <!-- <h4>{{ __('Hello') }}&nbsp;{{ Auth::user()->username ?? __('Guest') }}</h4> -->
                <h4 class="navbar-nav nav-item dropdown">
                    {{ __('Hello') }}
                    <div class="d-flex align-items-baseline">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username ?? __('Guest') }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;{{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </h4>
            </div>
        </div>

        <div class="row py-4">
            <div class="col">
                <div class="h3 text-center">{{ __('Select Application') }}</div>
            </div>
        </div>

        <div class="row justify-content-center pb-3">
            <div class="col-md-4 pb-md-0 pb-3">
                <div class="card shadow">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-database" aria-hidden="true"></i>&nbsp;
                        {{ __('Inventory System') }}
                    </h4>   
                    
                    <div class="card-body">
                        {{ __('Inventory web application capability:') }}<br>
                        &nbsp; {{ __('- View item inventory') }}<br>
                        &nbsp; {{ __('- Add new item') }}<br>
                        &nbsp; {{ __('- Add new stock') }}<br>
                        &nbsp; {{ __('- Get/Request stock') }}<br>
                        &nbsp; {{ __('- View Employee Logs') }}<br>
                        &nbsp; {{ __('- Edit employee access') }}<br>
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Log In as:') }}</div>
                        <div class="d-flex justify-content-md-between flex-md-row flex-column gap-2">
                            <a href="{{ route('app.access', ['urlPath' => 'inventory', 'accessLevel' => '1']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Admin') }}
                            </a>
                            <a href="{{ route('app.access', ['urlPath' => 'inventory', 'accessLevel' => '2']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Non-Admin') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4  pb-md-0 pb-3">
                <div class="card shadow">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-desktop" aria-hidden="true"></i>&nbsp;
                        {{ __('Online Examination System') }}
                    </h4>   
                    
                    <div class="card-body">
                        {{ __('Under development') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Log In as:') }}</div>
                        <div class="d-flex justify-content-md-between flex-md-row flex-column gap-2">
                            <a href="#" class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Admin') }}
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Faculty') }}
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Student') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4 pb-md-0 pb-3">
                <div class="card shadow">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;
                        {{ __('Menu Ordering System') }}
                    </h4>   
                    
                    <div class="card-body">
                        {{ __('Under Development') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Proceed:') }}</div>
                        <div class="d-flex">
                            <a href="#" class="btn btn-outline-primary w-100 rounded-pill">
                                {{ __('Dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <div class="row">
            <div class="col d-flex justify-content-md-between flex-md-row flex-column gap-2">
                <span>&copy;&nbsp;{{ __('genesedan') }}&nbsp;{{ date('Y') }}</span>
                <span>{{ __('Last Updated : 05-19-2022') }}</span>
            </div>
        </div>
    </div>
@endsection