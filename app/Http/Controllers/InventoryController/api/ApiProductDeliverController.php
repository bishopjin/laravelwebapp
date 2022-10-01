<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryItemShoe;
use App\Models\InventoryItemReceive;

class ApiProductDeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if (!$validator->fails()) 
        {
            $saveDeliver = InventoryItemReceive::create([
                'inventory_item_shoe_id' => $request->input('shoe_id'),
                'qty' => $request->input('qty'),
                'user_id' => $request->user()->id,
            ]);

            if($saveDeliver->id > 0)
            {
                $stock = 0;

                $currentStock = InventoryItemShoe::select('in_stock')
                    ->findOrFail($request->input('shoe_id'));

                $stock = $currentStock->in_stock;

                $newStock = intval($request->input('qty')) + intval($stock);

                $updatedStock = InventoryItemShoe::findOrFail($request->input('shoe_id'))
                    ->update(['in_stock' => $newStock]);

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
