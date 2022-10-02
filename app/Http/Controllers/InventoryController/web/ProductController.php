<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemBrand;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemColor;
use App\Models\InventoryItemSize;
use App\Models\InventoryItemType;
use App\Models\InventoryItemShoe;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = InventoryItemBrand::get();
        $category = InventoryItemCategory::get();
        $type = InventoryItemType::get();
        $color = InventoryItemColor::get();
        $size = InventoryItemSize::get();
    
        return view('inventory.product.add')->with(compact('brand', 'category', 'type', 'color', 'size'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if ($request->validated()) {
            $createRecord = InventoryItemShoe::updateOrCreate(
                Arr::except($request->validated(), ['price']),
                Arr::only($request->validated(), ['price'])
            );

            if ($createRecord->id > 0) { 
                return redirect()->route('product.show', ['product' => $createRecord->id]); 
            } else { 
                return redirect()->route('product.store')->withInput(); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itemDetail = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->findOrFail($id);
        return view('inventory.product.view')->with(compact('itemDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}