@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center fw-bold">
        <div class="col-md-6">
           <div class="row justify-content-center">

                <x-inventory-card 
                    linkAdd="{{ route('product.index') }}"
                    :count="$itemCount"
                    role="Admin|NoneAdmin"
                    cardLabel="Item" />

                <x-inventory-card 
                    linkView="{{ route('size.index') }}"
                    linkAdd="{{ route('size.create') }}"
                    :count="$sizeCount"
                    role="Admin"
                    cardLabel="Size" />

                <x-inventory-card 
                    linkView="{{ route('color.index') }}"
                    linkAdd="{{ route('color.create') }}"
                    :count="$colorCount"
                    role="Admin"
                    cardLabel="Color" />

                <x-inventory-card 
                    linkView="{{ route('brand.index') }}"
                    linkAdd="{{ route('brand.create') }}"
                    :count="$brandCount"
                    role="Admin"
                    cardLabel="Brand" />
           </div> 
        </div>
        <div class="col-md-6">
           <div class="row justify-content-center">
                <x-inventory-card 
                    linkView="{{ route('type.index') }}"
                    linkAdd="{{ route('type.create') }}"
                    :count="$typeCount"
                    role="Admin"
                    cardLabel="Type" />

                <x-inventory-card 
                    linkView="{{ route('category.index') }}"
                    linkAdd="{{ route('category.create') }}"
                    :count="$categoryCount"
                    role="Admin"
                    cardLabel="Category" />

                <x-inventory-card 
                    linkAdd="{{ route('order.index') }}"
                    :count="$orderCount"
                    role="Admin|NoneAdmin"
                    cardLabel="Order" />
               
                <x-inventory-card 
                    linkView="{{ route('userspermission.index') }}"
                    :count="$userCount"
                    role="Admin"
                    cardLabel="User" />
           </div> 
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col">
            <dashboard-datatable-component></dashboard-datatable-component>
        </div>
    </div>
    <x-footer/>
</div>
@endsection