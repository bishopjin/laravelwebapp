<?php

namespace App\Http\Controllers\PayrollController\web\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollPayslip;
use App\Models\PayrollAddition;
use App\Models\PayrollDeduction;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($request->input('strDt') && $request->input('endDt')) {
            $startDT = new Carbon($request->input('strDt')).'00:00:00';
            $endDT = new Carbon($request->input('endDt').'23:59:00');

            $payslips = PayrollPayslip::with('payrollcutoff')->where('user_id', $request->user()->id)
                ->whereBetween('created_at', [$startDT, $endDT])->paginate(15, ['*'], 'payslip');

        } else {
            $payslips = PayrollPayslip::with('payrollcutoff')->where([
                    ['user_id', $request->user()->id],
                    ['created_at', 'LIKE', date('Y-m-d').'%'],
                ])->paginate(15, ['*'], 'payslip');
        }

        /* NEED FIXING */
        $payslipAddition = PayrollAddition::with('payslip')->all();
        $payslipDeduction = PayrollDeduction::with('payslip')->all();

        $request->flash();
        
        return view('payroll.employee.payslip')->with(compact('payslips'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
