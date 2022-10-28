<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemOrder;

class MostOrderedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mostOrdered = InventoryItemOrder::with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
            ->where('qty', '>', 0)
            ->groupBy('inventory_item_shoe_id')
            ->selectRaw('*, sum(qty) as sumqty')
            ->latest('sumqty')
            ->paginate(10);
  
        return view('inventory.product.mostOrdered')->with(compact('mostOrdered'));
    }
}
