@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">
						<a href="{{ route('payroll.employee.index') }}" class="text-decoration-none">{{ __('Back') }}</a>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead class="small">
									<th>{{ __('Date') }}</th>
									<th>{{ __('Work Schedule') }}</th>
									<th>{{ __('Holiday') }}</th>
									<th>{{ __('Time In') }}</th>
									<th>{{ __('Lunch Out') }}</th>
									<th>{{ __('Lunch In') }}</th>
									<th>{{ __('Time Out') }}</th>
									<th>{{ __('Manhour') }}</th>
									<th>{{ __('Overtime') }}</th>
									<th>{{ __('Night Diff') }}</th>
									<th>{{ __('Late (H)') }}</th>
									<th>{{ __('Action') }}</th>
								</thead>
								<tbody class="small fw-bold">
									@isset($attendance)
										@foreach($attendance as $data)
											@php
												$sched = explode('-', $data->workschedule->schedule);
												$worksched = date('h:i A', strtotime(trim($sched[0]))).' - '.date('h:i A', strtotime(trim($sched[1])));
											@endphp		
											<tr class="small">
												<td>{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
												<td>{{ $worksched ?? '' }}</td>
												<td>{{ $data->holiday->name ?? __('No') }}</td>
												<td>
													{{ $data->time_in ? date('h:i A', strtotime($data->time_in)) : '' }}
												</td>
												<td>
													{{ $data->time_out_break ? date('h:i A', strtotime($data->time_out_break)) : '' }}
												</td>
												<td>
													{{ $data->time_in_break ? date('h:i A', strtotime($data->time_in_break)) : '' }}
												</td>
												<td>
													{{ $data->time_out ? date('h:i A', strtotime($data->time_out)) : '' }}
												</td>
												<td>{{ number_format($data->manhour / 60, 2) }}</td>
												<td>{{ number_format($data->overtime / 60, 2) }}</td>
												<td>{{ number_format($data->night_diff / 60, 2) }}</td>
												<td>{{ $data->tardiness > 0 ? number_format($data->tardiness / 60, 2) : 0 }}</td>
												<td>
													@if($data->time_out)
														@if($data->changeRequest == 1)
															<a href="{{ route('payroll.employee.dtr.edit', ['id' => $data->id]) }}" class="fw-bold text-success">
																{{ __('Pending Request') }}
															</a>
														@elseif($data->changeRequest == 2)
															{{ __('Request Approved') }}
														@elseif($data->changeRequest == 3)
															<span class="text-danger">{{ __('Request Rejected') }}</span>
														@elseif($data->changeRequest == 4)
															{{ __('Computed') }}
														@else
															<a href="{{ route('payroll.employee.dtr.edit', ['id' => $data->id]) }}" class="fw-bold">
																{{ __('Request Change') }}
															</a>
														@endif
													@endif
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
	</div>
	<div class="container">
		<x-footerexam :color="'text-dark'"/>
	</div>
@endsection