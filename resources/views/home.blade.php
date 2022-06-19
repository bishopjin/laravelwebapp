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

        <div class="row pt-2">
            <div class="col">
                <div class="h3 text-center">{{ __('Laravel Web Application') }}</div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center py-2">
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100" id="project_1">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-database" aria-hidden="true"></i>&nbsp;
                        {{ __('Inventory System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">{{ __('Inventory Feature:') }}</span><br>
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
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100" id="project_2">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;
                        {{ __('Menu Ordering System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">{{ __('Menu Ordering Feature:') }}</span> <br>
                        &nbsp; <span class="text-success fw-bold">{{ __('- Single page web application') }}</span> <br>
                        &nbsp; {{ __('- Create order') }} <br>
                        &nbsp; {{ __('- Discount and tax applied to the order') }} <br>
                        &nbsp; {{ __('- Order history') }} <br>
                        &nbsp; {{ __('- Maintenance page for adding/modifying product, tax and discount.') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Log In as:') }}</div>
                        <div class="d-flex justify-content-md-between flex-md-row flex-column gap-2">
                            <a href="{{ route('app.access', ['urlPath' => 'menu-ordering', 'accessLevel' => '1']) }}"
                                class="btn btn-outline-primary w-100 rounded-pill">
                                {{ __('Admin') }}
                            </a>
                            <a href="{{ route('app.access', ['urlPath' => 'menu-ordering', 'accessLevel' => '2']) }}" 
                                class="btn btn-outline-primary w-100 rounded-pill">
                                {{ __('Customer') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4  pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100" id="project_3">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-desktop" aria-hidden="true"></i>&nbsp;
                        {{ __('Online Examination System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">{{ __('Online Examination Feature:') }}</span> <br>
                        &nbsp; {{ __('- Create an online examination for the student.') }}<br>
                        &nbsp; {{ __('- Faculty can create an examination form based on subject and generate an examination code.') }}<br>
                        &nbsp; {{ __('- This code will serve as an access for the student to take the examination.') }}<br>
                        &nbsp; {{ __('- Encrypted answer key, so only the creator of the exam knows the answer.') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Log In as:') }}</div>
                        <div class="d-flex justify-content-md-between flex-md-row flex-column gap-2">
                            <a href="{{ route('app.access', ['urlPath' => 'online-exam', 'accessLevel' => '1']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">{{ __('Admin') }}
                            </a>
                            <a href="{{ route('app.access', ['urlPath' => 'online-exam', 'accessLevel' => '2']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">{{ __('Faculty') }}
                            </a>
                            <a href="{{ route('app.access', ['urlPath' => 'online-exam', 'accessLevel' => '3']) }}" class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Student') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- next row -->
        <div class="row justify-content-center py-2">
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100" id="project_4">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-dollar"></i>&nbsp;
                        {{ __('Payroll System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">{{ __('Payroll Feature:') }}</span><br>
                        &nbsp; {{ __('- ') }}<br>
                        &nbsp; {{ __('- ') }}<br>
                        &nbsp; {{ __('- ') }}<br>
                        &nbsp; {{ __('- ') }}<br>
                        &nbsp; {{ __('- ') }}<br>
                        &nbsp; {{ __('- ') }}<br>
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">{{ __('Log In as:') }}</div>
                        <div class="d-flex justify-content-md-between flex-md-row flex-column gap-2">
                            <a href="{{ route('app.access', ['urlPath' => 'payroll', 'accessLevel' => '1']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Admin') }}
                            </a>
                            <a href="{{ route('app.access', ['urlPath' => 'payroll', 'accessLevel' => '2']) }}" 
                                class="btn btn-outline-primary rounded-pill w-100">
                                {{ __('Employee') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pb-md-0 pb-3 d-flex">

            </div>
            <div class="col-md-4 pb-md-0 pb-3 d-flex">

            </div>
        </div>
        <hr>
        <!-- footer -->
        <div class="row">
            <div class="col d-flex justify-content-md-between flex-md-row flex-column gap-2">
                <span>&copy;&nbsp;{{ __('genesedan') }}&nbsp;{{ date('Y') }}</span>
                <span>{{ __('Last Updated : 06-19-2022') }}</span>
            </div>
        </div>   
        <div class="row py-2 py-md-3">
            <div class="col-md-11">
                <span class="small">{{ __('Hosted : ') }} 
                    <a href="https://www.infinityfree.net/">{{ __('infinityfree.net') }}</a>
                </span> 
                <br>
                <span class="small">{{ __('SSL Certificate : ZeroSSL (Free)') }}</span>
            </div>
        </div>
    </div>

    <div class="modal pt-2 pt-md-5 fade" role="dialog" aria-labelledby="aModalLabel" aria-hidden="true" id="aModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header h5">{{ __('404') }}</div>
                <div class="modal-body h4">
                    {{ __('Sorry, application under re-development.') }}
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection