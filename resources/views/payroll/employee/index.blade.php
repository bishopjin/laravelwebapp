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
							<table class="table">
								<thead class="small">
									<th class="small">{{ __('Date') }}</th>
									<th class="small">{{ __('Work Schedule') }}</th>
									<th class="small">{{ __('Holiday') }}</th>
									<th class="small">{{ __('Time In') }}</th>
									<th class="small">{{ __('Lunch Out') }}</th>
									<th class="small">{{ __('Lunch In') }}</th>
									<th class="small">{{ __('Time Out') }}</th>
									<th class="small">{{ __('Manhour') }}</th>
									<th class="small">{{ __('Overtime') }}</th>
									<th class="small">{{ __('Night Diff') }}</th>
									<th class="small">{{ __('Late (H)') }}</th>
									<th class="small">{{ __('Action') }}</th>
								</thead>
								<tbody class="small fw-bold">
									@isset($attendance)
										@foreach($attendance as $data)
											@php
												$sched = explode('-', $data->workschedule->schedule);
												$worksched = date('h:i A', strtotime(trim($sched[0]))).' - '.date('h:i A', strtotime(trim($sched[1])));
											@endphp		
											<tr>
												<td class="small">{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
												<td class="small">{{ $worksched ?? '' }}</td>
												<td class="small">{{ $data->holiday->name ?? __('No') }}</td>
												<td class="small">
													{{ $data->time_in ? date('h:i A', strtotime($data->time_in)) : '' }}
												</td>
												<td class="small">
													{{ $data->time_out_break ? date('h:i A', strtotime($data->time_out_break)) : '' }}
												</td>
												<td class="small">
													{{ $data->time_in_break ? date('h:i A', strtotime($data->time_in_break)) : '' }}
												</td>
												<td class="small">
													{{ $data->time_out ? date('h:i A', strtotime($data->time_out)) : '' }}
												</td>
												<td class="small">{{ number_format($data->manhour / 60, 2) }}</td>
												<td class="small">{{ number_format($data->overtime / 60, 2) }}</td>
												<td class="small">{{ number_format($data->night_diff / 60, 2) }}</td>
												<td class="small">{{ number_format($data->tardiness / 60, 2) }}</td>
												<td class="small">
													<a href="#" class="fw-bold">
														{{ __('Request Change') }}
													</a>
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