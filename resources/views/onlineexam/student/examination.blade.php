@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('online.student.index') }}" class="nav-link border border-bottom-0 rounded py-3 text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 text-light rounded bg-primary text-light py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body d-grid gap-3">
                    <div class="card border-warning">
                        <div class="card-header border-bottom border-warning">{{ __('Examination Summary') }}</div>
                        <div class="card-body">
                            {{-- name --}}
                            <div class="row justify-content-center pb-3">
                                <div class="col-md-11">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 d-grid pb-md-0 pb-3">
                                            <div>
                                                <span class="fw-bold">{{ __('Name: ') }}</span>
                                                @php
                                                    $user = auth::user()->userprofile;
                                                @endphp
                                                {{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ __('Course: ') }}</span><span>{{ Session::get('course')->course }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <div><span class="fw-bold">{{ __('Examination Code: ') }}</span>{{ $exams[0]->exam_code }}</div>
                                            </div>
                                            <div>
                                                <div><span class="fw-bold">{{ __('Time Limit: ') }}</span>{{ $exams[0]->timer }} {{ __('minutes') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <label class="fw-bold pb-2">{{ __('Subject: ') }}{{ $exams[0]->subject }}</label>
                                    <form method="POST" action="{{ route('online.student.exam.save') }}" id="examForm">
                                        @csrf
                                        <input type="hidden" name="facultyID" value="{{ $exams[0]->user_id }}">
                                        <input type="hidden" name="exams_id" value="{{ $exams[0]->id }}">
                                        @isset($questions)
                                            @php 
                                                $qNum = 0;
                                                $selNum = 0;
                                            @endphp

                                            @foreach($questions as $question)
                                                @php 
                                                    $qNum++; 
                                                    $selNum = 0;
                                                @endphp
                                                <div class="fw-bold">{{ $qNum }}. {{ $question->question }}</div>

                                                @foreach($question->examselection as $selection)
                                                     @php 
                                                        $selNum++; 
                                                    @endphp
                                                    <div class="form-check ps-5">
                                                        <input class="form-check-input" type="radio" name="{{ $question->id }}" value="{{ $selection->selection }}" id="{{ $question->id }}{{ $selNum }}">
                                                        <label class="form-check-label" for="{{ $question->id }}{{ $selNum }}">
                                                            {{ $selection->selection }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endisset
                                        <div class="form-group d-flex justify-content-center py-3">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary px-md-5" id="submitBtn">{{ __('Submit') }}</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <div class="container">
                        <x-footerexam :color="'text-light'"/>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- modal/overlay -->
<div class="modal pt-5">
    <div class="modal-dialog">
        <div class="modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary"> 
                    <span class="text-light">{{ __('Examination') }}</span>
                    <a href="javascript:void(0);" id="closeDialog" class="ms-auto">
                        <i class="fa fa-times fa-lg text-light" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center pb-3">
                        <div class="fw-bold fs-5" id="modalBody"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-success px-md-5 px-2" id="yesBtn">{{ __('Yes') }}</a>
                    </div>
                </div>
                <div class="modal-footer bg-primary text-light">
                    {{ __('Laravel') }} {{ app()->version() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="border rounded bg-light fixed-bottom text-center" style="width: 150px;">
    <div class="fw-bold">{{ __('Exam time left :') }}</div>
    <div class="fs-1 fw-bold" id="outputtimer"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var user_id = '{{ auth()->user()->id }}';
        var exam_id = '{{ $exams[0]->id }}';
        var timer = '{{ $exams[0]->timer }}';
        var examForm = $('#examForm');
        var submitBtn = $('#submitBtn');
        var modalBody = $('#modalBody');
        var modal = $('.modal');
        var closeDialog = $('#closeDialog');
        var yesBtn = $('#yesBtn');
        var elapsed, storedTime = 0;

    
        if (localStorage.getItem('user_id') === null && localStorage.getItem('exam_id') === null) {
            localStorage.setItem('user_id', user_id);
            localStorage.setItem('exam_id', exam_id);
            localStorage.setItem('timer', timer);
        }
        else {
            storedTime = localStorage.getItem('timer');
        }

        $(submitBtn).on('click', function () {
            $(modalBody).html('Done with the exam? Are you sure?');
            $(modal).show();
        });

        $(closeDialog).on('click', function() {
            $(modal).hide();
        });

        $(yesBtn).on('click', function () {
            localStorage.clear();
            $(examForm).submit();
        });

        if (parseInt(storedTime) > 0) {
            elapsed = storedTime;
        }
        else {
            elapsed = parseInt(timer) * 60;
        }

        let examtimer = setInterval(function() {
            elapsed -= 1;
            localStorage.setItem('timer', elapsed);
            $('#outputtimer').html(Math.floor(elapsed / 60) + ":" + (elapsed % 60 ? elapsed % 60 : '00'));
            
            if(elapsed === 0){
                clearInterval(examtimer);
                localStorage.clear();
                $(examForm).submit();
            }
        }, 1000);
    });
</script>
@endsection
