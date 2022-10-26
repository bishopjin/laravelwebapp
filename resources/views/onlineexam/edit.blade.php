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
                            class="nav-link border border-bottom-0 rounded py-3 text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('courseexam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Course') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5 bg-primary">
                            @php
                                $label = '';
                                $id = 0;
                                $name = '';
                                $route = '';
                                $value = '';

                                switch ($type) {
                                    case 'subject':
                                        $label = 'Subject';
                                        $id = $subject['id'];
                                        $name = 'subject';
                                        $route = 'adminexam.update';
                                        $value = $subject['subject'];
                                        break;

                                    default:
                                        $label = 'Course';
                                        $id = $course['id'];
                                        $name = 'course';
                                        $route = 'courseexam.update';
                                        $value = $course['course'];
                                }
                            @endphp
                            {{ __('Edit ').$label }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body d-grid gap-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <div class="card border-warning">
                                    <div class="card-header border-bottom border-warning">
                                        {{ $label }}
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" 
                                            class="p-md-4" 
                                            action="{{ route($route, $id) }}">

                                            @csrf
                                            @method('PUT')

                                            <div class="form-group mb-3">
                                                <input type="text" 
                                                    name="{{ $name }}" 
                                                    value="{{ $value }}" 
                                                    class="form-control" 
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-end">
                                                    <input type="submit" 
                                                        value="Save" 
                                                        class="btn btn-outline-primary">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
