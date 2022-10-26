@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" 
                style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body d-grid gap-3">
                    <div class="card border-warning">
                        <div class="card-header border-bottom border-warning">
                            {{ __('Examination Summary') }}
                        </div>
                        <div class="card-body">
                            {{-- name --}}
                            <div class="row justify-content-center pb-3">
                                <div class="col-md-11">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 d-grid pb-md-0 pb-3 d-flex">
                                            <div>
                                                <div class="pb-2">
                                                    <span class="fw-bold">
                                                        {{ __('Name: ') }}
                                                    </span>
                                                    {{ Auth::user()->full_name }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold">
                                                        {{ __('Course: ') }}
                                                    </span>
                                                    <span>
                                                        {{ $course }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <student-exam-code-component
                                                url="online-exam/studentexam/"
                                                :user-id="{{ auth()->user()->id }}"
                                            ></student-exam-code-component>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            {{-- exam result --}}
                            <div class="row justify-content-center">
                                <div class="col-md-11">

                                    @forelse($examResult as $score)
                                        <div class="row justify-content-center border border-warning rounded p-3 mb-2">
                                            <div class="col-md-6 d-grid gap-2 pb-md-0 pb-2">
                                                <div class="fw-bolder">
                                                    <span>
                                                        {{ __('Exam Code: ') }}
                                                    </span>
                                                    <span class="text-info">
                                                        {{ $score->onlineexam->exam_code }}
                                                    </span>
                                                </div>
                                                <div class="fw-bolder">
                                                    @foreach($subjects as $subject)
                                                        @if($subject->id == $score->onlineexam->id)
                                                            <span class="">
                                                                {{ __('Subject: ') }}
                                                            </span>
                                                            {{ $subject->onlinesubject->subject }}
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-grid gap-2">
                                                <div class="fw-bolder">
                                                    <span>
                                                        {{ __('Score: ') }}
                                                    </span>
                                                    {{ $score->exam_score }} / {{ $score->total_question }}
                                                </div>
                                                <div class="fw-bolder">
                                                    <span>
                                                        {{ __('Rating: ') }}
                                                    </span>

                                                    @if($score->exam_score < $score->total_question / 2)
                                                        <span class="text-danger">
                                                            {{ __('FAILED') }}
                                                        </span>
                                                    @else
                                                        <span class="text-success">
                                                            {{ __('PASSED') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row justify-content-center">
                                            <div class="col-md-11 py-4 d-flex justify-content-center fw-bold">
                                                {{ __('No Examination Result') }}
                                            </div>
                                        </div>
                                    @endforelse
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
