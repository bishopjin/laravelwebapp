<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendance;

class PayrollEmployeeController extends Controller
{
    protected function Index()
    {
    	$attendance = PayrollAttendance::paginate(10, ['*'], 'attendance');

    	return view('payroll.employee.index')->with(compact('attendance'));
    }
}
