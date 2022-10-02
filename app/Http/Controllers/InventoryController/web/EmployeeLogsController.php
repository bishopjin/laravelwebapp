<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryEmployeeLog;

class EmployeeLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeLog = InventoryEmployeeLog::with('user')->paginate(10);
        return view('inventory.employee.index')->with(compact('employeeLog'));
    }
}
