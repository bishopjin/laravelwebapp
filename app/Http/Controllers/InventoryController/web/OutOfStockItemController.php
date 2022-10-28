<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;

class OutOfStockItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outOfStock = InventoryItemShoe::where('in_stock', 0)->latest('id')->paginate(10);

        return view('inventory.product.outOfStock')->with(compact('outOfStock'));
    }
}
