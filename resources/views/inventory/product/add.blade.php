@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('New Item') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('inventory.product.create') }}" class="px-md-5">
                        @csrf
                        <div class="form-group pb-3">
                            <label>Brand</label>
                            <select class="form-select @error('inventory_item_brand_id') is-invalid @enderror" name="inventory_item_brand_id" required>
                                @foreach ($brand as $b)
                                    @if (old('inventory_item_brand_id') == $b->id)
                                        <option value="{{ $b->id }}" selected>{{ $b->brand }}</option>
                                    @else
                                        <option value="{{ $b->id }}">{{ $b->brand }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('inventory_item_brand_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pb-3">
                            <label>Size</label>
                            <select class="form-select @error('inventory_item_size_id') is-invalid @enderror" name="inventory_item_size_id" required>
                                @foreach ($size as $s)
                                    @if (old('inventory_item_size_id') == $s->id)
                                        <option value="{{ $s->id }}" selected>{{ $s->size }}</option>
                                    @else
                                        <option value="{{ $s->id }}">{{ $s->size }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('inventory_item_size_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pb-3">
                            <label>Color</label>
                            <select class="form-select @error('inventory_item_color_id') is-invalid @enderror" name="inventory_item_color_id" required>
                                @foreach ($color as $col)
                                    @if (old('inventory_item_color_id') == $col->id)
                                        <option value="{{ $col->id }}" selected>{{ $col->color }}</option>
                                    @else
                                        <option value="{{ $col->id }}">{{ $col->color }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('inventory_item_color_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pb-3">
                            <label>Type</label>
                            <select class="form-select @error('inventory_item_type_id') is-invalid @enderror" name="inventory_item_type_id" required>
                                @foreach ($type as $t)
                                    @if(old('inventory_item_type_id') == $t->id) 
                                        <option value="{{ $t->id }}" selected>{{ $t->type }}</option>
                                    @else
                                        <option value="{{ $t->id }}">{{ $t->type }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('inventory_item_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pb-3">
                            <label>Category</label>
                            <select class="form-select @error('inventory_item_category_id') is-invalid @enderror" name="inventory_item_category_id" required>
                                @foreach ($category as $cat)
                                    @if(old('inventory_item_category_id') == $cat->id)
                                        <option value="{{ $cat->id }}" selected>{{ $cat->category }}</option>
                                    @else
                                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('inventory_item_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pb-3">
                            <label>Price</label>
                            <input type="number" step=".001" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" required>
                            
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-center py-2">
                            <input type="submit" class="btn btn-outline-primary px-5" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection