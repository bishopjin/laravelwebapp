@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder">
                    {{ __('Order Item') }}
                </div>

                <div class="card-body">
                    <form class="p-3 border rounded mb-3 mb-md-4">
                        <div class="form-group d-flex flex-row justify-content-between">
                            <span class="h4">
                                {{ __('Search Item') }}
                            </span>
                            <span class="text-danger fw-bolder" 
                                id="errorMsg">
                            </span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>
                                        {{ __('Staff ID') }}
                                    </label>
                                    <input type="text" 
                                        value="{{ auth()->user()->id }}" 
                                        class="form-control" 
                                        readonly> 
                                </div>
                                <div class="col-md-5">
                                    <label>
                                        {{ __('Product ID') }}
                                    </label>
                                    <input type="number" 
                                        class="form-control @error('item_id') is-invalid @enderror" 
                                        id="itemID">
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center pt-3">
                                    <button type="button" 
                                        class="btn btn-outline-success w-100" 
                                        id="searchBtn">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="p-3 border rounded mb-3 mb-md-4" 
                        id="orderForm">
                        <div class="form-group pb-2 d-flex justify-content-between">
                            <span class="h4">
                                {{ __('Order Details') }}
                            </span> 
                            <span id="outOfstockErr" 
                                class="text-danger fw-bolder">
                            </span>
                        </div>
                        <div class="form-group pb-3">
                            <div class="row pb-3">
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Brand') }}
                                    </label>
                                    <input type="text" 
                                        id="BID" 
                                        class="form-control" 
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Size') }}
                                    </label>
                                    <input type="text" 
                                        id="SID" 
                                        class="form-control" 
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Color') }}
                                    </label>
                                    <input type="text" 
                                        id="CID" 
                                        class="form-control" 
                                        readonly>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Type') }}
                                    </label>
                                    <input type="text" 
                                        id="TID" 
                                        class="form-control" 
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Category') }}
                                    </label>
                                    <input type="text" 
                                        id="CatID" 
                                        class="form-control" 
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Price') }}
                                    </label>
                                    <input type="text" 
                                        id="price" 
                                        class="form-control" 
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>
                                        {{ __('In Stock') }}
                                    </label>
                                    <input type="text" 
                                        id="stock" 
                                        class="form-control" 
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        {{ __('Quantity') }}
                                    </label>
                                    <input type="number" 
                                        id="qty" 
                                        name="qty" 
                                        class="form-control" 
                                        required>
                                    <input type="hidden" 
                                        id="item_id">
                                </div>
                                <div class="col-md-4 d-flex align-items-end pt-3">
                                    <button type="button" 
                                        class="btn btn-outline-primary w-100" 
                                        id="saveOrderBtn">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--  -->
                    <div class="border rounded p-3">
                        <div class="h4 pb-3">
                            {{ __('Order Summary') }}
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ __('Order Number') }}
                                        </th>
                                        <th>
                                            {{ __('Item ID') }}
                                        </th>
                                        <th>
                                            {{ __('Brand') }}
                                        </th>
                                        <th>
                                            {{ __('Size') }}
                                        </th>
                                        <th>
                                            {{ __('Color') }}
                                        </th>
                                        <th>
                                            {{ __('Type') }}
                                        </th>
                                        <th>
                                            {{ __('Category') }}
                                        </th>
                                        <th>
                                            {{ __('Price') }}
                                        </th>
                                        <th>
                                            {{ __('Quantity') }}
                                        </th>
                                        <th>
                                            {{ __('Total Cost') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td class="fw-bolder">
                                                {{ $order->id }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->id }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->brand->brand }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->size->size }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->color->color }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->type->type }}</td>
                                            <td>
                                                {{ $order->shoe->category->category }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->price }}
                                            </td>
                                            <td>
                                                {{ $order->qty }}
                                            </td>
                                            <td>
                                                {{ $order->shoe->price * $order->qty }}
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($orders)
                                    {{ $orders->links() }}
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
<!-- modal -->
<div class="modal pt-md-5 pt-3 fade" 
    role="dialog" a
    ria-labelledby="oDModal" 
    aria-hidden="true" 
    id="oDModal" 
    tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <span id="modalHeader" 
                    class="h5">
                </span>
                <button class="btn btn-outline-success" 
                    data-bs-dismiss="modal">
                    {{ __('Close') }}
                </button>
            </div>
            <div class="modal-body">
                <div class="h4" 
                    id="responseContent">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var itemID = $('#itemID'),
            qty = $('#qty'),
            saveOrderBtn = $('#saveOrderBtn'),
            searchBtn = $('#searchBtn'),
            shoe_id = $('#item_id'),
            oDModal = $('#oDModal'),
            modalHeader = $('#modalHeader'),
            responseContent = $('#responseContent'),
            notNull = true;
        
        $(itemID).on('keyup', function(){
            $(itemID).removeClass('is-invalid');
        });

        $(qty).prop('disabled', true);
        
        $(saveOrderBtn).hide();

        /* Search item */
        $(searchBtn).on('click', function(){
            let itemIDVal = $('#itemID').val();
            
            if (itemIDVal && itemIDVal.search(/[^0-9]/i) == -1) {
                $.ajax({
                    url: '{{ url()->current() }}' + '/' + itemIDVal,
                    type: 'GET',
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function(result, status, xhr){
                        if (!$.isEmptyObject(result)) {
                            $('#BID').val(result.brand.brand);
                            $('#CID').val(result.color.color);
                            $('#SID').val(result.size.size);
                            $('#TID').val(result.type.type);
                            $('#CatID').val(result.category.category);
                            $('#price').val(result.price);
                            $('#stock').val(result.in_stock);
                            $(shoe_id).val(result.id);
                            $('#errorMsg').html('');
                            if (result.in_stock == 0) {
                                $('#outOfstockErr').html('Out of Stock');
                                $(modalHeader).html('Warning').css('color', '#FFFF00');
                                $(responseContent).html('Out of Stock');
                                $(oDModal).modal('show');
                            }
                            else {
                                $('#outOfstockErr').html('');
                                $(qty).prop('disabled', false);
                                $(saveOrderBtn).show();
                            }
                        }
                        else {
                            $('#orderForm *').filter(':input').each(function(){
                                $(this).val('');
                            });
                            $('#errorMsg').html('Product ID does not exist.');
                            $('#outOfstockErr').html('');
                            $(modalHeader).html('Warning').css('color', '#FFFF00');
                            $(responseContent).html('Product ID does not exist.');
                            $(oDModal).modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        $(modalHeader).html('Warning').css('color', '#FFFF00');
                        $(responseContent).html(error);
                        $(oDModal).modal('show');
                    }
                });
            }
            else {
                $(itemID).addClass('is-invalid').focus();
                $('#errorMsg').html('Invalid character, number only.');
            }
        });

        /* save order details */
        $(saveOrderBtn).on('click', function(){
            $('#orderForm *').filter(':input').each(function(){
                if (!$(this).val()) {
                    $('#' + this.id).addClass('is-invalid');
                    notNull = false;
                }
                else { $('#' + this.id).removeClass('is-invalid'); }
            });

            if (notNull) {
                let itemIdVal = $(shoe_id).val();
                let qtyVal = $(qty).val();

                $.ajax({
                    url: '{{ route("order.store") }}',
                    type: 'POST',
                    data: {_token : '{{ csrf_token() }}', inventory_item_shoe_id : itemIdVal, qty : qtyVal},
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function(result, status, xhr){
                        if(result){
                            $('#orderForm *').filter(':input').each(function(){
                                $(this).val('');
                            });
                            $(itemID).val('');
                            $('#errorMsg').html('Order done.');
                            $(modalHeader).html('Success').css('color', '#0F0');
                            $(responseContent).html('Order done.');
                        }
                        else {
                            $('#errorMsg').html('Item stock is low.');
                            $(modalHeader).html('Warning').css('color', '#FFFF00');
                            $(responseContent).html('Item stock is low.');
                        }
                        $(oDModal).modal('show');
                    },
                    error: function(xhr, status, error){
                        $(modalHeader).html('Error').css('color', '#F00');
                        $(responseContent).html(error);
                        //$('#errorMsg').html(JSON.stringify(xhr));
                        $(oDModal).modal('show');
                    }
                });
            }
        });
    });
</script>
@endsection