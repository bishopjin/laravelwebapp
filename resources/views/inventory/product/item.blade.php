@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
        	<div class="card">
				    <div class="card-header fw-bolder">
				        {{ $itemDetails['header'] }}
				    </div>

				    <div class="card-body">
				        <form method="POST" 
				            action="{{ $itemDetails['isNewItem'] ? route($itemDetails['url']) : route($itemDetails['url'], $itemDetails['itemID']) }}" 
				            class="px-md-5">
				            @csrf

				            @if (!$itemDetails['isNewItem'])
				            	@method('PUT')
				            @endif

				            <div class="form-group pb-3">
				                <label for="varInput">
				                    {{ $itemDetails['itemLabel'] }}
				                </label>

				                <input 
				                	type="text" 
				                	class="form-control"
				                	id="varInput" 
				                	value="{{ $itemDetails['itemName'] ?? old(Str::lower($itemDetails['itemLabel'])) }}" 
				                	name="{{ Str::lower($itemDetails['itemLabel']) }}"/>

				                @error(Str::lower($itemDetails['itemLabel']))
				                    <span class="text-danger" 
				                        role="alert">
				                        <strong>
				                            {{ $message }}
				                        </strong>
				                    </span>
				                @enderror
				            </div>

				            <div class="form-group d-flex justify-content-between py-2">
				            		@if (!$itemDetails['isNewItem'])
						            	<a href="{{ route($itemDetails['returnRoute']) }}"
						            		class="btn btn-outline-success px-5" 
						            	>
						            		{{ __('Back') }}
						            	</a>
						            @else
						            	<a href="{{ route('inventorydashboard.index') }}"
						            		class="btn btn-outline-success px-5" 
						            	>
						            		{{ __('Back') }}
						            	</a>
						            @endif
				                <input type="submit" 
				                    class="btn btn-outline-primary px-5" 
				                    value="Save">
				            </div>
				        </form>
				    </div>
				</div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection