<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryItemOrder;
use App\Models\InventoryItemShoe;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (InventoryItemOrder::exists()) {
            $orders = InventoryItemOrder::with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
                ->paginate(10);
            return view('inventory.product.order')->with(compact('orders'));
        }
        else
        {
            return view('inventory.product.order');
        }
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
                'shoe_id' => 'required|numeric',
                'qty' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('inventory.order.store')->withErrors($validator)->withInput();
        }
        else {
            if (InventoryItemOrder::exists()){
                $orderNumber = InventoryItemOrder::select('order_number')->max('order_number') + 1;
            }
            else { 
                $orderNumber = 1000000000; 
            }

            $itemshoe = InventoryItemShoe::find($request->input('shoe_id'));
            
            if (intval($itemshoe->in_stock) >= intval($request->input('qty'))) {
                $orderCreated = InventoryItemOrder::create([
                    'order_number' => $orderNumber,
                    'inventory_item_shoe_id' => $request->input('shoe_id'),
                    'qty' => $request->input('qty'),
                    'order_by_id' => $request->user()->id,
                ]);

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
