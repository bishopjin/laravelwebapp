@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>
                            {{ __('Set Permission per Role') }}
                        </span>
                        <a href="{{ route('userspermission.index') }}" 
                            class="text-decoration-none fw-bold">
                            {{ __('Back') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6 pb-md-0 pb-2">
                                <div class="fw-bold h5">
                                    {{ __('Role Name') }}
                                </div>

                                @forelse($roles as $role)
                                    <div class="fw-bold ps-4">
                                        <span class="me-4">
                                            {{ $role->name }}
                                        </span>
                                        <a href="{{ route('usersrole.edit', $role->name) }}" 
                                            class="text-decoration-none fw-bold text-primary small">
                                            {{ __('Edit Permission') }}
                                        </a>
                                    </div>
                                @empty
                                @endforelse

                            </div>
                            <div class="col-md-6">
                                @include('layouts.permissiontemplate')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection