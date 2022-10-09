@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">
                    {{ __('Item Added') }}
                </div>

                <div class="card-body px-md-5">
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Item ID') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->id ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Brand') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->brand->brand ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Size') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->size->size ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Color') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->color->color ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Type') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->type->type ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Category') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->category->category ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group pb-3">
                        <label>
                            {{ __('Price') }}
                        </label>
                        <input type="text" 
                            class="form-control" 
                            value="{{ $itemDetail->price ?? '' }}" 
                            readonly>
                    </div>
                    <div class="form-group d-flex justify-content-center py-2">
                        <a href="{{ route('product.index') }}" 
                            class="btn btn-outline-primary">
                            {{ __('Add New Item') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection