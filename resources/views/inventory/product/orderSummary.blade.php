@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
        		<v-app>
            	<order-summary-component></order-summary-component>
            </v-app>
        </div>
    </div>
    <x-footer/>
</div>
@endsection