@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">
                    {{ __('New Item') }}
                </div>

                <div class="card-body">
                    <form method="POST" 
                        action="{{ route('product.store') }}" 
                        class="px-md-5">
                        @csrf

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Brand') }}
                            </label>
                            <select class="form-select 
                                @error('inventory_item_brand_id') is-invalid @enderror" 
                                name="inventory_item_brand_id">

                                @forelse ($brand as $b)
                                    <option value="{{ $b->id }}" 
                                        @if (old('inventory_item_brand_id') == $b->id) selected @endif>
                                        {{ $b->brand }}
                                    </option>
                                @empty
                                    <option></option>
                                @endforelse

                            </select>

                            @error('inventory_item_brand_id')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Size') }}
                            </label>
                            <select class="form-select 
                                @error('inventory_item_size_id') is-invalid @enderror" 
                                name="inventory_item_size_id">

                                @forelse ($size as $s)
                                    <option value="{{ $s->id }}" 
                                        @if (old('inventory_item_size_id') == $s->id) selected @endif>
                                        {{ $s->size }}
                                    </option>
                                @empty
                                    <option></option>
                                @endforelse

                            </select>

                            @error('inventory_item_size_id')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Color') }}
                            </label>
                            <select class="form-select 
                                @error('inventory_item_color_id') is-invalid @enderror" 
                                name="inventory_item_color_id">

                                @forelse ($color as $col)
                                    <option value="{{ $col->id }}" 
                                        @if (old('inventory_item_color_id') == $col->id) selected @endif>
                                        {{ $col->color }}
                                    </option>
                                @empty
                                    <option></option>
                                @endforelse

                            </select>

                            @error('inventory_item_color_id')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Type') }}
                            </label>
                            <select class="form-select 
                                @error('inventory_item_type_id') is-invalid @enderror" 
                                name="inventory_item_type_id">

                                @forelse ($type as $t)
                                    <option value="{{ $t->id }}" 
                                        @if(old('inventory_item_type_id') == $t->id)  selected @endif>
                                        {{ $t->type }}
                                    </option>
                                @empty
                                    <option></option>
                                @endforelse

                            </select>

                            @error('inventory_item_type_id')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Category') }}
                            </label>
                            <select class="form-select 
                                @error('inventory_item_category_id') is-invalid @enderror" 
                                name="inventory_item_category_id" >

                                @forelse ($category as $cat)
                                    <option value="{{ $cat->id }}" 
                                        @if(old('inventory_item_category_id') == $cat->id) selected @endif>
                                        {{ $cat->category }}
                                    </option>
                                @empty
                                    <option></option>
                                @endforelse

                            </select>

                            @error('inventory_item_category_id')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group pb-3">
                            <label>
                                {{ __('Price') }}
                            </label>
                            <input type="number" 
                                step=".001" 
                                class="form-control @error('price') is-invalid @enderror" 
                                value="{{ old('price') }}" 
                                name="price">

                            @error('price')
                                <span class="invalid-feedback" 
                                    role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-center py-2">
                            <input type="submit" 
                                class="btn btn-outline-primary px-5" 
                                value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection