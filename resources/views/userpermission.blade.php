@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ __('Users Role and Permission') }}</span>
                        <a href="{{ route('index') }}" class="text-decoration-none fw-bold">{{ __('Home') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{{ __('Full Name') }}</th>
                                    <th>{{ __('Username') }}</th>
                                    <th>{{ __('Default Password') }}</th>
                                    <th>{{ __('Role(s)') }}</th>
                                    <th>{{ __('Permission(s)') }}</th>
                                </thead>
                                <tbody>
                                    @isset($users)
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->full_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ \Hash::check('12345678', $user->password) ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <span class="d-flex gap-2 fw-bold">
                                                        <a href="{{ route('users.role.show', ['id' => $user->id, 'action' => 'view']) }}" class="text-decoration-none text-info">{{ __('View') }}</a>&#124;
                                                        <a href="{{ route('users.role.show', ['id' => $user->id, 'action' => 'edit']) }}" class="text-decoration-none text-primary">{{ __('Edit') }}</a>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="d-flex gap-2 fw-bold">
                                                        <a href="{{ route('users.permission.show', ['id' => $user->id, 'action' => 'view']) }}" class="text-decoration-none text-info">{{ __('View') }}</a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($users)
                                    {{ $users->links() }}
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center pt-3">
            <div class="col-md-6 d-flex">
                <div class="card w-100">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ __('Role\'s permission') }}</span>
                        <a href="{{ route('roles.permission.index') }}" class="text-decoration-none fw-bold">{{ __('Edit') }}</a>
                    </div>
                    <div class="card-body py-3">
                        <div class="fw-bold">{{ __('Role name') }}</div>
                        @isset($rolepermission)
                            @foreach($rolepermission as $role)
                                @if($role->name != 'Super Admin')
                                    <div class="px-4">
                                        <div class="fw-bold">{{ $role->name }}</div>

                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions as $permission)
                                                <div class="px-4">{{ __('- ') }}{{ $permission->name }}</div>
                                            @endforeach
                                        @else
                                            <div class="px-4">{{ __('- No permission') }}</div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="card-footer small">
                        <span class="fw-bold">{{ __('NOTE: ') }}</span>
                        {{ __('Permission(s) can only be granted/revoked thru role. 
                            User should have a role and that role can have one or more or no permission.') }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card pb-md-0 pb-3 w-100">
                    <div class="card-body py-3">
                        <div class="fw-bold h5">{{ __('Name : ') }} {{ $curuser->full_name ?? 'Select user' }}</div>
                        @isset($curuser)
                            @isset($roles)
                                <div class="fw-bold pb-2">{{ __('User\'s Role(s)') }}</div>
                                @if($action == 'edit')
                                    <form method="POST" action="{{ route('users.role.update') }}">
                                        @csrf
                                        @method('PUT')
                                        @foreach($roles as $role)
                                            @if($userroles->count() > 0)
                                                @php
                                                    $user_role = null;
                                                    foreach($userroles as $userrole) 
                                                    {
                                                        if ($userrole == $role->name) 
                                                        {
                                                            $user_role = $userrole;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                @if($role->name != 'Super Admin')
                                                    <div class="form-group pb-2 px-4">
                                                        <input type="checkbox" name="role[]" id="{{ $role->name }}" value="{{ $role->name }}" class="form-check-input"
                                                            {{ $user_role != null ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                                    </div>
                                                @else
                                                    @if($curuser->id == 1)
                                                        <div class="form-group pb-2 px-4">
                                                            <input type="checkbox" name="role[]" id="{{ $role->name }}" value="{{ $role->name }}" class="form-check-input"
                                                                {{ $user_role != null ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                                        </div>
                                                    @endif
                                                @endif
                                            @else
                                                @if($role->name != 'Super Admin')
                                                    <div class="form-group pb-2 px-4">
                                                        <input type="checkbox" name="role[]" id="{{ $role->name }}" value="{{ $role->name }}" class="form-check-input">
                                                        <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                                    </div>
                                                @else
                                                    @if($curuser->id == 1)
                                                        <div class="form-group pb-2 px-4">
                                                            <input type="checkbox" name="role[]" id="{{ $role->name }}" value="{{ $role->name }}" class="form-check-input">
                                                            <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                        <div class="form-group px-4">
                                            <input type="hidden" name="id" value="{{ $curuser->id }}">
                                            <input type="submit" value="Save" class="btn btn-primary">
                                        </div>
                                    </form>
                                @else
                                    @if($userroles->count() > 0)
                                        @foreach($userroles as $userrole)
                                            <div class="fw-bold px-4 t">{{ __('- ') }} {{ $userrole }}</div>
                                        @endforeach
                                    @else
                                        <div class="fw-bold px-4 text-danger">{{ __('User\'s has no role(s)') }}</div>
                                    @endif
                                @endif
                            @endisset
                            
                            @isset($userpermissions)
                                <div class="fw-bold pb-2">{{ __('User\'s Permission(s)') }}</div>
                                @if($userpermissions->count() > 0)
                                    @foreach($userpermissions as $permission)
                                        <div class="fw-bold ps-4">{{ __('- ').$permission->name }}</div>
                                    @endforeach
                                @else
                                    <div class="fw-bold ps-4 text-danger">{{ __('- no permission') }}</div>
                                @endif
                            @endisset
                        @endisset
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection