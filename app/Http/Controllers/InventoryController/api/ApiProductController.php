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

class ApiProductController extends Controller
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
    
        return response()->json(array('brand' => $brand, 'category' => $category, 'type' => $type, 'color' => $color, 'size' => $size));
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
        
        if (!$validator->fails()) 
        {
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
            $return = array('reqStatus' => 1, 'reqResponse' => $createRecord->id);
        }
        else
        {
            $return = array('reqStatus' => 0, 'reqResponse' => response()->json($validator->errors(), 500));
        }
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->find($id);
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
