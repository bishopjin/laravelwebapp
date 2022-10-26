@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <add-new-stock-component card-name="Receive Item"
                :is-add-item="false"
            >
            </add-new-stock-component>
        </div>
    </div>
    <x-footer></x-footer>
</div>

@endsection