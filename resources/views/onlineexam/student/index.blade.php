@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li> -->
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
                                        <div class="col-md-6 d-grid pb-md-0 pb-3 d-flex">
                                            <div>
                                                <div class="pb-2">
                                                    <span class="fw-bold">{{ __('Name: ') }}</span>
                                                    @php
                                                        $user = auth::user()->userprofile;
                                                    @endphp
                                                    {{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold">{{ __('Course: ') }}</span><span>{{ $course['course'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{ route('online.student.exam') }}">
                                                @csrf
                                                <label class="fw-bold pb-2">{{ __('Examination Code') }}</label>
                                                <div class="form-group">
                                                    <div class="pb-2">
                                                        <input type="text" name="exam_code" value="{{ old('exam_code') }}" autofocus=""
                                                            class="form-control @error('exam_code') is-invalid @enderror @error('exam_taken') is-invalid @enderror">
                                                        @error('exam_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        @error('exam_taken')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <input type="submit" value="Submit" class="btn btn-outline-primary px-md-5">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            {{-- exam result --}}
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    @if($exam_result->count() > 0)
                                        @foreach($exam_result as $score)
                                            <div class="row justify-content-center border border-warning rounded p-3 mb-2">
                                                <div class="col-md-6 d-grid gap-2 pb-md-0 pb-2">
                                                    <div class="fw-bolder">
                                                        <span class="">{{ __('Exam Code: ') }}</span>
                                                        <span class="text-info">{{ $score->onlineexam->exam_code }}</span>
                                                    </div>
                                                    <div class="fw-bolder">
                                                        @foreach($subjects as $subject)
                                                            @if($subject->id == $score->onlineexam->id)
                                                                <span class="">{{ __('Subject: ') }}</span>
                                                                {{ $subject->onlinesubject->subject }}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-grid gap-2">
                                                    <div class="fw-bolder">
                                                        <span class="">{{ __('Score: ') }}</span>
                                                        {{ $score->exam_score }} / {{ $score->total_question }}
                                                    </div>
                                                    <div class="fw-bolder">
                                                        <span class="">{{ __('Rating: ') }}</span>
                                                        @if($score->exam_score < $score->total_question / 2)
                                                            <span class="text-danger">{{ __('FAILED') }}</span>
                                                        @else
                                                            <span class="text-success">{{ __('PASSED') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row justify-content-center">
                                            <div class="col-md-11 py-4 d-flex justify-content-center fw-bold">
                                                {{ __('No Examination Result') }}
                                            </div>
                                        </div>
                                    @endif
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
                    <span class="text-light">{{ __('Edit Subject') }}</span>
                    <a href="javascript:void(0);" id="closeDialog" class="ms-auto">
                        <i class="fa fa-times fa-lg text-light" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer bg-primary text-light">
                    {{ __('Laravel') }} {{ app()->version() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var modal = $('.modal');
        $('#closeDialog').on('click', function(){
            $(modal).hide();
        });

        $('.editSubject').on('click', function() {
            $(modal).show();
            $('#editID').val(this.id);
            $('#subjectname').val($('#subject' + this.id).html());
        });
    });
</script>
@endsection
