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
                        <a href="#" class="nav-link border border-bottom-0 text-light bg-primary rounded py-3 px-5">
                            {{ __('Subject') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('exam.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body px-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-header border-bottom border-warning">{{ __('New Subject') }}</div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('subject.save') }}">
                                        @csrf
                                        <div class="form-group d-grid gap-2">
                                            <label class="">{{ __('Subject') }}</label>
                                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required="" autocomplete="off">
                                            <input type="submit" value="{{ __('Save') }}" class="btn btn-outline-primary w-25 ms-auto">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            @php 
                                $title = 'Subject List'; 
                                $header = ['Subject'];
                                $dataKey = ['subject'];
                            @endphp
                            <x-datatable :data="$subject_list" 
                                :title="$title" 
                                :header="$header" 
                                :tData="$dataKey">
                            </x-datatable>
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
