<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemOrder;
use App\Models\InventoryItemShoe;
use App\Http\Requests\ProductOrderAndDeliverRequest;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = InventoryItemOrder::with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
            ->latest()->paginate(10);
            
        return view('inventory.product.order')->with(compact('orders'));
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
            $itemshoe = InventoryItemShoe::findOrFail($request->input('inventory_item_shoe_id'));
            
            if (intval($itemshoe->in_stock) >= intval($request->input('qty'))) {
                $orderCreated = $request->user()->inventoryorder()->create($request->validated());

                if($orderCreated->id > 0){
                    $newstock = intval($itemshoe->in_stock) - intval($request->input('qty'));
                    $updateStock = $itemshoe->update(['in_stock' => $newstock]); 
                }
            }
            else {
                $updateStock = 0;
            }

            return response()->json($updateStock);
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
