<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;

class NewProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newProduct = InventoryItemShoe::where('created_at', 'like', date('Y-m-d').'%')
            ->latest()
            ->paginate(10);
        
        return view('inventory.product.newproduct')->with(compact('newProduct'));
    }
}
