@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Salary Grade') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('salarygrade.store') }}" class="px-5">
							@csrf

							@php
								$slrygrd = null;
								$nghtdffppld = 0;
								$vrtmppld = 0;
								$clppld = 0;
								$eclppld = 0;
								$mlllwncppld = 0;
								$slgrdid = 0;

								if(isset($salarygrade))
								{
									$slrygrd = $salarygrade->salary_grade;
									$nghtdffppld = $salarygrade->night_diff_applied;
									$vrtmppld = $salarygrade->overtime_applied;
									$clppld = $salarygrade->cola_applied;
									$eclppld = $salarygrade->ecola_applied;
									$mlllwncppld = $salarygrade->meal_allowance_applied;
									$slgrdid = $salarygrade->id;
								}
							@endphp

							<div class="form-group pb-3">
								<label for="salary_grade">{{ __('Name') }}</label>
								<input type="text" name="salary_grade" class="form-control @error('salary_grade') is-invalid @enderror" 
									id="salary_grade" value="{{ $slrygrd ?? old('salary_grade') }}" {{ $slrygrd ? 'readonly' : '' }} >
								@error('salary_grade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="night_diff_applied" id="nightdiff" value="1" class="form-check-input"
									 	{{ $nghtdffppld == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="nightdiff">{{ __('Night Differentials') }}</label>
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="overtime_applied" id="isovertime" value="1" class="form-check-input"
										{{ $vrtmppld == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="isovertime">{{ __('Overtime') }}</label>
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="cola_applied" id="iscola" value="1" class="form-check-input"
										{{ $clppld == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="iscola">{{ __('Cost of living allowance') }}</label>
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="ecola_applied" id="isecola" value="1" class="form-check-input"
										{{ $eclppld == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="isecola">{{ __('Emergency Cost of living allowance') }}</label>
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="meal_allowance_applied" id="ismeal" value="1" class="form-check-input"
										{{ $mlllwncppld == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="ismeal">{{ __('Meal Allowance') }}</label>
							</div>

							@if(\Session::has('message'))
								<div class="fw-bold">{{ \Session::get('message') }}</div>
							@endif
							<input type="hidden" name="id" value="{{ $slgrdid }}">
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