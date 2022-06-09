@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Change Password') }}</div>
					<div class="card-body">
						<form method="POST" class="px-5" 
							action="{{ session('user_access') == '1' ? route('payroll.admin.password.create') : route('payroll.employee.password.create') }}">
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
								<a href="{{ route('payroll.dashboard.index') }}" class="btn btn-outline-success">{{ __('Back') }}</a>
								<input type="submit" value="Save" class="btn btn-outline-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection