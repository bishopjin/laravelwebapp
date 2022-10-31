<?php

namespace App\Http\Controllers\InventoryController\api;

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

class ApiDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shoeInventory = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])
            ->latest()->paginate(10, ['*'], 'inventory');

        $sizeCount = InventoryItemSize::count();

        $colorCount = InventoryItemColor::count();

        $brandCount = InventoryItemBrand::count();

        $typeCount = InventoryItemType::count();

        $categoryCount = InventoryItemCategory::count();

        if (auth()->user()->id == 1) {
            $orderCount = InventoryItemOrder::count();
        } else {
            $orderCount = auth()->user()->inventoryorder()->count();
        }

        $userCount = User::role(['Admin', 'NoneAdmin'])->count();

        $itemCount = InventoryItemShoe::count();

        return response()->json(array(
            $shoeInventory, 
            $sizeCount,
            $colorCount,
            $brandCount,
            $typeCount,
            $categoryCount,
            $orderCount,
            $userCount,
            $itemCount
        ));
    }
}
