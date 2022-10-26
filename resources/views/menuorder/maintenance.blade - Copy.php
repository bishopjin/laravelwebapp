@extends('menuorder.layouts.app')

@section('ordercontent')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card"> 
                <div class="card-header px-0">
                    @php
                        $title = 'Maintenance';
                    @endphp
                    <x-navigation :title="$title"></x-navigation>
                </div>
                <div class="card-body">
                    <form method="" action="" id="orderMenu">
                        <div class="row">
                            {{-- Burger --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100" id="burger_panel">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ __('Burgers') }}</span>
                                        <button type="button" class="btn btn-outline-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addModal" id="add_burger">
                                            {{ __('Add Item') }}
                                        </button>
                                    </div>
                                    <hr>
                                    @isset($burgers)
                                        <div class="row pb-1">
                                            <div class="col-5 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Action') }}</div>
                                        </div>
                                        @foreach($burgers as $burger)
                                            @php
                                                $name = 'burger_'.$burger->id;
                                            @endphp
                                            <div class="row pb-1">
                                                <div class="col-5"> 
                                                    <span id="{{ $name }}_input1">{{ $burger->name }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <span id="{{ $name }}_input2">{{ $burger->price }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#addModal" id="{{ $name }}">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            {{-- Beverages --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100" id="beverage_panel">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ __('Beverages') }}</span>
                                        <button type="button" class="btn btn-outline-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addModal" id="add_beverage">
                                            {{ __('Add Item') }}
                                        </button>
                                    </div>
                                    <hr>
                                    @isset($beverages)
                                        <div class="row pb-1">
                                            <div class="col-3 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Size') }}</div>
                                            <div class="col-2 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Action') }}</div>
                                        </div>
                                        @foreach($beverages as $beverage)
                                            @php
                                                $name = 'beverage_'.$beverage->id;
                                            @endphp
                                            <div class="row pb-1">
                                                <div class="col-3"> 
                                                    <span id="{{ $name }}_input1">{{ $beverage->beveragename->name }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <span id="{{ $name }}_input2">{{ $beverage->beveragesize->size }}</span>
                                                </div>
                                                <div class="col-2">
                                                    <span id="{{ $name }}_input3">{{ $beverage->price }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#addModal" id="{{ $name }}">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>

                            {{-- Combo meals --}}
                            <div class="col-md-4 d-flex">
                                <div class="border rounded p-3 w-100" id="combo_panel">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ __('Combo Meals') }}</span>
                                        <button type="button" class="btn btn-outline-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addModal" id="add_combo">
                                            {{ __('Add Item') }}
                                        </button>
                                    </div>
                                    <hr>
                                    @isset($combos)
                                        <div class="row pb-1">
                                            <div class="col-5 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Price') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Action') }}</div>
                                        </div>
                                        @foreach($combos as $combo)
                                            @php
                                                $name = 'combo_'.$combo->id;
                                            @endphp
                                            <div class="row pb-1">
                                                <div class="col-5"> 
                                                    <span id="{{ $name }}_input1">{{ $combo->name }}</span>
                                                </div>
                                                
                                                <div class="col-4">
                                                    <span id="{{ $name }}_input2">{{ $combo->price }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#addModal" id="{{ $name }}">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                        <!-- 2nd row -->
                        <div class="row pt-2 pt-md-3">
                            {{-- TAX --}}
                            <div class="col-md-6 d-flex">
                                <div class="border rounded p-3 w-100" id="tax_panel">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ __('Tax') }}</span>
                                        <button type="button" class="btn btn-outline-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addModal" id="add_tax">
                                            {{ __('Add Item') }}
                                        </button>
                                    </div>
                                    <hr>
                                    @isset($taxes)
                                        <div class="row pb-1">
                                            <div class="col-5 fw-bold">{{ __('Name') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Percentage (%)') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Action') }}</div>
                                        </div>
                                        @foreach($taxes as $tax)
                                            @php
                                                $name = 'tax_'.$tax->id;
                                            @endphp
                                            <div class="row pb-2">
                                                <div class="col-5"> 
                                                    <span id="{{ $name }}_input1">{{ $tax->tax }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <span id="{{ $name }}_input2">{{ $tax->percentage * 100 }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#addModal" id="{{ $name }}">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                            {{-- Coupon --}}
                            <div class="col-md-6 d-flex">
                                <div class="border rounded p-3 w-100" id="coupon_panel">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ __('Coupon') }}</span>
                                        <button type="button" class="btn btn-outline-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addModal" id="add_coupon">
                                            {{ __('Add Item') }}
                                        </button>
                                    </div>
                                    <hr>
                                    @isset($coupons)
                                        <div class="row pb-1">
                                            <div class="col-5 fw-bold">{{ __('Code') }}</div>
                                            <div class="col-4 fw-bold">{{ __('Discount (%)') }}</div>
                                            <div class="col-3 fw-bold">{{ __('Action') }}</div>
                                        </div>
                                        @foreach($coupons as $coupon)
                                            @php
                                                $name = 'coupon_'.$coupon->id;
                                            @endphp
                                            <div class="row pb-2">
                                                <div class="col-5"> 
                                                    <span id="{{ $name }}_input1">{{ $coupon->code }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <span id="{{ $name }}_input2">{{ $coupon->discount * 100 }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#addModal" id="{{ $name }}">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                        <!-- 3rd row -->
                        <div class="row pt-2 pt-md-3">
                            {{-- Orders --}}
                            <div class="col d-flex" id="admin-order">
                                @include('menuorder.pagination.admin_order')
                            </div>
                        </div>
                        <!-- 4th row -->
                        <div class="row pt-2 pt-md-3">
                            {{-- User --}}
                            <div class="col d-flex" id="admin-user">
                                @include('menuorder.pagination.admin_user')
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
{{-- reusable modal --}}
<div class="modal pt-md-5 pt-3 fade" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modalHead"></div>
            <div class="modal-body">
                <div class="container">
                    <div class="row justify-content-center" id="modalContent"></div>
                    <div class="row justify-content-center py-2" id="eMsg"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-primary" id="saveItemBtn">{{ __('Save') }}</button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var saveItemBtn = $('#saveItemBtn'),
            modalHead = $('#modalHead'),
            modalContent = $('#modalContent'),
            eMsg = $('#eMsg'),
            modalHeader = '', postType = '';

        /* Change the content of the modal */
        function itemModalContent(id, header) {
            var contents = '', itemIDArr = [], itemID, selectionID;
            selectionID = id;
            postType = header;
            $(eMsg).html('');

            if (selectionID.includes('burger')) {
                modalHeader = `${header} Item (Burger)`;
                itemIDArr = selectionID.split('_');
                itemID = itemIDArr[1];

                if (header == 'Edit') {
                    var name = $('#' + id + '_input1').html(),
                        price = $('#' + id + '_input2').html();
                }

                contents = `<div class='col-md-8 py-2'>
                                <input type='hidden' id='param0_id' value='${itemID}' />
                                <input type='hidden' id='param0' value='burger' />
                                <label for='param1'>Item Name</label>
                                <input type='text' class='form-control' name='param1' id='param1' value='${name ?? ''}' ${name == undefined ? '' : 'readonly'}/>
                                <label for='param2' class='pt-2'>Price</label>
                                <input type='number' class='form-control' name='param2' id='param2' value='${price ?? ''}'/>
                            </div>`;
            }
            else if (selectionID.includes('beverage')) {
                modalHeader = `${header} Item (Drinks)`;
                itemIDArr = selectionID.split('_');
                itemID = itemIDArr[1];

                if (header == 'Edit') {
                    var name = $('#' + id + '_input1').html(),
                        size = $('#' + id + '_input2').html(),
                        price = $('#' + id + '_input3').html();
                }
                /* dynamic content of the modal */
                contents = `<div class='col-md-8 py-2'>
                                <input type='hidden' id='param0_id' value='${itemID}' />
                                <input type='hidden' id='param0' value='beverage' />
                                <label for='param1'>Item Name</label>
                                <input type='text' class='form-control' name='param1' id='param1' value='${name ?? ''}' ${name == undefined ? '' : 'readonly'}/>
                                <label for='param2' class='pt-2'>Size</label>
                                <select id='param2' name='param2' class='form-select' ${name == undefined ? '' : 'disabled'}>
                                    <option value='1' ${size ?? 'selected'}>Medium</option>
                                    <option value='2' ${size == 'Large' ? 'selected' : ''}>Large</option>
                                </select>
                                <label for='param3' class='pt-2'>Price</label>
                                <input type='number' class='form-control' name='param3' id='param3' value='${price ?? ''}'/>
                            </div>`;
            }
            else if (selectionID.includes('combo')) {
                modalHeader = `${header} Item (Combo Meal)`;
                itemIDArr = selectionID.split('_');
                itemID = itemIDArr[1];

                if (header == 'Edit') {
                    var name = $('#' + id + '_input1').html(),
                        price = $('#' + id + '_input2').html();
                }

                contents = `<div class='col-md-8 py-2'>
                                <input type='hidden' id='param0_id' value='${itemID}' />
                                <input type='hidden' id='param0' value='combo' />
                                <label for='param1'>Item Name</label>
                                <input type='text' class='form-control' name='param1' id='param1' value='${name ?? ''}' ${name == undefined ? '' : 'readonly'}/>
                                <label for='param2' class='pt-2'>Price</label>
                                <input type='number' class='form-control' name='param2' id='param2' value='${price ?? ''}'/>
                            </div>`;
            }
            else if (selectionID.includes('tax')) {
                modalHeader = `${header} Item (Tax)`;
                itemIDArr = selectionID.split('_');
                itemID = itemIDArr[1];

                if (header == 'Edit') {
                    var name = $('#' + id + '_input1').html(),
                        price = $('#' + id + '_input2').html();
                }

                contents = `<div class='col-md-8 py-2'>
                                <input type='hidden' id='param0_id' value='${itemID}' />
                                <input type='hidden' id='param0' value='tax' />
                                <label for='param1'>Tax Name</label>
                                <input type='text' class='form-control' name='param1' id='param1' value='${name ?? ''}' ${name == undefined ? '' : 'readonly'}/>
                                <label for='param2' class='pt-2'>Tax (%)</label>
                                <input type='number' class='form-control' name='param2' id='param2' value='${price ?? ''}'/>
                            </div>`;
            }
            else {
                modalHeader = `${header} Item (Discount Coupon)`;
                itemIDArr = selectionID.split('_');
                itemID = itemIDArr[1];

                if (header == 'Edit') {
                    var name = $('#' + id + '_input1').html(),
                        price = $('#' + id + '_input2').html();
                }

                contents = `<div class='col-md-8 py-2'>
                                <input type='hidden' id='param0_id' value='${itemID}' />
                                <input type='hidden' id='param0' value='coupon' />
                                <label for='param1'>Coupon Code</label>
                                <input type='text' class='form-control' name='param1' id='param1' value='${name ?? ''}' ${name == undefined ? '' : 'readonly'}/>
                                <label for='param2' class='pt-2'>Discount (%)</label>
                                <input type='number' class='form-control' name='param2' id='param2' value='${price ?? ''}'/>
                            </div>`;
            }

            $(modalHead).html(modalHeader).css('color', '#000');
            $(modalContent).html(contents);
            $(saveItemBtn).show();
        }

        /* add item button */
        $(document).on('click', '.add-item-btn', function () {
            itemModalContent(this.id, 'Add');
        });

        /* edit item button */
        $(document).on('click', '.edit-item-btn', function () {
            itemModalContent(this.id, 'Edit');
        });

        /* save edit/add */
        $(saveItemBtn).on('click', function () {
            var currentRoute = '', data, dataReady = false, label = '',
                item_ID = $('#param0_id').val(),
                param0Val = $('#param0').val(),
                param1Val = $('#param1').val(),
                param2Val = $('#param2').val(),
                param3Val = $('#param3').val() == undefined ? '0' : $('#param3').val();
            
            data = {
                _token : '{{ csrf_token() }}', 
                id : item_ID,
                param0 : param0Val,
                param1 : param1Val, 
                param2 : param2Val, 
                param3 : param3Val
            };

            /* check input */
            if (param1Val && param2Val && param3Val) {
                dataReady = true;
            }
            else {
                var fieldName = '';
                if (!param1Val) {
                    $('#param1').addClass('is-invalid');
                    fieldName += 'Name';
                }
                else {
                    $('#param1').removeClass('is-invalid').addClass('is-valid');
                }

                if (!param2Val) {
                    $('#param2').addClass('is-invalid');
                    fieldName += fieldName.length > 0 ? ', ' : '';

                    if (item_ID == 'beverage') {
                        fieldName += (item_ID == 'beverage' ? 'Drink Size' : 'Price');
                    }
                    else {
                        switch (item_ID) {
                            case 'coupon':
                                fieldName += 'Coupon Discount';
                            break;
                            case 'tax':
                                fieldName += 'Tax Percentage';
                            break;
                            default:
                                fieldName += 'Price';       
                        }
                    } 
                }
                else {
                    $('#param2').removeClass('is-invalid').addClass('is-valid');
                }

                if (item_ID == 'beverage' && !param3Val) {
                    fieldName += fieldName.length > 0 ? ', ' : '';
                    $('#param3').addClass('is-invalid');
                    fieldName += 'Price ';
                }
                else {
                    $('#param3').removeClass('is-invalid').addClass('is-valid');
                }
                $(eMsg).html(`${fieldName} field is required.`).css('color' , '#f00');
            }

            if (dataReady) {
                $.ajax({
                    url: '{{ route("order.admin.item.store") }}',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function(result, status, xhr) {
                        if (!$.isEmptyObject(result)) {
                            $(modalHead).html('Success').css('color', '#0f0');
                            $(modalContent).html('Record saved/updated');
                            /* update the dashboard */
                            if ($('body').text().indexOf(String(result.name ?? result.tax ?? result.code ?? result.beveragename.name)) > -1){
                                if (param0Val == 'beverage') {
                                    $('#' + param0Val + '_' + result.id + '_input3').html(result.price);
                                }
                                else {
                                    $('#' + param0Val + '_' + result.id + '_input2').html(result.price ?? ((result.discount ?? result.percentage) * 100));
                                }
                            }
                            else{
                                var eleID = param0Val + '_' + result.id;
                                var drinksContent = '';
                                if (param0Val == 'beverage') {
                                    drinksContent = `<div class="col-3">
                                            <span id="${eleID}_input2">${result.beveragesize.size ?? ''}</span>
                                        </div>
                                        <div class="col-2">
                                            <span id="${eleID}_input3">${result.price}</span>
                                        </div>`;
                                }
                                else {
                                    drinksContent = `<div class="col-4">
                                            <span id="${eleID}_input2">${result.price ?? ((result.discount ?? result.percentage) * 100)}</span>
                                        </div>`;
                                }

                                $('#' + param0Val + '_panel').append(`<div class="row pb-1">
                                        <div class="${param0Val == 'beverage' ? 'col-3' : 'col-5'}"> 
                                            <span id="${eleID}_input1">${result.name ?? result.tax ?? result.code ?? result.beveragename.name}</span>
                                        </div>
                                        ${ drinksContent }
                                        <div class="${param0Val == 'beverage' ? 'col-4' : 'col-3'}">
                                            <button type="button" class="btn btn-outline-success edit-item-btn" 
                                                data-bs-toggle="modal" data-bs-target="#addModal" id="${eleID}">Edit
                                            </button>
                                        </div>
                                    </div>`);
                             }   
                            $(saveItemBtn).hide();
                        }
                        else { 
                            $(modalHead).html('Failed').css('color', '#f00');
                            $(modalContent).html(JSON.stringify(result));
                        }
                        $(eMsg).html('');                
                    },
                    error: function(xhr, status, error) {
                        $(modalHead).html('Error').css('color', '#f00');
                        $(modalContent).html(JSON.stringify(xhr));
                        //alert(JSON.stringify(xhr))
                    }
                });
            }
        });
        
        /* pagination */
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault(); 
            var page, 
                url,
                link = $(this).attr('href');

            if (link.includes('page=')) {
                page = link.split('page=');
                url = 'order?page=';
            }
            else {
                page = link.split('user=');
                url = 'user?user=';
            }
            fetch_data(url, page[1]);
        });

        function fetch_data(url, page){
            var eleID;
            $.ajax({
                url: `{{ url()->full() }}/show/${url}` + page,
                type: 'GET',
                Accept: 'application/json',
                success : function(data) {
                    if (url == 'order?page=') {
                        eleID = '#admin-order';
                    }
                    else {
                        eleID = '#admin-user';
                    }
                    $(eleID).html(data);
                },
                error : function(error) {
                    alert(JSON.stringify(error))
                }
            });
        }
    });
</script>
@endsection
