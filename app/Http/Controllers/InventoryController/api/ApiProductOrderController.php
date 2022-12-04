<?php

namespace App\Http\Controllers\InventoryController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemOrder;
use App\Models\InventoryItemShoe;
use App\Http\Requests\ProductOrderAndDeliverRequest;
use App\Events\OrderCreated;

class ApiProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!cache()->has('ordersCount')) {
            cache()->remember('ordersCount', $seconds = 86400, function () {
                return auth()->user()->inventoryorder()->count();
            });
        } else {
            if (cache('ordersCount') < auth()->user()->inventoryorder()->count()) {
                cache()->tags(['pagination', 'orders'])->flush();

                cache()->remember('ordersCount', $seconds = 86400, function () {
                    return auth()->user()->inventoryorder()->count();
                });
            }
        }
        
        cache()->tags(['pagination', 'orders'])->remember(url()->full(), $seconds = 86400, function () {
            $orderlist = auth()->user()->inventoryorder()
                ->with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
                ->latest()
                ->paginate(10)
                ->onEachSide(1);
                
            return $orderlist;
        });

        return cache()->tags(['pagination', 'orders'])->get(url()->full());
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
                    /* Added comment */
                    broadcast(new OrderCreated($orderCreated->id, 'Admin'))->toOthers();

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
