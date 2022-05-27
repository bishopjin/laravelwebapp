<div class="border rounded p-3 w-100">
    <div>
        <span class="fw-bold">{{ __('Orders') }}</span>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Order Number') }}</th>
                    <th>{{ __('Tax (%)') }}</th>
                    <th>{{ __('Discount (%)') }}</th>
                    <th>{{ __('Subtotal') }}</th>
                    <th>{{ __('Total Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @isset($pagination)
                    @foreach($pagination as $order)
                        @php
                            $taxed_amount = ($order['SubTotal'] * $order['Tax']) + $order['SubTotal'];
                        @endphp
                        <tr>
                            <td>{{ $order['OrderNumber'] }}</td>
                            <td>{{ $order['Tax'] * 100 }}</td>
                            <td>{{ $order['Discount'] * 100 }}</td>
                            <td>{{ $order['SubTotal'] }}</td>
                            <td>{{ $taxed_amount - ($taxed_amount * $order['Discount']) }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            @isset($pagination)
                {{ $pagination->links() }}
            @endisset
        </div>
    </div>
</div>