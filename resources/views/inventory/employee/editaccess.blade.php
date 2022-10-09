@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">
                    {{ __('Edit Access Level') }}
                </div>

                <div class="card-body">
                    <form method="POST" 
                        action="{{ route('inventory.employee.access.store') }}"
                        class="px-md-5">

                        @csrf
                        @method('PUT')

                        <div class="form-group pb-3">
                            <label>
                                {{ __('User ID') }}
                            </label>
                            <input type="text" 
                                name="id" 
                                value="{{ $user_details->id }}" 
                                class="form-control"
                                readonly>
                        </div>
                        <div class="form-group pb-3">
                            <label>
                                {{ __('Name') }}
                            </label>
                            <input type="text" 
                                value="{{ $user_details->full_name}}" 
                                class="form-control" 
                                readonly>
                        </div>
                        <div class="form-group pb-3">
                            <label for="user_role">
                                {{ __('Access Level') }}
                            </label>
                            <select class="form-select @error('user_role') is-invalid @enderror" 
                                name="user_role" 
                                id="user_role" 
                                required>

                                @forelse($roles as $role)
                                    <option value="{{ $role->name }}" 
                                        @hasrole($role->name) selected @endhasrole>
                                        {{ $role->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                            @error('user_role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group d-flex justify-content-between flex-row py-2">
                            <a href="{{ route('inventory.employee.edit.index') }}" 
                                class="btn btn-outline-info px-5">
                                {{ __('Back') }}
                            </a>
                            <input type="submit" 
                                class="btn btn-outline-primary px-5" 
                                value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection