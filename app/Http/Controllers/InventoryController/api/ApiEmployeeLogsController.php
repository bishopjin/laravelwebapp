<?php

namespace App\Http\Controllers\InventoryController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryEmployeeLog;

class ApiEmployeeLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InventoryEmployeeLog::with('user')->latest()->paginate(10, ['*'], 'employeeLogs');
    }
}
