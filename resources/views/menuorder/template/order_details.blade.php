@isset($order)
	@php 
		$subtotal = 0; 
		$code = 0;
		$discount = 0;
		$taxPercent = 0;
		$totalAmount = 0;
	@endphp
	<div class="row px-5 pb-2">
		<div class="col-6 fw-bold">{{ __('Name') }}</div>
		<div class="col-3 fw-bold">{{ __('Quantity') }}</div>
		<div class="col-3 fw-bold">{{ __('Amount') }}</div>
	</div>
	@foreach($order as $item)
		@php
			$size = $item['ItemSize'] == '0' ? '' : $item['ItemSize'];
			$total = (float) $item['ItemQty'] * (float) $item['ItemPrice'];
			$code = $item['CouponCode'];
			$discount = $item['Discount'];
			$subtotal += $total;
		@endphp
		<div class="row px-5">
			<div class="col-6">{{ $item['ItemName'] }}&nbsp;{{ $size }}</div>
			<div class="col-3">{{ $item['ItemQty'] }}</div>
			<div class="col-3">{{ $total }}</div>
		</div>
	@endforeach
	<hr>
	<div class="row px-5 pb-2">
		<div class="col-9">{{ __('Sub Total') }}</div>
		<div class="col-3">{{ $subtotal }}</div>
	</div>

	@isset($tax)
		@foreach($tax as $x)
			@php 
				$taxPercent += $x['percentage'];
			@endphp
			<div class="row px-5 pb-2">
				<div class="col-9">{{ $x['tax'] }}&nbsp;{{ $x['percentage'] * 100 }}{{ __('%') }}</div>
				<div class="col-3">{{ __('+ ') }}{{ $x['percentage'] * $subtotal }}</div>
			</div>
		@endforeach
	@endisset
	@php
		$totalAmount = $subtotal + ($subtotal * $taxPercent);
	@endphp
	<div class="row px-5">
		<div class="col-9 fw-bold">{{ __('Discount') }}&nbsp;{{ $discount * 100 }}{{ __('%') }}</div>
		<div class="col-3 fw-bold">{{ __('- ') }}{{ $discount * $totalAmount }}</div>
	</div>
	<div class="row px-5">
		<div class="col fw-bold">{{ __('Coupon Code : ') }}{{ $code }}</div>
	</div>
	<hr>
	<div class="row px-5 pb-2">
		<div class="col-9 fw-bold fs-5">{{ __('Total') }}</div>
		<div class="col-3 fw-bold fs-5">{{ $totalAmount - ($discount * $totalAmount) }}</div>
	</div>
@endisset