<?php

namespace App\Http\Controllers\InventoryController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InventoryItemShoe;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function Index(Request $request)
    {
        $shoe_inventory = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->paginate(10, ['*'], 'inventory');
        return view('inventory.dashboard')->with(compact('shoe_inventory'));
    }

    protected function IndexApi(Request $request)
    {
        $shoe_inventory = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->paginate(10, ['*'], 'inventory');
        return $shoe_inventory;
    }
}
