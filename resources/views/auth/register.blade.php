@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <span>{{ __('Register') }}</span>
                    <span>{{ __('Laravel 8 Web Application v2.0') }}</span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="givenname" class="">{{ __('First Name') }}</label>
                                <input id="givenname" type="text" class="form-control @error('givenname') is-invalid @enderror" name="givenname" value="{{ old('givenname') }}" required autocomplete="givenname" autofocus>

                                @error('givenname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="middlename" class="">{{ __('Middle Name') }}</label>
                                <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" autocomplete="middlename">

                                @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="surname" class="">{{ __('Last Name') }}</label>
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname">

                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-6">
                                        <label for="DOB" class="">{{ __('Date of Birth') }}</label>
                                        <input id="DOB" type="date" class="form-control @error('DOB') is-invalid @enderror" name="DOB" value="{{ old('DOB') ?? date('Y-m-d') }}" required>

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
                                                <input id="male" type="radio" class="" name="gender" value="1" checked>
                                            </div>
                                            <div class="col-6 d-flex align-items-center justify-content-md-around">
                                                <label class="">Female</label>&nbsp;
                                                <input id="female" type="radio" name="gender" value="2">
                                            </div>
                                        </div>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="email" class="">{{ __('Email Address') }}</label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--  -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="username" class="">{{ __('Username') }}</label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="password" class="">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-9">
                                <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-9 d-flex justify-content-between align-items-baseline">
                                <a href=" {{ route('login') }} " class="fw-bold">Already registered?</a>
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <page-footer :current-date="'{{ date('Y') }}'" :urls="'https://www.genesedan.com/'"></page-footer>`
                </div>
            </div>
        </div>
    </div>
@endsection
