@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">
						{{ __('DTR Request Change') }}
					</div>
					<div class="card-body">
						<form method="POST" 
							action="{{ route('payroll.employee.dtr.request.create') }}" 
							class="px-5">

							@csrf

							<div class="form-group pb-2">
								<label for="date">
									{{ __('Date') }}
								</label>
								<input type="date" 
									id="date" 
									class="form-control" 
									value="{{ date('Y-m-d', strtotime($dtrData->created_at)) }}" 
									readonly>

							</div>

							<div class="form-group pb-2">
								<label for="time_in">
									{{ __('Time In') }}
								</label>
								<input type="time" 
									name="time_in" 
									class="form-control @error('time_in') is-invalid @enderror" 
									id="time_in" 
									value="{{ $dtrData->attendancerequest->time_in ?? $dtrData->time_in ?? old('time_in') }}" 
									@if($dtrData->changeRequest > 0) readonly @endif>

								@error('time_in')
                  <span class="invalid-feedback" 
                  	role="alert">

                  	<strong>
                  		{{ $message }}
                  	</strong>
                  </span>
                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="time_out_break">
									{{ __('Lunch Out') }}
								</label>
								<input type="time" 
									name="time_out_break" 
									class="form-control @error('time_out_break') is-invalid @enderror" 
									id="time_out_break" 
									value="{{ $dtrData->attendancerequest->time_out_break ?? $dtrData->time_out_break ?? old('time_out_break') }}" 
									@if($dtrData->changeRequest > 0) readonly @endif>

								@error('time_out_break')
	                <span class="invalid-feedback" 
	                	role="alert">

	                	<strong>
	                		{{ $message }}
	                	</strong>
	                </span>
                @enderror
							</div>
							<div class="form-group pb-2">
								<label for="time_in_break">
									{{ __('Lunch In') }}
								</label>
								<input type="time" 
									name="time_in_break" 
									class="form-control @error('time_in_break') is-invalid @enderror" 
									id="time_in_break" 
									value="{{ $dtrData->attendancerequest->time_in_break ?? $dtrData->time_in_break ?? old('time_in_break') }}" 
									@if($dtrData->changeRequest > 0) readonly @endif>

								@error('time_in_break')
                  <span class="invalid-feedback" 
                  	role="alert">

                  	<strong>
                  		{{ $message }}
                  	</strong>
                  </span>
                @enderror
							</div>
							<div class="form-group pb-2">
								<label for="time_out">
									{{ __('Time Out') }}
								</label>
								<input type="time" 
									name="time_out" 
									class="form-control @error('time_out') is-invalid @enderror" 
									id="time_out" 
									value="{{ $dtrData->attendancerequest->time_out ??$dtrData->time_out ?? old('time_out') }}" 
									@if($dtrData->changeRequest > 0) readonly @endif>

								@error('time_out')
	                <span class="invalid-feedback" 
	                	role="alert">

	                	<strong>
	                		{{ $message }}
	                	</strong>
	                </span>
                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="approver">
									{{ __('Approver') }}
								</label>

								@if($dtrData->changeRequest > 0)
									@php

										$approvername = '';

										foreach($users as $user) {
											if($user->user->id == $dtrData->attendancerequest->approver_id) {
												$approvername = $user->user->full_name;

												break;
											}
										}

									@endphp

									<input type="text" 
										class="form-control" 
										value="{{ $approvername }}" 
										readonly>

								@else
									<select class="form-select" 
										id="approver" 
										name="approver">

										@forelse($users as $user)
											<option value="{{ $user->user_id }}">
												{{ $user->user->full_name }}
											</option>
										@empty
										@endforelse
									</select>
								@endif
							</div>

							<div class="form-group pb-2">
								<label for="remarks">
									{{ __('Remarks') }}
								</label>
								<textarea class="form-control @error('remarks') is-invalid @enderror" 
									rows="4" name="remarks" value="{{ old('remarks') }}"
									@if($dtrData->changeRequest > 0) readonly @endif>
									{{ $dtrData->attendancerequest->remarks ?? '' }}
								</textarea>

								@error('remarks')
	                <span class="invalid-feedback" 
	                	role="alert">

	                	<strong>
	                		{{ $message }}
	                	</strong>
	                </span>
                @enderror
							</div>
							<input type="hidden" 
								name="id" 
								value="{{ $dtrData->id }}">

							<div class="form-group d-flex justify-content-between py-3">
								<a href="{{ route('payroll.employee.index') }}" 
									class="btn btn-outline-success">
									{{ $dtrData->changeRequest == 0 ? __('Cancel') : __('Back') }}
								</a>

								@if($dtrData->changeRequest == 0)
									<input type="submit" 
										value="Save" 
										class="btn btn-outline-primary">

								@endif

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