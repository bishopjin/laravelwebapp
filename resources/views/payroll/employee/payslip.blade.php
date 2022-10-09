@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">
						{{ __('Payslip') }}
					</div>
					<div class="card-body">
						<form method="POST" 
							action="{{ route('payroll.employee.payslip.show') }}">

							@csrf

							<div class="small">
								{{ __('Select Date') }}
							</div>
							<div class="small d-flex flex-md-row flex-column align-items-md-end">
								<div class="form-group pe-md-3 pb-md-0 pb-2">
									<label class="small" 
										for="strDt">
										{{ __('Start Date') }}
									</label>
									<input type="date" 
										class="form-control" 
										id="strDt" 
										name="strDt" 
										value="{{ old('strDt') ?? date('Y-m-d') }}">

								</div>
								<div class="form-group pe-md-3 pb-md-0 pb-2">
									<label class="small" 
										for="endDt">
										{{ __('End Date') }}
									</label>
									<input type="date" 
										class="form-control" 
										id="endDt" 
										name="endDt" 
										value="{{ old('endDt') ?? date('Y-m-d') }}">

								</div>
								<div class="form-group">
									<input type="submit" 
										class="btn btn-primary" 
										value="Show Details">

								</div>
							</div>
						</form>
						<hr>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>
										{{ __('Cut-off Period') }}
									</th>
									<th>
										{{ __('Pay Date') }}
									</th>
									<th>
										{{ __('Basic Pay') }}
									</th>
									<th>
										{{ __('Deduction') }}
									</th>
									<th>
										{{ __('Action') }}
									</th>
								</thead>
								<tbody>
									@forelse($payslips as $payslip)
										<tr>
											<td>
												{{ $payslip->payrollcutoff->cut_off }}
											</td>
											<td>
												{{ date('Y-m-d', strtotime($payslip->created_at)) }}
											</td>
											<td></td>
											<td></td>
											<td>
												<a href="#" 
													class="btn btn-primary">
													{{ __('Print') }}
												</a>
											</td>
										</tr>
									@empty
									@endforelse
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($payslips)
									{{ $payslips->links() }}
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