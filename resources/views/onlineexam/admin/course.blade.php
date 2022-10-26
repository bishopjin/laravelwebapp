@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" 
                style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('adminexam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Course') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary text-light py-4"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <form method="POST" 
                                action="{{ route('courseexam.store') }}">
                                @csrf

                                <div class="row mb-3 justify-content-center">
                                    <div class="col">
                                        <div class="card border-warning">
                                            <div class="card-header border-bottom border-warning">
                                                {{ __('New Course') }}
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group py-2">
                                                    <label for="course" 
                                                        class="mb-2">
                                                        {{ __('Course') }}
                                                    </label>
                                                    <input id="course" 
                                                        type="text" 
                                                        class="form-control @error('course') is-invalid @enderror" 
                                                        name="course" value="{{ old('course') }}" 
                                                        required 
                                                        autofocus>

                                                    @error('course')
                                                        <span class="invalid-feedback" 
                                                            role="alert">
                                                            <strong>
                                                                {{ $message }}
                                                            </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group d-flex justify-content-end">
                                                    <button type="submit" 
                                                        class="btn btn-outline-primary">
                                                        {{ __('Save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>        
                        <div class="col-md-8">
                            
                            <x-datatable 
                                :data="$courseList" 
                                title="Course List" 
                                :header="['Course']" 
                                :tData="['course']"
                                :hasEditButton="true"
                                editLink="courseexam.edit"
                            ></x-datatable>

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
