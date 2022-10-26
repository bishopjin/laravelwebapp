<?php

namespace App\Http\Controllers\InventoryController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;
use App\Models\InventoryItemReceive;
use App\Http\Requests\ProductOrderAndDeliverRequest;

class ApiProductDeliverController extends Controller
{
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
                $currentStock = InventoryItemShoe::select('in_stock')->findOrFail($request->inventory_item_shoe_id);

                $updatedStock = InventoryItemShoe::findOrFail($request->inventory_item_shoe_id)
                    ->update(['in_stock' => (intval($request->qty) + intval($currentStock->in_stock))]);

                $return = array('reqStatus' => 1, 'reqResponse' => response()->json($updatedStock));
            }
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
        return InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->findOrFail($id);
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
