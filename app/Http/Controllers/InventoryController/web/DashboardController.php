<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;
use App\Models\InventoryItemSize;
use App\Models\InventoryItemBrand;
use App\Models\InventoryItemColor;
use App\Models\InventoryItemType;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemOrder;
use App\Models\User;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizeCount = InventoryItemSize::count();

        $colorCount = InventoryItemColor::count();

        $brandCount = InventoryItemBrand::count();

        $typeCount = InventoryItemType::count();

        $categoryCount = InventoryItemCategory::count();

        $orderCount = InventoryItemOrder::count();

        $userCount = User::role(['Admin', 'NoneAdmin'])->count();

        $itemCount = InventoryItemShoe::count();

        $outOfStock = InventoryItemShoe::where('in_stock', 0)->select(['id', 'in_stock'])->latest('id')->get();

        $mostOrdered = InventoryItemOrder::selectRaw('sum(qty) as qty, inventory_item_shoe_id as inventory_item_shoe_id')
            ->groupBy('inventory_item_shoe_id')
            ->latest('qty')
            ->take(10)
            ->get();

        $newProduct = InventoryItemShoe::where('created_at', 'like', date('Y-m-d').'%')
            ->select(['id', 'in_stock'])
            ->latest()
            ->get();

        return view('inventory.dashboard')
            ->with(compact(
                'sizeCount', 
                'colorCount',
                'brandCount',
                'typeCount',
                'categoryCount',
                'orderCount',
                'userCount',
                'itemCount',
                'outOfStock',
                'mostOrdered',
                'newProduct'
            ));
    }
}
