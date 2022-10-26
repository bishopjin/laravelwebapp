@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$itemTypes" 
                title="Type" 
                :header="['ID', 'Type']" 
                :tData="['id', 'type']"
                :hasEditButton="true"
                editLink="type.edit"
            ></x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection