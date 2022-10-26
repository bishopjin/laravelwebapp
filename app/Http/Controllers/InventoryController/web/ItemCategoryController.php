<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemCategory;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemCategories = InventoryItemCategory::latest('id')->paginate(10)->onEachSide(1);

        return view('inventory.product.category')->with(compact('itemCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemDetails = collect([
            'header' => 'Add item category',
            'itemLabel' => 'Category',
            'itemName' => NULL,
            'url' => 'category.store',
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
            'category' => ['required', 'unique:inventory_item_categories']
        ]);
        
        if ($validated) {
            InventoryItemCategory::create($validated);

            return redirect()->route('category.index');
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
        $category = InventoryItemCategory::findOrFail($id);

        $itemDetails = collect([
            'header' => 'Edit item category',
            'itemLabel' => 'Category',
            'itemName' => $category->category,
            'url' => 'category.update',
            'returnRoute' => 'category.index',
            'isNewItem' => false,
            'itemID' => $category->id
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
            'category' => ['required', 'unique:inventory_item_categories']
        ]);
        
        if ($validated) {
            InventoryItemCategory::findOrFail($id)->update($validated);

            return redirect()->route('category.index');
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
