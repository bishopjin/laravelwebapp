@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center pb-md-3 pt-md-4">
			<div class="col">
				<div class="h4">{{ __('Dashboard') }}</div>
			</div>
		</div>

		<div class="row justify-content-center pb-3">
			<div class="col-md-6 pb-md-0 pb-2 d-flex">
				<div class="card shadow w-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<span>{{ __('Cut-off Period') }}</span>
						<span>
							<a href="{{ route('payroll.admin.cutoff.edit') }}" class="text-decoration-none fw-bold">
								{{ __('Edit') }}
							</a>
						</span>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Cut-Off') }}</th>
									<th>{{ __('Date Range') }}</th>
									<th>{{ __('Pay Date') }}</th>
								</thead>
								<tbody>
									@if($cutoffperiod)
										@foreach($cutoffperiod as $period)
											<tr>
												<td>{{ $period['cut_off'] }}</td>
												<td>{{ __('from') }} {{ $period['daterange'] }}</td>
												<td>{{ $period['paydate'] }}</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-md-6 pb-md-0 pb-2 d-flex">
				<div class="card shadow w-100">
					<div class="card-header">{{ __('Work Schedule') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Name') }}</th>
									<th>{{ __('Code') }}</th>
									<th>{{ __('Schedule') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($workSchedule)
										@foreach($workSchedule as $schedule)
											@php
												$sched = explode('-', $schedule->schedule);
												$worksched = date('h:i A', strtotime(trim($sched[0]))).' - '.date('h:i A', strtotime(trim($sched[1])));
											@endphp		
											<tr class="small">
												<td>{{ $schedule->name }}</td>
												<td>{{ $schedule->code }}</td>
												<td class="small">{{ $worksched }}</td>
												<td>
													<a href="{{ route('payroll.admin.schedule.edit', ['id' => $schedule->id]) }}" 
														class="btn btn-sm btn-outline-success">
														{{ __('Edit') }}
													</a>
												</td>
											</tr>
										@endforeach
									@endisset		
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row no-gutters justify-content-center pb-3">
			<div class="col-md-6 pb-md-0 pb-2 d-flex">
				<div class="card shadow w-100">
					<div class="card-header">{{ __('Salary Deduction List') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Name') }}</th>
									<th>{{ __('Rate') }}</th>
									<th>{{ __('Amount') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($deduction)
										@foreach($deduction as $deduc)
											<tr>
												<td>{{ $deduc->name }}</td>
												<td>{{ $deduc->rate * 100 }}{{ __('%') }}</td>
												<td>{{ $deduc->amount }}</td>
												<td>
													<a href="{{ route('payroll.admin.deduction.edit', ['id' => $deduc->id]) }}"
														class="btn btn-sm btn-outline-success">{{ __('Edit') }}	
													</a>
												</td>
											</tr>
										@endforeach
									@endisset
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($deduction)
									{{ $deduction->links() }}
								@endisset
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 d-flex">
				<div class="card shadow w-100">
					<div class="card-header">{{ __('Salary Addition List') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Name') }}</th>
									<th>{{ __('Rate') }}</th>
									<th>{{ __('Amount per minute') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($addition)
										@foreach($addition as $add)
											<tr>
												<td>{{ $add->name }}</td>
												<td>{{ $add->rate * 100 }}{{ __('%') }}</td>
												<td>{{ $add->amount }}</td>
												<td>
													<a href="{{ route('payroll.admin.addition.edit', ['id' => $add->id]) }}"
														class="btn btn-sm btn-outline-success">{{ __('Edit') }}	
													</a>
												</td>
											</tr>
										@endforeach
									@endisset
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($addition)
								{{ $addition->links() }}
								@endisset
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pb-3">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">{{ __('Holiday List') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Name') }}</th>
									<th>{{ __('Date') }}</th>
									<th>{{ __('Legal Holiday') }}</th>
									<th>{{ __('Local Holiday') }}</th>
									<th>{{ __('Rate') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($holidays)
										@foreach($holidays as $holiday)
											@php
												$dateArr = explode('-', $holiday->date);
												$month = date('F', strtotime('1990-'.$dateArr[0].'-01'));
												$day = $dateArr[1];
											@endphp
											<tr>
												<td>{{ $holiday->name }}</td>
												<td>{{ $month.' '.$day }}</td>
												<td>{{ $holiday->is_legal == 0 ? 'No' : 'Yes' }}</td>
												<td>{{ $holiday->is_local == 0 ? 'No' : 'Yes' }}</td>
												<td>{{ $holiday->rate * 100 }} {{ __('%') }}</td>
												<td>
													<a href="{{ route('payroll.admin.holiday.edit', ['id' => $holiday->id]) }}"
														class="btn btn-sm btn-outline-success">{{ __('Edit') }}
													</a>
												</td>
											</tr>
										@endforeach
									@endisset
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($holidays)
									{{ $holidays->links() }}
								@endisset
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pb-3">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">{{ __('Salary Grade List') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Salary Grade') }}</th>
									<th>{{ __('Night Differential Pay') }}</th>
									<th>{{ __('Overtime Pay') }}</th>
									<th>{{ __('COLA Pay') }}</th>
									<th>{{ __('ECOLA Pay') }}</th>
									<th>{{ __('Meal Allowance') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($salary_grade)
										@foreach($salary_grade as $grade)
											<tr>
												<td>{{ $grade->salary_grade }}</td>
												<td>{{ $grade->night_diff_applied ? 'Yes' : 'No' }}</td>
												<td>{{ $grade->overtime_applied ? 'Yes' : 'No' }}</td>
												<td>{{ $grade->cola_applied ? 'Yes' : 'No' }}</td>
												<td>{{ $grade->ecola_applied ? 'Yes' : 'No' }}</td>
												<td>{{ $grade->meal_allowance_applied ? 'Yes' : 'No' }}</td>
												<td>
													<a href="{{ route('payroll.admin.salarygrade.edit', ['id' => $grade->id]) }}" 
														class="btn btn-sm btn-outline-success">{{ __('Edit') }}
													</a>
												</td>
											</tr>
										@endforeach
									@endisset
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($salary_grade)
									{{ $salary_grade->links() }}
								@endisset
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row pb-3">
			<div class="col">
				<div class="card shadow">
					<div class="card-header d-flex justify-content-between">
						<span>{{ __('Employee List') }}</span>
						<span class="fw-bold text-danger">
							@if($errors->any())
								{{ $errors->first() }}
							@endif
						</span>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>{{ __('Lastname') }}</th>
									<th>{{ __('Firstname') }}</th>
									<th>{{ __('Middlename') }}</th>
									<th>{{ __('Work Schedule') }}</th>
									<th>{{ __('Salary Grade') }}</th>
									<th>{{ __('Status') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($users)
										@foreach($users as $user)
											<tr>
												@php 
													$sched = explode('-', $user->workschedule->schedule);
												@endphp
												<td>{{ $user->userprofile->lastname ?? $user->lastname }}</td>
												<td>{{ $user->userprofile->firstname ?? $user->firstname }}</td>
												<td>{{ $user->userprofile->middlename ?? $user->middlename }}</td>
												<td>{{ $user->workschedule->schedule ? date('h:i a', strtotime(trim($sched[0]))).__(' - ').date('h:i a', strtotime(trim($sched[1]))) : 'None' }}</td>
												<td>{{ $user->salarygrade->salary_grade ?? 'None' }}</td>
												<td>{{ $user->salarygrade ? 'Registered' : 'Not Registered' }}</td>
												<td>
													<a href="{{ route('payroll.admin.user.edit', ['id' => $user->user_id]) }}" class="btn btn-sm btn-outline-success">
														{{ $user->salarygrade ? 'Edit' : 'Register' }}
													</a>
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
	</div>
	<div class="container">
		<x-footerexam :color="'text-dark'"/>
	</div>
@endsection