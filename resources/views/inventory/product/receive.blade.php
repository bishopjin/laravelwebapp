@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Receive Item') }}</div>

                <div class="card-body">
                    <form method="" action="" class="px-md-5" id="deliverForm">
                        <div class="form-group pb-3">
                            <div class="row g-1">
                                <div class="col-9">
                                    <label>Product ID</label>
                                    <input type="text" class="form-control" id="itemID" required>
                                </div>
                                <div class="col-3 d-flex align-items-end">
                                    <a href="javascript:void(0);" class="btn btn-outline-success w-100" id="searchBtn">Search</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span id="errorMsg" class="text-danger fw-bolder"></span>
                                    <span id="successMsg" class="fw-bolder"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group py-3">
                            <label>Brand</label>
                            <input type="text" class="form-control" id="BID" readonly="">
                        </div>

                        <div class="form-group pb-3">
                            <label>Size</label>
                            <input type="text" id="SID" class="form-control" readonly="">
                        </div>

                        <div class="form-group pb-3">
                            <label>Color</label>
                            <input type="text" id="CID" class="form-control" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Type</label>
                            <input type="text" id="TID" class="form-control" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Category</label>
                            <input type="text" id="CatID" class="form-control" readonly="">
                        </div>

                        <div class="form-group pb-3">
                            <label>Quantity</label>
                            <input type="number" id="qty" class="form-control" required="">
                        </div>
                        <div class="form-group d-flex justify-content-center py-2">
                            <a href="javascript:void(0);" class="btn btn-outline-primary px-5" id="saveOrderBtn">Save</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var searchBtn = $('#searchBtn');
        var saveOrderBtn = $('#saveOrderBtn');
        var itemID = $('#itemID');
        var qty = $('#qty');
        var notNull = true;

        /* Search item */
        $(searchBtn).on('click', function(){
            let itemIDVal = $(itemID).val();
            
            if (itemIDVal && itemIDVal.search(/[^0-9]/i) == -1) {
                $.ajax({
                    url: '{{ route("inventory.order.show") }}',
                    type: 'POST',
                    data: {item_id : itemIDVal, _token : '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function(result, status, xhr){
                        if (result.length > 0) {
                            $('#BID').val(result[0].brand.brand);
                            $('#CID').val(result[0].color.color);
                            $('#SID').val(result[0].size.size);
                            $('#TID').val(result[0].type.type);
                            $('#CatID').val(result[0].category.category);
                            $('#errorMsg').html('');
                        }
                        else {
                            $('#deliverForm *').filter(':input').each(function(){
                                if(this.id !== 'itemID') {
                                    $(this).val('');
                                }
                            });
                            $('#errorMsg').html('Product ID does not exist.');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#errorMsg').html(error);
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
            $('#deliverForm *').filter(':input').each(function(){
                if (!$(this).val()) {
                    $('#' + this.id).addClass('is-invalid');
                    notNull = false;
                }
                else { $('#' + this.id).removeClass('is-invalid'); }
            });

            if (notNull) {
                let itemIdVal = $(itemID).val();
                let qtyVal = $(qty).val();

                $.ajax({
                    url: '{{ route("inventory.deliver.create") }}',
                    type: 'POST',
                    data: {_token : '{{ csrf_token() }}', shoe_id : itemIdVal, qty : qtyVal},
                    dataType: 'json',
                    success: function(result, status, xhr){
                        $('#deliverForm *').filter(':input').each(function(){
                            $(this).val('');
                        });
                        if(result === 1){
                            $('#successMsg').html('Item received.');
                        }
                    },
                    error: function(xhr, status, error){
                        $('#errorMsg').html(error);
                    }
                });
            }
        });

    });
</script>
@endsection