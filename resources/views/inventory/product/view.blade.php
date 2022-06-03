@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Item Added') }}</div>

                <div class="card-body px-md-5">
                    @foreach ($item_detail as $item)
                        <div class="form-group pb-3">
                            <label>Item ID</label>
                            <input type="text" class="form-control" value="{{ $item->itemID }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Brand</label>
                            <input type="text" class="form-control" value="{{ $item->brand->brand }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Size</label>
                            <input type="text" class="form-control" value="{{ $item->size->size }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Color</label>
                            <input type="text" class="form-control" value="{{ $item->color->color }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Type</label>
                            <input type="text" class="form-control" value="{{ $item->type->type }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Category</label>
                            <input type="text" class="form-control" value="{{ $item->category->category }}" readonly="">
                        </div>
                        <div class="form-group pb-3">
                            <label>Price</label>
                            <input type="text" class="form-control" value="{{ $item->price }}" readonly="">
                        </div>
                    @endforeach
                    <div class="form-group d-flex justify-content-center py-2">
                        <a href="{{ route('inventory.product.create') }}" class="btn btn-outline-primary">Add New Item</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection