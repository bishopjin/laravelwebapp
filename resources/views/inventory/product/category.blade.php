@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <x-datatable 
                :data="$itemCategories" 
                title="Category" 
                :header="['ID', 'Category']" 
                :tData="['id', 'category']"
                :hasEditButton="true"
                editLink="category.edit"
            ></x-datatable>
        </div>
    </div>
    <x-footer/>
</div>
@endsection