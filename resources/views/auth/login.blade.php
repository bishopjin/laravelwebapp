@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <span>{{ __('Login') }}</span> 
                    <span>{{ __('Laravel 8 Web Application v2.0') }}</span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-10">
                                <label for="username" class="">{{ __('Username') }}</label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror @error('inactive') is-invalid @enderror" 
                                    name="username" value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('inactive')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-10">
                                <label for="password" class="">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if(session('notactive'))
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <span class="text-danger fw-bolder justify-content-center">
                                        {{ session('notactive') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="row justify-content-center pb-2">
                            <div class="col-md-10 d-flex justify-content-end small">
                                <div class="small">
                                    <div class="small">
                                        <span class="fw-bold border rounded-pill small p-1" id="capslock">
                                            {{ __('CAPS LOCK') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-2 justify-content-center">
                            <div class="col-md-10 d-flex justify-content-between align-items-end">
                                <div class="d-flex flex-column">
                                    <a href=" {{ route('register') }} " class="fw-bold">{{ __('Create Account') }}</a>
                                    <a href="javascript:void(0);" id="dwnlink">
                                        {{ __('Download Source Code') }}
                                    </a>
                                </div>
                                <button type="submit" class="btn btn-outline-primary mb-2">
                                    {{ __('Login') }}
                                </button>
                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                            </div>
                        </div>
                    </form>
                    <div class="row pt-2 justify-content-center">
                        <div class="col-md-10 d-flex justify-content-start">
                            <div class="small fw-bolder d-flex flex-column">
                                <span class="text-decoration-underline">{{ __('Default account :') }}</span>
                                <span>{{ __('Username : admin') }}</span>
                                <span>{{ __('Password : 12345678') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <page-footer :current-date="'{{ date('Y') }}'" :urls="'https://www.genesedan.com/'"></page-footer>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- overlay/modal --> 
<div class="modal">
    <div class="modal-dialog">
        <div class="modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fs-5">
                    <div class="modal-title">{{ __('Download Source Code') }}</div>
                    <a href="javascript:void(0);" class="ms-auto pe-3" id="closebtn">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-flex">
                            <div class="d-flex align-items-center">
                                <div class="pb-4 pb-md-0">
                                    <div class="fs-4 fw-bold pb-4">If you like it, you can buy me some drinks.</div>
                                    <div class="text-center" id="donate-button-container">
                                        <div id="donate-button"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <img class="card-img-top" 
                                src="{{ asset('/images/GCASH_QRCODE.jpg') }}">
                                <div class="card-body">
                                    <div class="card-title fs-4 fw-bold text-center">GCash</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <a href="https://github.com/bishopjin/laravelwebapp" class="btn btn-outline-success rounded-pill" target="_blank">
                        {{ __('Github') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection