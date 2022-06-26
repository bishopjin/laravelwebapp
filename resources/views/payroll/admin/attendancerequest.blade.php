@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row justify-content-center pb-3">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">{{ __('Attendance Change Request') }}</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<th>{{ __('Employee Name') }}</th>
									<th>{{ __('Date Requested') }}</th>
									<th>
										<span class="d-flex flex-column">
											<span class="text-center">{{ __('Actual Attendance') }}</span>
											<span class="d-flex justify-content-around">
												<span class="small">{{ __('In') }}</span>
												<span class="small">{{ __('Out') }}</span>
												<span class="small">{{ __('In') }}</span>
												<span class="small">{{ __('Out') }}</span>
											</span>
										</span>
									</th>
									<th>
										<span class="d-flex flex-column">
											<span class="text-center">{{ __('For Approval') }}</span>
											<span class="d-flex justify-content-around">
												<span class="small">{{ __('In') }}</span>
												<span class="small">{{ __('Out') }}</span>
												<span class="small">{{ __('In') }}</span>
												<span class="small">{{ __('Out') }}</span>
											</span>
										</span>
									</th>
									<th>{{ __('Remarks') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody>
									@isset($attendance)
										@foreach($attendance as $data)
											<tr class="small fw-bold">
												<td>{{ $data->employee->full_name }}</td>
												<td>{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
												<td>
													<table class="w-100">
														<tr class="small">
															<td>{{ date('h:i a', strtotime($data->attendance->time_in)) }}</td>
															<td>{{ date('h:i a', strtotime($data->attendance->time_out_break)) }}</td>
															<td>{{ date('h:i a', strtotime($data->attendance->time_in_break)) }}</td>
															<td>{{ date('h:i a', strtotime($data->attendance->time_out)) }}</td>
														</tr>
													</table>
												</td>
												<td>
													<table class="w-100">
														<tr class="small">
															<td>{{ date('h:i a', strtotime($data->time_in)) }}</td>
															<td>{{ date('h:i a', strtotime($data->time_out_break)) }}</td>
															<td>{{ date('h:i a', strtotime($data->time_in_break)) }}</td>
															<td>{{ date('h:i a', strtotime($data->time_out)) }}</td>
														</tr>
													</table>
												</td>
												<td>{{ $data->remarks }}</td>
												<td>
													<table class="w-100">
														<tr>
															<td>
																<form method="POST" action="{{ route('payroll.admin.requestchange.create') }}">
																	@csrf
																	<div class="form-group">
																		<input type="hidden" name="id" value="{{ $data->id }}">
																		<input type="hidden" name="status" value="1">
																		<input type="submit" value="Approve" class="btn btn-sm btn-outline-success">
																	</div>
																</form>
															</td>
															<td>
																<form method="POST" action="{{ route('payroll.admin.requestchange.create') }}">
																	@csrf
																	<div class="form-group">
																		<input type="hidden" name="id" value="{{ $data->id }}">
																		<input type="hidden" name="status" value="2">
																		<input type="submit" value="Reject" class="btn btn-sm btn-outline-danger">
																	</div>
																</form>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										@endforeach
									@endisset
								</tbody>
							</table>
							<div class="d-flex justify-content-end">
								@isset($attendance)
									{{ $attendance->links() }}
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