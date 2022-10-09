@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder">
                    {{ __('Inventory') }}
                </div>

                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('Product ID') }}
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
                                    {{ __('In Stock') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shoeInventory as $item)
                                <tr>
                                    <td class="fw-bolder">
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->brand->brand }}
                                    </td>
                                    <td>
                                        {{ $item->size->size }}
                                    </td>
                                    <td>
                                        {{ $item->color->color }}
                                    </td>
                                    <td>
                                        {{ $item->type->type }}
                                    </td>
                                    <td>
                                        {{ $item->category->category }}
                                    </td>
                                    <td>
                                        {{ $item->price }}
                                    </td>
                                    <td>
                                        {{ $item->in_stock }}
                                    </td>
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