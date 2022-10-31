<div class="{{ $cardDisplayWidth }}">
    <div class="card" style="height: {{ $cardHeight }}px;">
        <div class="card-header d-flex justify-content-between">
            <span>
            	{{ $cardHeader }}
            </span>
            @if($cardData->count() > 0) 
            	<a href="{{ route($url) }}"
            		class="text-decoration-none fw-bold text-info">
            		{{ __('View') }}
            	</a>
            @endif
        </div>
        <div class="card-body overflow-auto">
        	@if($cardData->count() > 0)
	        	<div class="px-5 @if ($labelQty) d-flex justify-content-between @endif fw-bold my-n2 pb-3">
                    <span>
                        {{ __('#') }}
                    </span>
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
        		<div class="px-5 @if ($labelQty)  d-flex justify-content-between @endif">
                    <span>
                        {{ $loop->index + 1 }}
                    </span>
	        		<span>
                        {{ $data[$dataIndex[0]] }}
                    </span>
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