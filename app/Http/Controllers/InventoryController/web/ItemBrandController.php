<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemBrand;

class ItemBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemBrands = InventoryItemBrand::latest('id')->paginate(10)->onEachSide(1);

        return view('inventory.product.brand')->with(compact('itemBrands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemDetails = collect([
            'header' => 'Add item brand',
            'itemLabel' => 'Brand',
            'itemName' => NULL,
            'url' => 'brand.store',
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
            'brand' => ['required', 'unique:inventory_item_brands']
        ]);
        
        if ($validated) {
            InventoryItemBrand::create($validated);

            return redirect()->route('brand.index');
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
        $brand = InventoryItemBrand::findOrFail($id);

        $itemDetails = collect([
            'header' => 'Edit item brand',
            'itemLabel' => 'Brand',
            'itemName' => $brand->brand,
            'url' => 'brand.update',
            'returnRoute' => 'brand.index',
            'isNewItem' => false,
            'itemID' => $brand->id
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
            'brand' => ['required', 'unique:inventory_item_brands']
        ]);
        
        if ($validated) {
            InventoryItemBrand::findOrFail($id)->update($validated);

            return redirect()->route('brand.index');
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
