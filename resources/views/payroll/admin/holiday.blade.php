@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Holiday') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.admin.holiday.create') }}" class="px-5">
							@csrf

							@php
								$name = null;
								$legal = 0;
								$local = 0;
								$day = '0';
								$month = '0';
								$rate = 0;
								$holid = 0;

								if(isset($holiday))
								{
									$arr = explode('-', $holiday->date);
									$name = $holiday->name;
									$day = $arr[1];
									$month = $arr[0];
									$legal = $holiday->is_legal;
									$local = $holiday->is_local;
									$rate = $holiday->rate;
									$holid = $holiday->id;
								}
							@endphp

							<div class="form-group pb-2">
								<label for="name">{{ __('Name') }}</label>
								<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
									id="name" value="{{ $name ?? old('name') }}" {{ $name ? 'readonly' : '' }} >
								@error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group pb-2">
								<label for="month">{{ __('Date') }}</label>
								<div class="d-flex gap-2">
									<select class="form-select" name="month" id="month">
										<option value="1" {{ $month == '1' ? 'selected' : 'selected' }}>{{ __('January') }}</option>
										<option value="2" {{ $month == '2' ? 'selected' : '' }}>{{ __('February') }}</option>
										<option value="3" {{ $month == '3' ? 'selected' : '' }}>{{ __('March') }}</option>
										<option value="4" {{ $month == '4' ? 'selected' : '' }}>{{ __('April') }}</option>
										<option value="5" {{ $month == '5' ? 'selected' : '' }}>{{ __('May') }}</option>
										<option value="6" {{ $month == '6' ? 'selected' : '' }}>{{ __('June') }}</option>
										<option value="7" {{ $month == '7' ? 'selected' : '' }}>{{ __('July') }}</option>
										<option value="8" {{ $month == '8' ? 'selected' : '' }}>{{ __('August') }}</option>
										<option value="9" {{ $month == '9' ? 'selected' : '' }}>{{ __('September') }}</option>
										<option value="10" {{ $month == '10' ? 'selected' : '' }}>{{ __('October') }}</option>
										<option value="11" {{ $month == '11' ? 'selected' : '' }}>{{ __('November') }}</option>
										<option value="12" {{ $month == '12' ? 'selected' : '' }}>{{ __('December') }}</option>
									</select>
									<select class="form-select w-50" name="day" id="day">
										@isset($holiday)
											<option value="{{ $day }}" selected>{{ $day }}</option>
										@endisset
									</select>
								</div>
							</div>
							
							<div class="form-group pb-3">
								<input type="checkbox" name="islegal" id="islegal" value="1" class="form-check-input"
									 	{{ $legal == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="islegal">{{ __('Legal Holiday') }}</label>
							</div>

							<div class="form-group pb-3">
								<input type="checkbox" name="islocal" id="islocal" value="1" class="form-check-input"
									 	{{ $local == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="islocal">{{ __('Local Holiday') }}</label>
							</div>

							<div class="form-group pb-4">
								<label for="rate">{{ __('Rate in (%)') }}</label>
								<input type="number" name="rate" id="rate" class="form-control @error('rate') is-invalid @enderror"
									value="{{ $rate * 100 ?? old('rate') }}">
								@error('rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							@if(\Session::has('message'))
								<div class="fw-bold">{{ \Session::get('message') }}</div>
							@endif
							<input type="hidden" name="id" value="{{ $holid }}">
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

	<script type="text/javascript">
		$(document).ready(function(){
			const d = new Date();
			var year = d.getFullYear(),
				month = $('#month'),
				day = $('#day'),
				number_of_days = 0;

			number_of_days = daysInMonth(1, year);
			
			for (var i = 1; i <= number_of_days; i++) {
				$(day).append(`<option value="${i}">${i}</option>`);
			}
			
			$(month).on('change', function() {
				$(day).empty();
				number_of_days = daysInMonth(parseInt(this.value), year);
			  	for (var i = 1; i <= number_of_days; i++) {
					$(day).append(`<option value="${i}">${i}</option>`);
				}
			});
			/* get the number of days per month */
			function daysInMonth (month, year) {
			    return new Date(year, month, 0).getDate();
			}
		});
	</script>
@endsection