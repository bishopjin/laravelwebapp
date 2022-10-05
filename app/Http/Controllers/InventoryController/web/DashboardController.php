<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoeInventory = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->latest()->paginate(10, ['*'], 'inventory');
        return view('inventory.dashboard')->with(compact('shoeInventory'));
    }
}
