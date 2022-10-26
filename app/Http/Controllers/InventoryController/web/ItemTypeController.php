<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemType;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemTypes = InventoryItemType::latest('id')->paginate(10)->onEachSide(1);

        return view('inventory.product.type')->with(compact('itemTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemDetails = collect([
            'header' => 'Add item type',
            'itemLabel' => 'Type',
            'itemName' => NULL,
            'url' => 'type.store',
            'isNewItem' => true,
            'itemID' => NULL
        ]);

        return view('inventory.product.item')->with(compact('itemDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'unique:inventory_item_types']
        ]);
        
        if ($validated) {
            InventoryItemType::create($validated);

            return redirect()->route('type.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = InventoryItemType::findOrFail($id);

        $itemDetails = collect([
            'header' => 'Edit item type',
            'itemLabel' => 'Type',
            'itemName' => $type->type,
            'url' => 'type.update',
            'returnRoute' => 'type.index',
            'isNewItem' => false,
            'itemID' => $type->id
        ]);

        return view('inventory.product.item')->with(compact('itemDetails'));
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
        $validated = $request->validate([
            'type' => ['required', 'unique:inventory_item_types']
        ]);
        
        if ($validated) {
            InventoryItemType::findOrFail($id)->update($validated);

            return redirect()->route('type.index');
        }
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
