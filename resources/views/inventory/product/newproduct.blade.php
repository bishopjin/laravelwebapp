@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$newProduct" 
                title="New product(s)" 
                :header="['Product ID', 'Brand', 'Size', 'Color', 'Type', 'Category', 'Price']" 
                :tData="['id', 'brand', 'size', 'color', 'type', 'category', 'price']">
            </x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection