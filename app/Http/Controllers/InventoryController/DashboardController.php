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
    public function __construct()
    {
        $this->middleware('auth');
    } 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function Index(Request $request)
    {
        $shoe_inventory = InventoryItemShoe::join('inventory_item_brands', 'inventory_item_shoes.inventory_item_brand_id', '=', 'inventory_item_brands.id')
            ->join('inventory_item_sizes', 'inventory_item_shoes.inventory_item_size_id', '=', 'inventory_item_sizes.id')
            ->join('inventory_item_colors', 'inventory_item_shoes.inventory_item_color_id', '=', 'inventory_item_colors.id')
            ->join('inventory_item_types', 'inventory_item_shoes.inventory_item_type_id', '=', 'inventory_item_types.id')
            ->join('inventory_item_categories', 'inventory_item_shoes.inventory_item_category_id', '=', 'inventory_item_categories.id')
            ->select('inventory_item_shoes.itemID', 'inventory_item_brands.brand', 'inventory_item_sizes.size', 
                'inventory_item_colors.color', 'inventory_item_types.type', 'inventory_item_categories.category',
                'inventory_item_shoes.price', 'inventory_item_shoes.in_stock')->get();

        return view('inventory.dashboard')->with(compact('shoe_inventory'));
    }
}
