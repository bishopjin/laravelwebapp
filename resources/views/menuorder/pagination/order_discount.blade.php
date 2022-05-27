<div class="p-md-3 p-2">
    <div class="fw-bold fs-5">{{ __('Discount Coupon') }}</div>
    <div class="d-flex justify-content-center">
    	<div class="px-md-3">
            @isset($coupons)
                @foreach($coupons as $code)
                    <div class="fw-bold">{{ $code->code }} &nbsp; {{ $code->discount * 100 }} {{ __('%') }}</div>
                @endforeach
            @endisset
        </div>
    </div>
    <div class="d-flex justify-content-center pt-2">
        @isset($coupons)
            {{ $coupons->links() }}
        @endisset
    </div>
</div>