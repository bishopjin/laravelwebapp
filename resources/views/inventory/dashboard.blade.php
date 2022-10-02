@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Inventory') }}</div>

                <div class="card-body table-responsive">
                    <table class="table">
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
                            @forelse ($shoeInventory as $item)
                                @php
                                    /* add trailing zero for non-decimal price */
                                    if(!str_contains($item->price, '.')) {
                                        $price =  $item->price.'.00';   
                                    }
                                    else { $price = $item->price; }
                                @endphp
                                <tr>
                                    <td class="fw-bolder">{{ $item->id }}</td>
                                    <td>{{ $item->brand->brand }}</td>
                                    <td>{{ $item->size->size }}</td>
                                    <td>{{ $item->color->color }}</td>
                                    <td>{{ $item->type->type }}</td>
                                    <td>{{ $item->category->category }}</td>
                                    <td>{{ $price }}</td>
                                    <td>{{ $item->in_stock }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        @isset($shoeInventory)
                            {{ $shoeInventory->links() }}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection