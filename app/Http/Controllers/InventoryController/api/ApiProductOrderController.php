<?php

namespace App\Http\Controllers\InventoryController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemOrder;
use App\Models\InventoryItemShoe;
use App\Http\Requests\ProductOrderAndDeliverRequest;

class ApiProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->id == 1) {
            return InventoryItemOrder::with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
                ->latest()
                ->paginate(10, ['*'], 'order')
                ->onEachSide(1);
        } else {
            return auth()->user()->inventoryorder()
                ->with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
                ->latest()
                ->paginate(10, ['*'], 'order')
                ->onEachSide(1);
        }
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
            $itemshoe = InventoryItemShoe::findOrFail($request->inventory_item_shoe_id);
            
            if (intval($itemshoe->in_stock) >= intval($request->qty)) {
                $orderCreated = $request->user()->inventoryorder()->create($request->validated());

                if($orderCreated->id > 0){
                    $newstock = intval($itemshoe->in_stock) - intval($request->qty);
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
