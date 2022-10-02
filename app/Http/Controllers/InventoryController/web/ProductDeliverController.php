<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;
use App\Models\InventoryItemReceive;
use App\Http\Requests\ProductOrderAndDeliverRequest;

class ProductDeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.product.receive');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductOrderAndDeliverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductOrderAndDeliverRequest $request)
    {
        if ($request->validated()) {
            $saveDeliver = $request->user()->inventoryreceive()->create($request->validated());

            if($saveDeliver->id > 0) {
                $currentStock = InventoryItemShoe::findOrFail($request->input('inventory_item_shoe_id'));

                $updatedStock = InventoryItemShoe::findOrFail($request->input('inventory_item_shoe_id'))
                    ->update(['in_stock' => (intval($request->input('qty')) + intval($currentStock->in_stock))]);

                return response()->json($updatedStock);
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
        return InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->findOrFail($id);
    }
}
