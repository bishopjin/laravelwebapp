@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container pt-4" id="app">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-light">{{ __('Edit Profile') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.user.update', ['profile' => $profile, 'user' => $userDetails->id]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <label for="firstname" class="">{{ __('First Name') }}</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ $userDetails->firstname }}" required autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <label for="middlename" class="">{{ __('Middle Name') }}</label>
                                <input id="middlename" type="text" class="form-control" name="middlename" value="{{ $userDetails->middlename }}">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <label for="lastname" class="">{{ __('Last Name') }}</label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ $userDetails->lastname }}" required>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($profile == 'student')
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-10">
                                    <label for="course">{{ __('Course') }}</label>
                                    <select class="form-select" name="online_course_id" id="course">
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if(Auth::user()->online_course_id === $course->id) selected @endif>{{ $course->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="DOB" class="">{{ __('Date of Birth') }}</label>
                                        <input id="DOB" type="date" class="form-control @error('DOB') is-invalid @enderror" 
                                            name="DOB" value="{{ date('Y-m-d', strtotime($userDetails->DOB)) }}" required/>

                                        @error('DOB')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="pb-md-1">{{ __('Gender') }}</label>
                                        <div class="row">
                                            <div class="col-6 d-flex align-items-center justify-content-md-around">
                                                <label class="">Male</label>&nbsp;
                                                <input id="male" type="radio" class="" name="gender_id" value="1" @if($userDetails->gender_id === 1) checked @endif>
                                            </div>
                                            <div class="col-6 d-flex align-items-center justify-content-md-around">
                                                <label class="">Female</label>&nbsp;
                                                <input id="female" type="radio" name="gender_id" value="2" @if($userDetails->gender_id === 2) checked @endif>
                                            </div>
                                        </div>
                                        @error('gender_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <label for="email" class="">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $userDetails->email }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3 justify-content-center pt-3">
                            <div class="col-md-10 d-flex justify-content-between align-items-center">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-info">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
@endsection
