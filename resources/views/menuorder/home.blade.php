@extends('menuorder.layouts.app')

@section('ordercontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header px-0">
                    @php
                        $title = 'Online Menu Ordering';
                    @endphp
                    <x-navigation :title="$title"></x-navigation>
                </div>
                <div class="card-body">
                    <form method="" action="" id="orderMenu">
                        <div class="row">
                            {{-- Burger --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100">
                                    <div class="fw-bold fs-5 text-center pb-2">{{ __('Burgers') }}</div>
                                    @isset($burgers)
                                        <div class="row pb-1 small">
                                            <div class="col-5 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Quantity') }}</div>
                                        </div>
                                        @foreach($burgers as $burger)
                                            @php
                                                $name = 'burger_'.$burger->id;
                                                $price = 'burger_price_'.$burger->id;
                                                $qty = 'burger_qty_'.$burger->id;
                                                $plusBtn = 'burger_plus_'.$burger->id;
                                                $minusBtn = 'burger_minus_'.$burger->id;
                                            @endphp
                                            <div class="row d-flex pl-3">
                                                <div class="col-5">
                                                    <input type="checkbox" id="_{{ $burger->id }}" value="{{ $name }}" class="form-check-input" @if(str_contains(old($name), $burger->id)) checked @endif> 
                                                    <span class="form-check-label" id="{{ $name }}">{{ $burger->name }}</span>
                                                </div>
                                                
                                                <div class="col-3">
                                                    <span id="{{ $price }}">{{ $burger->price }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none plusBtn" id="{{ $plusBtn }}">
                                                                <i class="fa fa-plus fw-bold" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-3 border rounded">
                                                            <div class="fw-bold text-center" id="{{ $qty }}">{{ __('1') }}</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none minusBtn" id="{{ $minusBtn }}">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            {{-- Beverages --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100">
                                    <div class="fw-bold fs-5 text-center pb-2">{{ __('Beverages') }}</div>
                                    @isset($beverages)
                                        <div class="row pb-1 small">
                                            <div class="col-3 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Size') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Quantity') }}</div>
                                        </div>
                                        @foreach($beverages as $beverage)
                                            @php
                                                $name = 'beverage_'.$beverage->id;
                                                $price = 'beverage_price_'.$beverage->id;
                                                $size = 'beverage_size_'.$beverage->id;
                                                $qty = 'beverage_qty_'.$beverage->id;
                                                $plusBtn = 'beverage_plus_'.$beverage->id;
                                                $minusBtn = 'beverage_minus_'.$beverage->id;
                                            @endphp
                                            <div class="row d-flex pl-3">
                                                <div class="col-3">
                                                    <input type="checkbox" id="_{{ $beverage->id }}" class="form-check-input" value="{{ $name }}" @if(str_contains(old($name), $beverage->id)) checked @endif> 
                                                    <span class="form-check-label" id="{{ $name }}">{{ $beverage->name }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <span id="{{ $size }}">{{ $beverage->size }}</span>
                                                </div>
                                                <div class="col-2">
                                                    <span id="{{ $price }}">{{ $beverage->price }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none plusBtn" id="{{ $plusBtn }}">
                                                                <i class="fa fa-plus fw-bold" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-3 border rounded">
                                                            <div class="fw-bold text-center" id="{{ $qty }}">{{ __('1') }}</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none minusBtn" id="{{ $minusBtn }}">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            {{-- Combo meals --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100">
                                    <div class="fw-bold fs-5 text-center pb-2">{{ __('Combo Meals') }}</div>
                                    @isset($combos)
                                        <div class="row pb-1 small">
                                            <div class="col-5 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Quantity') }}</div>
                                        </div>
                                        @foreach($combos as $combo)
                                            @php
                                                $name = 'combo_'.$combo->id;
                                                $price = 'combo_price_'.$combo->id;
                                                $qty = 'combo_qty_'.$combo->id;
                                                $plusBtn = 'combo_plus_'.$combo->id;
                                                $minusBtn = 'combo_minus_'.$combo->id;
                                            @endphp
                                            <div class="row d-flex pl-3">
                                                <div class="col-5">
                                                    <input type="checkbox" id="_{{ $combo->id }}" class="form-check-input" value="{{ $name }}" @if(str_contains(old($name), $combo->id)) checked @endif> 
                                                    <span class="form-check-label" id="{{ $name }}">{{ $combo->name }}</span>
                                                </div>
                                                
                                                <div class="col-3">
                                                    <span id="{{ $price }}">{{ $combo->price }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none plusBtn" id="{{ $plusBtn }}">
                                                                <i class="fa fa-plus fw-bold" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-3 border rounded">
                                                            <div class="fw-bold text-center" id="{{ $qty }}">{{ __('1') }}</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="text-decoration-none minusBtn" id="{{ $minusBtn }}">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="p-md-3 p-2">
                                                <div class="fw-bold fs-5">{{ __('Orders') }}</div>
                                                <div class="px-md-5" id="orders">
                                                    @isset($orders)
                                                        @foreach($orders as $order)
                                                            @php
                                                                $title = 'Order # '.$order->order_number;
                                                            @endphp
                                                            <div>
                                                                <a href="javascript:void(0);" class="text-decoration-none fw-bold orderSum" 
                                                                    id="{{ $order->order_number }}">{{ $title }}</a>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-md-3 p-2">
                                                <div class="fw-bold fs-5">{{ __('Discount Coupon') }}</div>
                                                <div class="px-md-3">
                                                    @isset($coupons)
                                                        @foreach($coupons as $code)
                                                            <div class="fw-bold">{{ $code->code }} &nbsp; {{ $code->discount * 100 }} {{ __('%') }}</div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 px-md-5">
                                <div class="form-group pb-3">
                                    <label>{{ __('Coupon Code') }}</label>
                                    <input type="text" name="code" class="form-control" id="code">
                                </div>
                                <button type="button" class="btn btn-outline-success" id="checkout" 
                                    data-toggle="modal" data-target="#checkOutModal">
                                    {{ __('Check Out') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    @php
                        $developer = 'Gene Arthur Sedan';
                    @endphp
                    <x-footer-menu :dev="$developer"></x-footer-menu>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- overlay / modal --}}
<div class="modal pt-md-5 pt-3" role="dialog" aria-labelledby="checkOutModal" aria-hidden="true" id="checkOutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light" id="modalHeader"></div>
            <div class="modal-body">
                <div id="responseContent"></div>
            </div>
            <div class="modal-footer py-2 d-flex justify-content-between">
                <button class="btn btn-outline-danger" data-dismiss="modal" id="exitBtn">
                    {{ __('Cancel') }}
                </button>
                <a href="javascript:void(0);" class="btn btn-outline-primary px-5 my-3" id="closeDialog"></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var checkout = $('#checkout');
        var closeDialog = $('#closeDialog');
        var modalHeader = $('#modalHeader');
        var responseContent = $('#responseContent');
        var exitBtn = $('#exitBtn');
        var modal = $('#checkOutModal');
        var code = $('#code');
        var plusBtn = $('.plusBtn');
        var minusBtn = $('.minusBtn');
        var orderSum = $('.orderSum');
        var noError = true;
        var tax = @json($taxes);
        var arr = [], qty_object = {};

        $(closeDialog).hide();
        $(exitBtn).show();

        /* get all checked order */
        function getAllOrder(discount) {
            var allcheck = $('#orderMenu input:checked');
            var content = '', name, price, discounted = 0, total = 0, qty = 0, taxpercent = 0, totalTax = 0, subtotal = 0;
            arr = [], qty_object = {};

            $(modalHeader).html('Order Summary');

            allcheck.each(function () {
                arr.push($(this).val());
            });

            if (arr.length === 0) {
                $(exitBtn).show();
                $(responseContent).html('<div class="text-center">No Order</div>');
                $(closeDialog).hide();
                noError = false;
            }
            else {
                $(closeDialog).html('Confirm').show();
                content += '<div class="row px-5 pb-2"><div class="col-6 fw-bold">Name</div><div class="col-3 fw-bold">Quantity</div><div class="col-3 fw-bold">Amount</div></div>'; 

                for (var i = 0; i < arr.length; i++) {
                    var size = '';
                    name = $('#' + arr[i]).html();
                    price = parseFloat($('#' + arr[i].replace('_', '_price_')).html());
                    qty = parseInt($('#' + arr[i].replace('_', '_qty_')).html());
                    subtotal += (price * qty);
                    /* set the qty */
                    qty_object[arr[i]] = qty + '_' + price;

                    if (arr[i].includes('beverage')) {
                        size = '(' + $('#' + arr[i].replace('_', '_size_')).html() + ')';
                    }

                    content += `<div class="row px-5"><div class="col-6">${name}&nbsp;${size}</div><div class="col-3">${qty}</div><div class="col-3">${price * qty}</div></div>`;
                }
                content += `<hr><div class="row px-5 pb-2"><div class="col-9">Sub Total</div><div class="col-3">${subtotal}</div></div>`;
                
                for(var i = 0; i < tax.length; i++){
                    taxpercent = subtotal * parseFloat(tax[i]['percentage']);
                    content += `<div class="row px-5 pb-2"><div class="col-9">${tax[i]['tax']} ${parseFloat(tax[i]['percentage']) * 100}%</div><div class="col-3">+ ${taxpercent.toFixed(2)}</div></div>`;
                    totalTax += taxpercent;
                }

                discounted = (totalTax + subtotal) * parseFloat(discount);
                total = (totalTax + subtotal) - discounted;
                content += `<div class="row px-5"><div class="col-9 fw-bold">Discount ${discount * 100}%</div><div class="col-3 fw-bold">- ${discounted.toFixed(2)}</div></div>`;
                content += `<hr><div class="row px-5 pb-2"><div class="col-9 fw-bold fs-5">Total</div><div class="col-3 fw-bold fs-5">${total.toFixed(2)}</div></div>`;
                $(responseContent).html(content);
                noError = true;
            }
            //alert(JSON.stringify(arr)); alert(JSON.stringify(qty_object));
        }

        /* add qty */
        $(plusBtn).on('click', function () {
            let eleContID = this.id.replace('_plus_', '_qty_');
            let count = parseInt($('#' + eleContID).html());
            let qty = count += 1;
            
            $('#' + eleContID).html(qty);
        });

        /* sub qty */
        $(minusBtn).on('click', function () {
            let eleContID = this.id.replace('_minus_', '_qty_');
            let count = parseInt($('#' + eleContID).html());
            let qty = count -= 1;

            if (count > 0) {
                $('#' + eleContID).html(qty);
            }
        });

        /* show order details */
        $('body').on('click', '.orderSum', function () {
            let eleId = this.id, content = '', size = '', qty = 0, price = 0, subtotal = 0, totaltax = 0,
                totalAmount = 0, taxpercent = 0, discounted = 0;
            noError = false;

            $(exitBtn).hide();
            $(modal).show();
            $(closeDialog).html('Close').show();
            $(modalHeader).html('Order Details');
            $(responseContent).html(`<div class="d-flex align-items-center ps-3"><span class="spinner-border spinner-border-sm"></span><span class="ps-2">Loading data please wait...</span></div>`);
        
            $.ajax({
                url: '{{ url()->full() }}/order/details/' + eleId,
                type: 'GET',
                dataType: 'json',
                success: function (result, status, xhr) {
                    $(modalHeader).html('Order Details');
                    $(responseContent).html('');

                    content += `<div class="row px-5 pb-2"><div class="col-6 fw-bold">Name</div><div class="col-3 fw-bold">Quantity</div><div class="col-3 fw-bold">Amount</div></div>`;
                    if (result.length > 0) {
                        var tax = result[0].TAX;
                        var order = result[1].ORDER;
                        var discount = 0, discount_code = '0', subtotal = 0, totaltax = 0, discounted = 0, taxpercent = 0;

                        //alert(JSON.stringify(order))
                        order.forEach(function(item) {
                            var total = parseInt(item.ItemQty) * parseInt(item.ItemPrice), 
                                size = item.ItemSize == '0' ? '' : item.ItemSize;

                            discount_code = item.CouponCode;
                            discount = item.Discount;
                            subtotal += total;

                            content += `<div class="row px-5"><div class="col-6">${item.ItemName}&nbsp;${size}</div><div class="col-3">${item.ItemQty}</div><div class="col-3">${total}</div></div>`;
                        });
                        content += `<hr><div class="row px-5 pb-2"><div class="col-9">Sub Total</div><div class="col-3">${subtotal}</div></div>`;

                        tax.forEach(function(tax) {
                            taxpercent = 0;
                            taxpercent += (subtotal * parseFloat(tax.percentage));
                            totaltax += taxpercent;
                            content += `<div class="row px-5 pb-2"><div class="col-9">${tax.tax} ${parseFloat(tax.percentage) * 100}%</div><div class="col-3">+ ${taxpercent.toFixed(2)}</div></div>`;
                        });

                        discounted = (totaltax + subtotal) * parseFloat(discount);

                        content += `<div class="row px-5"><div class="col-9 fw-bold">Discount ${discount * 100}%</div><div class="col-3 fw-bold">- ${discounted.toFixed(2)}</div></div>`;
                        content += `<div class="row px-5"><div class="col fw-bold">Coupon Code : ${discount_code}</div></div>`;

                        totalAmount = (totaltax + subtotal) - discounted;
                        content += `<hr><div class="row px-5 pb-2"><div class="col-9 fw-bold fs-5">Total</div><div class="col-3 fw-bold fs-5">${totalAmount.toFixed(2)}</div></div>`;
                    }
                    $(responseContent).html(content);
                },
                error: function (xhr, status, error) {
                    $(closeDialog).hide();
                    $(modalHeader).html('Error');
                    $(responseContent).html(JSON.stringify(error));
                }
            });
        });

        /* submit order */
        $(checkout).on('click', function () {
            $(exitBtn).show();
            if ($(code).val()) {
                $.ajax({
                    url: '{{ url()->full() }}/checkCoupon/' + $(code).val(),
                    type: 'GET',
                    dataType: 'json',
                    success: function(result, status, xhr) {
                        if (!result) {
                            $(exitBtn).show();
                            $(closeDialog).hide();
                            $(modalHeader).html('Invalid');
                            $(responseContent).html('Invalid Coupon Code');
                            $(modal).show();
                            noError = false;
                        }
                        else {
                            getAllOrder(parseFloat(result));
                        }
                    },
                    error: function(xhr, status, error) {
                        noError = false;
                        $(closeDialog).hide();
                        $(modalHeader).html('Error');
                        $(responseContent).html(error);
                    }
                });
            }
            else {
                getAllOrder(0);
            }
        });

        $(closeDialog).on('click', function () {
            let title, eleId;
            
            if (noError) {
                $.ajax({
                    url: '{{ route("order.save") }}',
                    type: 'POST',
                    data: {_token : '{{ csrf_token() }}', code : $(code).val(), quantity : qty_object},
                    dataType: 'json',
                    success: function(result, status, xhr) {
                        if (result != 0) {
                            let allcheck = $('#orderMenu input:checked');
                            title = 'Order # ' + result;
                            eleId = result;
                            /* add the new order */
                            $('#orders').append(`<div>
                                    <a href="javascript:void(0);" class="text-decoration-none fw-bold orderSum" 
                                        id="${eleId}">${title}</a>
                                </div>`);
                            /* clear the selection */
                            allcheck.each(function () {
                                $('#' + this.id).prop('checked', false);
                                $('#combo_qty' + this.id).html('1');
                                $('#burger_qty' + this.id).html('1');
                                $('#beverage_qty' + this.id).html('1');
                            });
                            $(exitBtn).click();
                            $(code).val('');
                        }
                        else { alert(result) }                
                    },
                    error: function(xhr, status, error) {
                        hasError = true;
                        $(closeDialog).hide();
                        $(modal).show();
                        $(modalHeader).html('Error');
                        $(responseContent).html(error);
                    }
                });
            }
            else {
                $('.modal').hide();
            }
        });
    });
</script>
@endsection
