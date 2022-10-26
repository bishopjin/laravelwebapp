@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row">
            <div class="col">
                <div class="h5">
                    {{ __('Hello') }}
                    <div class="pt-2 d-flex">
                        <div class="d-flex gap-2 justify-content-md-around flex-md-row flex-column">
                            <div class="d-flex gap-1 align-items-center justify-content-md-center">
                                <i class="fa fa-user-circle" 
                                    aria-hidden="true">
                                </i>
                                {{ Auth::user()->username ?? __('Guest') }}
                            </div>
                            @hasrole('Super Admin')
                                <div class="pt-md-0 pt-1 small d-flex align-items-center justify-content-md-center">
                                    <a href="{{ route('userspermission.index') }}" 
                                        class="small text-decoration-none">
                                        {{ __('Permission') }}
                                    </a>
                                </div>
                            @endhasrole
                            <div class="pt-md-0 pt-1 small d-flex align-items-center">
                                <a class="small text-decoration-none" 
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" 
                                    action="{{ route('logout') }}" 
                                    method="POST" 
                                    class="d-none">

                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-2">
            <div class="col">
                <div class="h3 text-center">
                    {{ __('Laravel Web Application') }}
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center py-2">
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-database" 
                            aria-hidden="true">
                        </i>
                        &nbsp;
                        {{ __('Inventory System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">
                            {{ __('Inventory Feature:') }}
                        </span>
                        <br>
                        &nbsp; 
                        {{ __('- View item inventory') }}
                        <br>
                        &nbsp; 
                        {{ __('- Add new item') }}
                        <br>
                        &nbsp; 
                        {{ __('- Add new stock') }}
                        <br>
                        &nbsp; 
                        {{ __('- Get/Request stock') }}
                        <br>
                        &nbsp; 
                        {{ __('- View Employee Logs') }}
                        <br>
                        &nbsp; 
                        {{ __('- Edit employee access') }}
                        <br>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex">
                            @if(Auth::user()->hasAnyPermission(['inventory view user', 'inventory edit user', 'inventory add new item', 'inventory get stock', 'inventory add stock']))
                                <a href="{{ route('inventorydashboard.index') }}" 
                                    class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                    {{ __('Log In') }}
                                </a>
                            @else
                                <div class="fw-bold w-100 text-center py-2">
                                    {{ __('No Access') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4  pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-desktop" 
                            aria-hidden="true">
                        </i>
                        &nbsp;
                        {{ __('Online Examination System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">
                            {{ __('Online Examination Feature:') }}
                        </span> 
                        <br>
                        &nbsp; 
                        {{ __('- Create an online examination for the student.') }}
                        <br>
                        &nbsp; 
                        {{ __('- Faculty can create an examination form based on subject and generate an examination code.') }}
                        <br>
                        &nbsp; 
                        {{ __('- This code will serve as an access for the student to take the examination.') }}
                        <br>
                        &nbsp; 
                        {{ __('- Encrypted answer key, so only the creator of the exam knows the answer.') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">
                            {{ __('Log In as:') }}
                        </div>
                        <div class="d-flex gap-2 flex-md-row flex-column">
                            @if(Auth::user()->hasAnyPermission(['exam student access', 'exam faculty access', 'exam admin access']))
                                @can('exam admin access')
                                    <a href="{{ route('adminexam.index') }}" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Admin') }}
                                    </a>
                                @endcan

                                @can('exam faculty access')
                                    <a href="{{ route('facultyexam.index') }}" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Faculty') }}
                                    </a>
                                @endcan

                                @can('exam student access')
                                    <a href="{{ route('studentexam.index') }}" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Student') }}
                                    </a>
                                @endcan

                            @else
                                <div class="fw-bold w-100 text-center pb-2">
                                    {{ __('No Access') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-dollar"></i>
                        &nbsp;
                        {{ __('Payroll System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">
                            {{ __('Payroll Feature:') }}
                        </span>
                        <br>
                        &nbsp; 
                        {{ __('- Register User') }}
                        <br>
                        &nbsp; 
                        {{ __('- Maintenance for Salary Rate, etc.') }}
                        <br>
                        &nbsp; 
                        {{ __('- View/Print Payslip (Under development)') }}
                        <br>
                        &nbsp; 
                        {{ __('- Daily Time Recorder (Temporary Only)') }}
                        <br>
                        &nbsp; 
                        {{ __('- Auto compute manhour, late, night diff, etc..') }}
                        <br>
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">
                            {{ __('Log In as:') }}
                        </div>

                        <div class="d-flex gap-2 flex-md-row flex-column">
                            {{-- 
                            @if(Auth::user()->hasAnyPermission(['payroll admin access', 'payroll employee access']))
                                @can('payroll admin access')
                                    <a href="{{ route('payrolladmin.index') }}" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Admin') }}
                                    </a>
                                @endcan

                                @can('payroll employee access')
                                    <a href="{{ route('payrollemployee.index') }}" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Employee') }}
                                    </a>
                                @endcan
                            @else
                                <div class="fw-bold w-100 text-center pb-2">
                                    {{ __('No Access') }}
                                </div>
                            @endif
                            --}}
                            <strong class="text-danger">{{ __('Undergoing code and function enhancement') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- next row -->
        <div class="row justify-content-center py-2">
            <!--  -->
            <div class="col-md-4 pb-md-0 pb-3 d-flex">
                <div class="card shadow w-100">
                    <h4 class="card-header d-flex align-items-baseline">
                        <i class="fa fa-cutlery" 
                            aria-hidden="true">
                        </i>
                        &nbsp;
                        {{ __('Menu Ordering System') }}
                    </h4>   
                    
                    <div class="card-body">
                        <span class="fw-bold">
                            {{ __('Menu Ordering Feature:') }}
                        </span> 
                        <br>
                        &nbsp; 
                        {{ __('- Create order') }} 
                        <br>
                        &nbsp; 
                        {{ __('- Discount and tax applied to the order') }} 
                        <br>
                        &nbsp; 
                        {{ __('- Order history') }} 
                        <br>
                        &nbsp; 
                        {{ __('- Maintenance page for adding/modifying product, tax and discount.') }}
                    </div>

                    <div class="card-footer">
                        <div class="fw-bold pb-2">
                            {{ __('Log In as:') }}
                        </div>
                        <div class="d-flex gap-2 flex-md-row flex-column">
                            {{-- 
                            @if(Auth::user()->hasAnyPermission(['menu add item', 'menu edit item', 'menu view order list', 'menu view user list', 'menu create orders', 'menu view order history', 'menu view coupon list']))
                                @if(Auth::user()->hasAnyPermission(['menu add item', 'menu edit item', 'menu view order list', 'menu view user list']))
                                    <a href="menu-ordering/admin" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Admin') }}
                                    </a>
                                @endif

                                @if(Auth::user()->hasAnyPermission(['menu create orders', 'menu view order history', 'menu view coupon list']))
                                    <a href="menu-ordering/customer" 
                                        class="btn btn-outline-primary fw-bold rounded border-0 w-100">
                                        {{ __('Customer') }}
                                    </a>
                                @endif
                            @else
                                <div class="fw-bold w-100 text-center pb-2">
                                    {{ __('No Access') }}
                                </div>
                            @endif
                            --}}
                            <strong class="text-danger">{{ __('Undergoing code and function enhancement') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="col-md-4 pb-md-0 pb-3 d-flex"></div>
            <div class="col-md-4 pb-md-0 pb-3 d-flex"></div>
        </div>
        <hr>
        <!-- footer -->
        <div class="row">
            <div class="col d-flex justify-content-md-between flex-md-row flex-column gap-2">
                <span>
                    &copy;
                    &nbsp;
                    {{ __('genesedan') }}
                    &nbsp;
                    {{ date('Y') }}
                </span>
                <span>
                    {{ __('Last Updated : October 24, 2022') }}
                </span>
            </div>
        </div>   
    </div>

    <div class="modal pt-2 pt-md-5 fade" 
        role="dialog" 
        aria-labelledby="aModalLabel" 
        aria-hidden="true" 
        id="aModal" 
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header h5">
                    {{ __('404') }}
                </div>
                <div class="modal-body h4">
                    {{ __('Sorry, application under re-development.') }}
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" 
                        class="btn btn-outline-primary rounded-pill" 
                        data-bs-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection