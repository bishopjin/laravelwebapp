<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryItemBrand;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemColor;
use App\Models\InventoryItemSize;
use App\Models\InventoryItemType;
use App\Models\InventoryItemShoe;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inventory_item_brand_id' => 'required|numeric',
            'inventory_item_size_id' => 'required|numeric',
            'inventory_item_color_id' => 'required|numeric',
            'inventory_item_type_id' => 'required|numeric',
            'inventory_item_category_id' => 'required|numeric',
            'price'=> 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('inventory.product.store')->withErrors($validator)->withInput();
        }
        else {
            /* create new record */
            $createRecord = InventoryItemShoe::updateOrCreate(
                [
                    'inventory_item_brand_id' => $request->input('inventory_item_brand_id'),
                    'inventory_item_size_id' => $request->input('inventory_item_size_id'),
                    'inventory_item_color_id' => $request->input('inventory_item_color_id'),
                    'inventory_item_type_id' => $request->input('inventory_item_type_id'),
                    'inventory_item_category_id' => $request->input('inventory_item_category_id'),
                ],
                ['price' => $request->input('price')]
            );

            if ($createRecord->id > 0) { 
                return redirect()->route('inventory.product.show', ['id' => $createRecord->id]); 
            }
            else { 
                return redirect()->route('inventory.product.store')->withInput(); 
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
        $itemDetail = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->find($id);
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
