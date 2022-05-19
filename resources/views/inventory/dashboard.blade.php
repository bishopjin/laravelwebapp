@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Inventory') }}</div>

                <div class="card-body table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>In Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shoe_inventory as $item)
                                @php
                                    /* add trailing zero for non-decimal price */
                                    if(!str_contains($item->price, '.')) {
                                        $price =  $item->price.'.00';   
                                    }
                                    else { $price = $item->price; }
                                @endphp
                                <tr>
                                    <td class="fw-bolder">{{ $item->itemID }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td>{{ $item->color }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $price }}</td>
                                    <td>{{ $item->in_stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#datatable').DataTable();
    });
</script>
@endsection