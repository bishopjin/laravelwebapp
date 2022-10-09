@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">
						{{ __('Daily Time Recorder') }}
						<span class="text-danger fw-bold">
							{{ __('*( Temporary only, replaced with biometric, etc. )') }}
						</span>
					</div>
					<div class="card-body">
						<form method="POST" 
							action="{{ route('payroll.employee.dtr.create') }}" 
							class="py-2 px-4">

							@csrf
							
							@php
								$sched = explode('-', $dtr[0]->workschedule->schedule); 
								$day = date("l", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
								$label = '';
								$timein = null;
								$lunchout = null;
								$lunchin = null;
								$timeout = null;

								if($attendance->count() > 0) {
									$timein = $attendance[0]->time_in ?? null;
									$lunchout = $attendance[0]->time_out_break ?? null;
									$lunchin = $attendance[0]->time_in_break ?? null;
									$timeout = $attendance[0]->time_out ?? null;
								}

								if (!$timein) {
									$label = 'Time In';
								} elseif (!$lunchout) {
									$label = 'Lunch Out';
								} elseif (!$lunchin) {
									$label = 'Lunch In';
								} else {
									$label = 'Time Out';
								}
								
							@endphp
							<div class="text-primary small fw-bold pb-2">
								{{ __('Refresh in ') }} 
								<span id="rfrsh">
									{{ __('30') }}
								</span> 
								{{ __('second(s)') }}
							</div>
							<div class="fw-bold">
								{{ __('Date : ') }} 
								&nbsp; 
								{{ date('M d, Y') }} 
								&nbsp; 
								{{ $day }}
							</div>
							<div class="pb-2 fw-bold">
								{{ __('Work Schedule : ') }}
								{{ date('h:i A', strtotime(trim($sched[0]))).__(' - ').date('h:i A', strtotime(trim($sched[1]))) }}
							</div>
							<div class="row d-flex flex-column flex-md-row align-items-md-end">
								<div class="col-md-2 pb-md-0 pb-2">
									<div class="form-group">
										<label for="timein">
											{{ __('Time In') }}
										</label>

										@if($timein)
											<div class="fw-bold">
												{{ date('h:i A', strtotime($timein)) }}
											</div>
										@else
											<input type="time" 
												name="timein" 
												id="timein" 
												value="{{ date('H:i') }}" 
												class="form-control w-100" 
												readonly>
										@endif

									</div>	
								</div>

								<div class="col-md-2 pb-md-0 pb-2">
									<div class="form-group">
										<label for="lunchout">
											{{ __('Lunch Out') }}
										</label>

										@if($lunchout)
											<div class="fw-bold">
												{{ date('h:i A', strtotime($lunchout)) }}
											</div>
										@else
											<input type="time" 
												name="lunchout" 
												id="lunchout" 
												value="{{ $timein ? date('H:i') : '' }}" 
												class="form-control w-100" 
												readonly>
										@endif

									</div>	
								</div>

								<div class="col-md-2 pb-md-0 pb-2">
									<div class="form-group">
										<label for="lunchin">
											{{ __('Lunch In') }}
										</label>

										@if($lunchin)
											<div class="fw-bold">
												{{ date('h:i A', strtotime($lunchin)) }}
											</div>
										@else
											<input type="time" 
												name="lunchin" 
												id="lunchin" 
												value="{{ $lunchout ? date('H:i') : '' }}" 
												class="form-control w-100" 
												readonly>
										@endif

									</div>	
								</div>

								<div class="col-md-2 pb-md-0 pb-2">
									<div class="form-group">
										<label for="timeout">
											{{ __('Time Out') }}
										</label>

										@if($timeout)
											<div class="fw-bold">
												{{ date('h:i A', strtotime($timeout)) }}
											</div>
										@else
											<input type="time" 
												name="timeout" 
												id="timeout" 
												value="{{ $lunchin ? date('H:i') : '' }}" 
												class="form-control w-100" 
												readonly>
										@endif

									</div>	
								</div>

								<div class="col-md-4 pb-md-0 pb-2">
									<div class="form-group">
										@if(!$timeout)
											<input type="submit" 
												value="{{ $label }}" 
												class="btn btn-primary w-100">

										@endif
									</div>	
								</div>
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
	
	<script type="text/javascript">
		$(document).ready(function() {
			var timer = 30;

			setInterval(function() {
				const date = new Date();
				location.reload();
				//alert(date.getHours() % 12 + ' : ' + date.getMinutes() + ' ' + (date.getHours() >= 12 ? 'pm' : 'am'))
			}, 30000);

			setInterval(function() {
				$('#rfrsh').html(timer -= 1);
			}, 1000);
		});
	</script>
@endsection