@extends('payroll.layouts.app')

@section('payrollcontent')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card shadow">
					<div class="card-header">{{ __('Attendance') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payroll.employee.attendance.show') }}">
							@csrf
							<div class="small">{{ __('Select Date') }}</div>
							<div class="small d-flex flex-md-row flex-column align-items-md-end">
								<div class="form-group pe-md-3 pb-md-0 pb-2">
									<label class="small" for="strDt">{{ __('Start Date') }}</label>
									<input type="date" class="form-control" id="strDt" name="strDt" value="{{ old('strDt') ?? date('Y-m-d') }}">
								</div>
								<div class="form-group pe-md-3 pb-md-0 pb-2">
									<label class="small" for="endDt">{{ __('End Date') }}</label>
									<input type="date" class="form-control" id="endDt" name="endDt" value="{{ OLD('endDt') ?? date('Y-m-d') }}">
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Show Details">
								</div>
							</div>
						</form>
						<hr>
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
															<a href="{{ route('payroll.employee.dtr.show', ['id' => $data->id]) }}" class="fw-bold text-success">
																{{ __('Pending Request') }}
															</a>
														@elseif($data->changeRequest == 2)
															{{ __('Request Approved') }}
														@elseif($data->changeRequest == 3)
															<span class="text-danger">{{ __('Request Rejected') }}</span>
														@elseif($data->changeRequest == 4)
															{{ __('Computed') }}
														@else
															<a href="{{ route('payroll.employee.dtr.show', ['id' => $data->id]) }}" class="fw-bold">
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
	<!-- modal -->
	<div class="modal pt-2 pt-md-5 fade" role="dialog" aria-labelledby="aModalLabel" aria-hidden="true" id="aModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header h5">{{ __('404') }}</div>
                <div class="modal-body h4">
                    {{ __('Sorry, application under development.') }}
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection