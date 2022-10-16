<?php

namespace App\Http\Controllers\PayrollController\web\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendance;

class EmployeePayrollDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance = PayrollAttendance::with(['workschedule', 'holiday'])
                ->where([
                    ['user_id', auth()->user()->id],
                    ['created_at', 'LIKE', date('Y-m-d').'%'],
                ])
                ->orderBy('created_at', 'desc')->get();
        
        return view('payroll.employee.index')->with(compact('attendance'));
    }
}
