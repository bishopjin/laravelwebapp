@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$itemBrands" 
                title="Brand" 
                :header="['ID', 'Brand']" 
                :tData="['id', 'brand']"
                :hasEditButton="true"
                editLink="brand.edit"
            ></x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection