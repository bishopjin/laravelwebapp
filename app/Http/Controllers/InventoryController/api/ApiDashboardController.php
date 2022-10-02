<?php

namespace App\Http\Controllers\InventoryController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemShoe;

class ApiDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->paginate(10, ['*'], 'inventory');
    }
}
