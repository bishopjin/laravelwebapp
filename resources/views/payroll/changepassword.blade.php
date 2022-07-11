@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Change Password') }}</div>
					<div class="card-body">
						<form method="POST" class="px-5" action="{{ route('payroll.password.update') }}">
							@csrf
							<div class="form-group pb-2">
								<label for="oldpass">{{ __('Old Password') }}</label>
								<input type="password" name="oldpass" id="oldpass" value="{{ old('oldpass') }}"
									class="form-control @error('oldpass') is-invalid @enderror" required>

								@error('oldpass')
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $message }}</strong>
	                                </span>
	                            @enderror
							</div>

							<div class="form-group pb-2">
								<label for="password">{{ __('New Password') }}</label>
								<input type="password" name="password" id="password" value="{{ old('password') }}"
									class="form-control @error('password') is-invalid @enderror" required>

								@error('password')
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $message }}</strong>
	                                </span>
	                            @enderror
							</div>

							<div class="form-group pb-3">
								<label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                           		<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
							</div>
							@if(\Session::has('message'))
								<div class="fw-bold {{ \Session::get('font') }}">{{ \Session::get('message') }}</div>
							@endif
							<div class="form-group d-flex justify-content-between py-3">
								@if(Auth::user()->can('payroll admin access') AND str_contains(url()->current(), 'admin/user/changepassword'))
									<a href="{{ route('payroll.admin.index') }}" class="btn btn-outline-success">{{ __('Back') }}</a>
								@else
									<a href="{{ route('payroll.employee.index') }}" class="btn btn-outline-success">{{ __('Back') }}</a>
								@endif
								<input type="submit" value="Save" class="btn btn-outline-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection