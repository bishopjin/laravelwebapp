@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$itemColors" 
                title="Color" 
                :header="['ID', 'Color']" 
                :tData="['id', 'color']"
                :hasEditButton="true"
                editLink="color.edit"
            ></x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection