<div class="fs-5 fw-bold">{{ $tableName }}</div>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				@foreach($tableHeader as $header)
					<th>{{ $header }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@php $num = 0; @endphp
			@forelse($tableData as $row)
				@php $num++; @endphp
				<tr>
					<td>{{ $num }}</td>
					@for ($i = 0; $i < count($dataKey); $i++)
					    <td>{{ $row[$dataKey[$i]] }}</td>
					@endfor
				</tr>
			@empty
			@endforelse
		</tbody>
	</table>
	<div class="d-flex justify-content-end">
		@isset($tableData)
       {{ $tableData->links() }}
    @endisset
	</div>
</div>
