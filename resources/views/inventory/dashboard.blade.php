@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center fw-bold">
        <x-inventory-card 
            linkAdd="{{ route('product.create') }}"
            linkView="{{ route('product.index') }}"
            :count="$itemCount"
            role="Admin|NoneAdmin"
            cardLabel="Item" 
        />

        <x-inventory-card 
            linkAdd="{{ route('order.index') }}"
            :count="$orderCount"
            role="Admin|NoneAdmin"
            cardLabel="Order" 
        />

        <x-inventory-card 
            linkView="{{ route('size.index') }}"
            linkAdd="{{ route('size.create') }}"
            :count="$sizeCount"
            role="Admin"
            cardLabel="Size" 
        />

        <x-inventory-card 
            linkView="{{ route('color.index') }}"
            linkAdd="{{ route('color.create') }}"
            :count="$colorCount"
            role="Admin"
            cardLabel="Color" 
        />
    </div>
    
    <div class="row justify-content-center fw-bold">
        <x-inventory-card 
            linkView="{{ route('brand.index') }}"
            linkAdd="{{ route('brand.create') }}"
            :count="$brandCount"
            role="Admin"
            cardLabel="Brand" 
        />

        <x-inventory-card 
            linkView="{{ route('type.index') }}"
            linkAdd="{{ route('type.create') }}"
            :count="$typeCount"
            role="Admin"
            cardLabel="Type" 
        />

        <x-inventory-card 
            linkView="{{ route('category.index') }}"
            linkAdd="{{ route('category.create') }}"
            :count="$categoryCount"
            role="Admin"
            cardLabel="Category" 
        />

        <x-inventory-card 
            linkView="{{ route('userspermission.index') }}"
            :count="$userCount"
            role="Admin"
            cardLabel="User" 
        />
    </div>

    <div class="row justify-content-center">
        <x-inventory-card-list 
            cardHeader="Out of stock"
            labelName="Product Code"
            labelQty="In Stock"
            url="outofstock.index"
            :dataIndex="['id', 'in_stock']"
            :cardHeight="300"
            :cardData="$outOfStock"
        />

        <x-inventory-card-list 
            cardHeader="Most ordered"
            labelName="Product Code"
            labelQty="Ordered Quantity"
            url="mostordered.index"
            :dataIndex="['inventory_item_shoe_id', 'qty']"
            :cardHeight="300"
            :cardData="$mostOrdered"
        />

        <x-inventory-card-list 
            cardHeader="New Product"
            labelName="Product Code"
            labelQty="In Stock"
            url="newproduct.index"
            :dataIndex="['id', 'in_stock']"
            :cardHeight="300"
            :cardData="$newProduct"
        />
    </div>

    <x-footer/>
</div>
@endsection