<div class="p-md-3 p-2">
    <div class="fw-bold fs-5">{{ __('Orders') }}</div>
    <div class="d-flex justify-content-center">
        <div class="pt-1">
            @isset($orders)
                @foreach($orders as $order)
                    @php
                        $title = 'Order # '.$order->order_number;
                    @endphp
                    <div>
                        <a href="javascript:void(0);" class="text-decoration-none fw-bold orderSum" 
                            id="{{ $order->order_number }}" data-toggle="modal" data-target="#oDModal">
                            {{ $title }}
                        </a>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <div class="d-flex justify-content-center pt-2">
        @isset($orders)
            {{ $orders->links() }}
        @endisset
    </div>
</div>