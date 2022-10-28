@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :deepRelation="true"
                rootRelationKey="shoe"
                :data="$mostOrdered" 
                title="Most ordered item" 
                :header="['Product ID', 'Brand', 'Size', 'Color', 'Type', 'Category', 'Ordered Quantity']" 
                :tData="['inventory_item_shoe_id', 'brand', 'size', 'color', 'type', 'category', 'sumqty']">
            </x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection