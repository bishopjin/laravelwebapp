<div class="card">
	<div class="card-header fs-5 fw-bold">
		{{ $tableName }}
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						@if ($hasRowNumber) 
							<th>{{ __('#') }}</th>
						@endif

						@foreach($tableHeader as $header)
							<th>{{ $header }}</th>
						@endforeach

						@if ($hasEditButton OR $hasAddButton OR $hasDeleteButton OR $hasViewButton) 
							<th>{{ __('Action') }}</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@php $num = 0; @endphp
					@forelse($newTableData ?? $tableData as $row)
						@php $num++; @endphp
						<tr>
							@if ($hasRowNumber) 
								<td>{{ $num }}</td>
							@endif
							
							@for ($i = 0; $i < sizeOf($dataKey); $i++)
								@if($deepRelation)
									<td>{{ $row[$rootRelationKey][$dataKey[$i]][$dataKey[$i]] ?? $row[$dataKey[$i]] }}</td>
								@else
									<td>{{ $row[$dataKey[$i]][$dataKey[$i]] ?? $row[$dataKey[$i]] }}</td>
								@endif
							@endfor

							@if ($hasEditButton OR $hasAddButton OR $hasDeleteButton OR $hasViewButton) 
								<th>
									@if ($hasAddButton)
										<a href="{{ $addLink }}" 
                      class="btn btn-outline-primary border-0">
                      {{ __('Add') }}
	                  </a>
	                @endif
									@if ($hasEditButton)
										<a href="{{ route($editLink, $row['id']) }}"
                      class="btn btn-outline-success border-0">
                      {{ __('Edit') }}
	                  </a>
	                @endif
	                @if ($hasViewButton)
										<a href="{{ route($viewLink, $row['id']) }}"
                      class="btn btn-outline-info border-0">
                      {{ __('View') }}
	                  </a>
	                @endif
									@if ($hasDeleteButton)
                    @if ($tableName == 'Edit Users' OR $tableName == 'User List')
                    	<form method="POST" 
	                      action="{{ route($deleteLink, $row['id']) }}">
	                      
	                      @csrf
	                      @method('DELETE')
	                      <input type="submit" 
	                          value="{{ $row['changeStatus'] ? 'Enable' : 'Disable' }}"
	                          @class([
	                              'fw-bold', 
	                              'text-danger' => !$row['changeStatus'], 
	                              'text-success' => $row['changeStatus'],
	                          ])>
	                    </form>
                    @else
                    	<form method="POST" 
	                      action="{{ $deleteLink }}">
	                      
	                      @csrf
	                      @method('DELETE')
	                      	<input type="submit" 
	                          value="Delete"
	                          class="btn btn-outline-danger border-0">
	                    </form>
                    @endif
									@endif
								</th>
							@endif
						</tr>
					@empty
						<tr>
							<td 
								colspan="{{ sizeOf($dataKey) + 1 + ($hasRowNumber ? 1 : 0) + ($hasEditButton OR $hasAddButton OR $hasDeleteButton ? 1 : 0) }}"
								class="text-center">
								{{ __('No Data') }}
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="d-flex justify-content-end">
				@isset($tableData)
					@if(sizeOf($tableData) > 0)
		       {{ $tableData->links() }}
		      @endif
		    @endisset
			</div>
		</div>
	</div>
</div>
