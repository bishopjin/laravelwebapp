@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow">
					<div class="card-header">{{ __('Salary Addition') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.admin.addition.create') }}" class="px-5">
							@csrf

							@php
								$name = null;
								$rate = 0;
								$amount = 0;
								$addid = 0;

								if(isset($addition))
								{
									$name = $addition->name;
									$rate = $addition->rate;
									$amount = $addition->amount;
									$addid = $addition->id;
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

							<div class="form-group pb-4">
								<label for="amount">{{ __('Amount per minute') }}</label>
								<input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror"
									value="{{ $amount ?? old('amount') }}">
								@error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
							<input type="hidden" name="id" value="{{ $addid }}">
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