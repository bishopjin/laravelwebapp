@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <dashboard-datatable-component></dashboard-datatable-component>
        </div>
    </div>
    <x-footer/>
</div>
@endsection