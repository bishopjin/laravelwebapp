@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Work Schedule') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.admin.schedule.create') }}" class="px-5">
							@csrf

							@php
								$name = null;
								$code = null;
								$startDT = null;
								$endDT = null;
								$sched_id = 0;

								if(isset($workschedule))
								{
									$name = $workschedule->name;
									$code = $workschedule->code;
									$schedule = explode('-', $workschedule->schedule);
									$startDT = trim($schedule[0]);
									$endDT = trim($schedule[1]);
									$sched_id = $workschedule->id;
								}
							@endphp

							<div class="form-group pb-2">
								<label for="name">{{ __('Name') }}</label>
								<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
									id="name" value="{{ $name ?? old('name') }}" {{ $name ? 'readonly' : '' }} required>
								@error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="code">{{ __('Code') }}</label>
								<input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
									id="code" value="{{ $code ?? old('code') }}" {{ $code ? 'readonly' : '' }} required>
								@error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="d-flex flex-column flex-md-row justify-content-md-between">
								<div class="form-group pb-2">
									<label for="startTme">{{ __('Time In') }}</label>
									<input type="time" name="startTme" class="form-control @error('startTme') is-invalid @enderror" 
										id="startTme" value="{{ $startDT ?? old('startTme') ?? date('H:i') }}" required>
									@error('startTme')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
								</div>
								<div class="form-group pb-2">
									<label for="endTme">{{ __('Time Out') }}</label>
									<input type="time" name="endTme" class="form-control @error('endTme') is-invalid @enderror" 
										id="endTme" value="{{ $endDT ?? old('endTme') ?? date('H:i') }}" required>
									@error('endTme')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
								</div>
							</div>

							@if(\Session::has('message'))
								<div class="fw-bold">{{ \Session::get('message') }}</div>
							@endif
							<input type="hidden" name="id" value="{{ $sched_id }}">
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
	<div class="container">
		<x-footerexam :color="'text-dark'"/>
	</div>
@endsection