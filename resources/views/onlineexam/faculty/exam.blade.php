@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" 
                style="margin-bottom : -15px;">

                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('facultyexam.index') }}" 
                            class="nav-link border border-bottom-0 rounded py-3 text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subjectexam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Subject') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 text-light bg-primary rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <create-examination-form
                                :subject-list="{{ $subjectList }}"
                                :post-url="'{{ route('exam.store') }}'"
                                :csrf-token="'{{ csrf_token() }}'"
                            ></create-examination-form>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <div class="container">
                        <x-footerexam color="text-light"></x-footerexam>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
