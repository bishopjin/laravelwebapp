<div class="{{ $cardDisplayWidth }}">
    <div class="card" style="height: {{ $cardHeight }}px;">
        <div class="card-header d-flex justify-content-between">
            <span>
            	{{ $cardHeader }}
            </span>
            @if($cardData) 
            	<a href="{{ route($url) }}"
            		class="text-decoration-none fw-bold text-info">
            		{{ __('View') }}
            	</a>
            @endif
        </div>
        <div class="card-body overflow-auto">
        	@if($cardData)
	        	<div class="@if ($labelQty) d-flex justify-content-around @endif fw-bold my-n2 pb-3">
	        		<span>
	        			{{ $labelName }}
	        		</span>
	        		@if ($labelQty) 
		        		<span>
		        			{{ $labelQty }}
		        		</span>
		        	@endif
	        	</div>
        	@endif

        	@forelse($cardData as $data)
        		<div class="@if ($labelQty)  d-flex justify-content-around @endif">
	        		<span>{{ $data[$dataIndex[0]] }}</span>
	        		@if ($labelQty) 
	        			<span>{{ $data[$dataIndex[1]] }}</span>
	        		@endif
	        	</div>
        	@empty
        		<div class="text-center">
        			No Data
        		</div>
        	@endforelse
        </div>
    </div>
</div>