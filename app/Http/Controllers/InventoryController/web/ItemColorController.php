<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemColor;

class ItemColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemColors = InventoryItemColor::latest('id')->paginate(10)->onEachSide(1);

        return view('inventory.product.color')->with(compact('itemColors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemDetails = collect([
            'header' => 'Add item color',
            'itemLabel' => 'Color',
            'itemName' => NULL,
            'url' => 'color.store',
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
            'color' => ['required', 'unique:inventory_item_colors']
        ]);
        
        if ($validated) {
            InventoryItemColor::create($validated);

            return redirect()->route('color.index');
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
        $color = InventoryItemColor::findOrFail($id);

        $itemDetails = collect([
            'header' => 'Edit item color',
            'itemLabel' => 'Color',
            'itemName' => $color->color,
            'url' => 'color.update',
            'returnRoute' => 'color.index',
            'isNewItem' => false,
            'itemID' => $color->id
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
            'color' => ['required', 'unique:inventory_item_colors']
        ]);
        
        if ($validated) {
            InventoryItemColor::findOrFail($id)->update($validated);

            return redirect()->route('color.index');
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
