<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemSize;

class ItemSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemSizes = InventoryItemSize::latest('id')->paginate(10)->onEachSide(1);

        return view('inventory.product.size')->with(compact('itemSizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemDetails = collect([
            'header' => 'Add item size',
            'itemLabel' => 'Size',
            'itemName' => NULL,
            'url' => 'size.store',
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
            'size' => ['required', 'numeric', 'unique:inventory_item_sizes']
        ]);
        
        if ($validated) {
            InventoryItemSize::create($validated);

            return redirect()->route('size.index');
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
        $size = InventoryItemSize::findOrFail($id);

        $itemDetails = collect([
            'header' => 'Edit item size',
            'itemLabel' => 'Size',
            'itemName' => $size->size,
            'url' => 'size.update',
            'returnRoute' => 'size.index',
            'isNewItem' => false,
            'itemID' => $size->id
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
            'size' => ['required', 'numeric', 'unique:inventory_item_sizes']
        ]);
        
        if ($validated) {
            InventoryItemSize::findOrFail($id)->update($validated);

            return redirect()->route('size.index');
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
