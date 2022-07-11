@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Payroll Registration') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.admin.user.store') }}" class="px-4">
							@csrf

							@php
								$firstname = null;
								$middlename = null;
								$lastname = null;
								$salary_grade_id = 1;
								$work_sched_id = 1;
								$userid = 0;

								if(isset($details))
								{
									$firstname = $details->user->firstname ?? $details->firstname;
									$middlename = $details->user->middlename ?? $details->middlename;
									$lastname = $details->user->lastname ?? $details->lastname;
									$salary_grade_id = $details->payroll_salary_grade_id;
									$salary_rate = $details->salary_rate;
									$work_sched_id = $details->payroll_work_schedule_id;
									$userid = $details->user_id;
								}
							@endphp

							<div class="form-group pb-2">
								<label for="firstname">{{ __('First Name') }}</label>
								<input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" 
									id="firstname" value="{{ $firstname ?? old('firstname') }}" {{ $firstname ? 'readonly' : '' }} >
								@error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="middlename">{{ __('Middle Name') }}</label>
								<input type="text" name="middlename" class="form-control" id="middlename" 
									value="{{ $middlename ?? old('middlename') }}" {{ $middlename ? 'readonly' : '' }} >
							</div>

							<div class="form-group pb-2">
								<label for="lastname">{{ __('Last Name') }}</label>
								<input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" 
									id="lastname" value="{{ $lastname ?? old('lastname') }}" {{ $lastname ? 'readonly' : '' }} >
								@error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="salarygrade">{{ __('Salary Grade') }}</label>
								<select class="form-select" name="salarygrade" id="salarygrade">
									@isset($salary_grade)
										@foreach($salary_grade as $grade)
											<option value="{{ $grade->id }}" {{ $salary_grade_id == $grade->id ? 'selected' : '' }}>
												{{ $grade->salary_grade }}
											</option>
										@endforeach
									@endisset
								</select>
							</div>
							<div class="form-group pb-2">
								<label for="salary_rate">{{ __('Salary Rate') }}</label>
								<input type="number" name="salary_rate" id="salary_rate" value="{{ $salary_rate ?? old('salary_rate') }}"
									class="form-control @error('salary_rate') is-invalid @enderror">
								@error('salary_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="form-group pb-2">
								<label for="workschedule">{{ __('Work Schedule') }}</label>
								<select class="form-select" name="workschedule" id="workschedule">
									@isset($workSchedule)
										@foreach($workSchedule as $schedule)
											@php
												$sched = explode('-', $schedule->schedule); 
											@endphp
											<option value="{{ $schedule->id }}" {{ $work_sched_id == $schedule->id ? 'selected' : '' }}>
												{{ $schedule->name }} &nbsp; 
												{{ date('h:i a', strtotime(trim($sched[0]))).__(' - ').date('h:i a', strtotime(trim($sched[1]))) }}
											</option>
										@endforeach
									@endisset
								</select>
							</div>
							@if(!isset($details))
								<div class="form-group pb-2">
									<label class="pb-md-1">{{ __('Gender') }}</label>
                                    <div class="row">
                                        <div class="col px-5">
                                            <label class="">{{ __('Male') }}</label>&nbsp;
                                            <input id="male" type="radio" class="" name="gender" value="1" checked>&nbsp; &nbsp; &nbsp;
                                            <label class="">{{ __('Female') }}</label>&nbsp;
                                            <input id="female" type="radio" name="gender" value="2">
                                        </div>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
								<div class="form-group pb-2">
									<label for="email">{{ __('Email') }}</label>
									<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
									id="email" value="{{ old('email') }}" required>
									@error('email')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
								</div>
								<div class="form-group pb-2">
									<label for="username">{{ __('UserName') }}</label>
									<input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
										id="username" value="{{ old('username') }}" required>
									@error('username')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
								</div>
								<div class="form-group pb-2">
									<label for="DOB">{{ __('Birth Date') }}</label>
									<input type="date" name="DOB" class="form-control" id="DOB" value="{{ date('Y-m-d') }}">
								</div>
							@endif
							@if(\Session::has('message'))
								<div class="fw-bold">{{ \Session::get('message') }}</div>
							@endif
							<input type="hidden" name="id" value="{{ $userid }}">
							<div class="form-group d-flex justify-content-between py-3">
								<a href="{{ route('payroll.admin.index') }}" class="btn btn-outline-success">{{ __('Back') }}</a>
								<input type="submit" value="Save" class="btn btn-outline-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<x-footerexam :color="'text-dark'"/>
	</div>
@endsection