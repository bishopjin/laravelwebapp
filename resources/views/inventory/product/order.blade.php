@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Order Item') }}</div>

                <div class="card-body">
                    <form method="" action="" class="p-3 border rounded mb-3 mb-md-4">
                        <div class="form-group d-flex flex-row justify-content-between">
                            <span class="h4">Search Item</span><span class="text-danger fw-bolder" id="errorMsg"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Staff ID</label>
                                    <input type="text" value="{{ auth()->user()->id }}" class="form-control" readonly=""> 
                                </div>
                                <div class="col-md-5">
                                    <label>Product ID</label>
                                    <input type="number" class="form-control @error('item_id') is-invalid @enderror" id="itemID">
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center pt-3">
                                    <a href="javascript:void(0);" class="btn btn-outline-success w-100" id="searchBtn">Search</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="" action="" class="p-3 border rounded mb-3 mb-md-4" id="orderForm">
                        <div class="form-group pb-2 d-flex justify-content-between">
                            <span class="h4">Order Details</span> <span id="outOfstockErr" class="text-danger fw-bolder"></span>
                        </div>
                        <div class="form-group pb-3">
                            <div class="row pb-3">
                                <div class="col-md-4">
                                    <label>Brand</label>
                                    <input type="text" id="BID" class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label>Size</label>
                                    <input type="text" id="SID" class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label>Color</label>
                                    <input type="text" id="CID" class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <input type="text" id="TID" class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label>Category</label>
                                    <input type="text" id="CatID" class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label>Price</label>
                                    <input type="text" id="price" class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>In Stock</label>
                                    <input type="text" id="stock" class="form-control" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <label>Quantity</label>
                                    <input type="number" id="qty" name="qty" class="form-control" required="">
                                    <input type="hidden" id="item_id">
                                </div>
                                <div class="col-md-4 d-flex align-items-end pt-3">
                                    <a href="javascript:void(0);" class="btn btn-outline-primary w-100" id="saveOrderBtn">Save</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--  -->
                    <div class="border rounded p-3">
                        <div class="h4 pb-3">Order Summary</div>
                        <div class="table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Item ID</th>
                                        <th>Brand</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($order_summary))
                                        @foreach ($order_summary as $item)
                                            @php
                                                /* add trailing zero for non-decimal price */
                                                $price =  $item->price; 
                                                $cost = $item->price * $item->qty;  
                                            @endphp
                                            <tr>
                                                <td class="fw-bolder">{{ $item->order_number }}</td>
                                                <td>{{ $item->itemID }}</td>
                                                <td>{{ $item->brand }}</td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->color }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $price }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $cost }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var itemID = $('#itemID');
        var qty = $('#qty');
        var saveOrderBtn = $('#saveOrderBtn');
        var searchBtn = $('#searchBtn');
        var shoe_id = $('#item_id');
        var notNull = true;
        
        $('#datatable').DataTable();
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
                    url: '{{ route("inventory.order.show") }}',
                    type: 'POST',
                    data: {item_id : itemIDVal, _token : '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function(result, status, xhr){
                        if (result.length > 0) {
                            $('#BID').val(result[0].brand);
                            $('#CID').val(result[0].color);
                            $('#SID').val(result[0].size);
                            $('#TID').val(result[0].type);
                            $('#CatID').val(result[0].category);
                            $('#price').val(result[0].price);
                            $('#stock').val(result[0].in_stock);
                            $(shoe_id).val(result[0].id);
                            $('#errorMsg').html('');
                            if (result[0].in_stock == 0) {
                                $('#outOfstockErr').html('Out of Stock');
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
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error)
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
                    url: '{{ route("inventory.order.create") }}',
                    type: 'POST',
                    data: {_token : '{{ csrf_token() }}', shoe_id : itemIdVal, qty : qtyVal},
                    dataType: 'json',
                    success: function(result, status, xhr){
                        if(result === 1){
                            $('#orderForm *').filter(':input').each(function(){
                                $(this).val('');
                            });
                            $(itemID).val('');
                            $('#errorMsg').html('Order done.');
                            location.reload();
                        }
                        else {
                            $('#errorMsg').html('Item stock is low.');
                            alert('Item stock is low.')
                        }
                    },
                    error: function(xhr, status, error){
                        alert(JSON.stringify(xhr))
                        $('#errorMsg').html(error);
                    }
                });
            }
        });
    });
</script>
@endsection