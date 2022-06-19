@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Holiday') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.admin.cutoff.update') }}">
							@csrf

							@php
								$fco = explode('to', $cutOff[0]->cut_off);
								$sco = explode('to', $cutOff[1]->cut_off);
							@endphp

							<div class="form-group pb-2">
								<label>{{ __('First Cut-off Period/Date') }}</label><br>
								<div class="row">
									<div class="col-6">
										<label for="cutoff1">{{ __('Start') }}</label>
									</div>
									<div class="col-6">
										<label for="cutoff2">{{ __('End') }}</label>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<select class="form-select" name="sfco" id="cutoff1">
										</select>
									</div>
									<div class="col-6">
										<input type="text" name="efco" value="{{ trim($fco[1]) }}" class="form-control" id="cutoff2" readonly>
									</div>
								</div>
								<label class="pt-3">{{ __('Second Cut-off Period/Date') }}</label><br>
								<div class="row">
									<div class="col-6">
										<label for="cutoff11">{{ __('Start') }}</label>
									</div>
									<div class="col-6">
										<label for="cutoff22">{{ __('End') }}</label>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<input type="text" name="ssco" value="{{ trim($sco[0]) }}" class="form-control" id="cutoff11" readonly>
									</div>
									<div class="col-6">
										<input type="text" name="esco" value="{{ trim($sco[1]) }}" class="form-control" id="cutoff22" readonly>
									</div>
								</div>
							</div>

							@if(\Session::has('message'))
								<div class="fw-bold">{{ \Session::get('message') }}</div>
							@endif
							<div class="form-group d-flex justify-content-between py-3">
								<a href="{{ route('payroll.dashboard.index') }}" class="btn btn-outline-success">{{ __('Back') }}</a>
								<input type="submit" value="Update" class="btn btn-outline-primary">
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
			const d = new Date();
			var year = d.getFullYear(),
				month = d.getMonth(),
				cutoff1 = $('#cutoff1'),
				number_of_days = 0;
		
			$(cutoff1).empty();
			number_of_days = daysInMonth(month + 1, year);
			
			for (var i = 1; i <= number_of_days; i++) {
				var selected = '';

				if (parseInt('{{ trim($fco[0]) }}') == i) {
					selected = 'selected';
				}

				$(cutoff1).append(`<option value="${i}" ${selected}>${i}</option>`);
			}
			
			$(cutoff1).on('change', function() {
				var startval = 0;
				/* auto set cut-off date */
				$('#cutoff2').val(parseInt($(this).val()) + 14);
				$('#cutoff11').val(parseInt($('#cutoff2').val()) + 1);
				if ((parseInt($('#cutoff11').val()) + 14) > number_of_days) {
					startval = (parseInt($('#cutoff11').val()) + 14) - number_of_days;
				}
				else {
					startval = parseInt($('#cutoff11').val()) + 14;
				}
				$('#cutoff22').val(startval);
			});
			/* get the number of days per month */
			function daysInMonth (month, year) {
			    return new Date(year, month, 0).getDate();
			}
		});
	</script>
@endsection