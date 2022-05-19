@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('faculty.index') }}" class="nav-link border border-bottom-0 rounded py-3 text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subject.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Subject') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('exam.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 text-light bg-primary rounded py-3 px-5">
                            {{ __('Examination Result') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body">
                    <div class="row justify-content-center py-3">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">{{ __('Details') }}</div>
                                <div class="card-body">
                                    <div class="fw-bold fs-5">{{ __('Student Name: ') }}
                                        {{ $student_detail->lastname }}, {{ $student_detail->firstname }} {{ $student_detail->middlename }}
                                    </div>
                                    <hr>
                                    @foreach($exam_result as $result)
                                        <div class="p-2 mb-2 border border-warning rounded">
                                            <div>
                                                <span class="fw-bold">{{ __('Examination Code : ') }}</span> {{ $result->exam_code }}
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ __('Number of Question : ') }}</span> {{ $result->total_question }}
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ __('Examination Score : ') }}</span> {{ $result->exam_score }} 
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-md-5 px-2 my-2">{{ __('Back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <x-footer></x-footer>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection