@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">
						{{ __('Change Password') }}
					</div>
					<div class="card-body">
						<form method="POST" 
							class="px-5" 
							action="{{ route('changepassword.update', ['changepassword' => $userid]) }}">

							@csrf
							@method('PATCH')

							<div class="form-group pb-2">
								<label for="old_pass">
									{{ __('Old Password') }}
								</label>
								<input type="password" 
									name="old_pass" 
									id="old_pass" 
									alue="{{ old('old_pass') }}"
									class="form-control @error('old_pass') is-invalid @enderror">

								@error('old_pass')
                  <span class="invalid-feedback" 
                  	role="alert">

                    <strong>
                    	{{ $message }}
                    </strong>
                  </span>
                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="password">
									{{ __('New Password') }}
								</label>
								<input type="password" 
									name="password" 
									id="password" 
									value="{{ old('password') }}"
									class="form-control @error('password') is-invalid @enderror">

								@error('password')
                  <span class="invalid-feedback" 
                  	role="alert">

                  	<strong>
                  		{{ $message }}
                  	</strong>
                  </span>
	              @enderror
							</div>

							<div class="form-group pb-3">
								<label for="password_confirmation">
									{{ __('Confirm Password') }}
								</label>
             		<input id="password_confirmation" 
             			type="password" 
             			name="password_confirmation" 
             			value="{{ old('password_confirmation') }}" 
             		 	class="form-control @error('password_confirmation') is-invalid @enderror">

             		@error('password_confirmation')
                  <span class="invalid-feedback" 
                  	role="alert">

                 		<strong>
                 			{{ $message }}
                 		</strong>
                  </span>
                @enderror
							</div>

							@if(\Session::has('message'))
								<div class="fw-bold {{ \Session::get('font') }}">
									{{ \Session::get('message') }}
								</div>
							@endif
							<div class="form-group d-flex justify-content-between py-3">
								@if(Auth::user()->hasrole('Admin'))
									<a href="{{ route('payroll.admin.index') }}" 
										class="btn btn-outline-success">
										{{ __('Back') }}
									</a>
								@else
									<a href="{{ route('payroll.employee.index') }}" 
										class="btn btn-outline-success">
										{{ __('Back') }}
									</a>
								@endif
								<input type="submit" 
									value="Save" 
									class="btn btn-outline-primary">
									
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection