@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$itemSizes" 
                title="Sizes" 
                :header="['ID', 'Size']" 
                :tData="['id', 'size']"
                :hasEditButton="true"
                editLink="size.edit"
            ></x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection