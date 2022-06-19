<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendance;
use App\Models\PayrollPayslip;
use App\Models\PayrollEmployee;
use App\Models\PayrollCutOff;
use App\Models\PayrollHoliday;
use App\Models\PayrollWorkSchedule;
use App\Models\PayrollAddition;
use App\Models\PayrollDeduction;
use Carbon\Carbon;

class PayrollEmployeeController extends Controller
{
    protected function Index(Request $request)
    {
    	$attendance = PayrollAttendance::with(['workschedule', 'holiday'])
    			->where([
    				['user_id', $request->user()->id],
    				['created_at', 'LIKE', date('Y-m-d').'%'],
    			])->paginate(15, ['*'], 'attendance');
    	$request->flash();
    	return view('payroll.employee.index')->with(compact('attendance'));
    }

    protected function GetAttendance(Request $request)
    {
    	$startDT = new Carbon($request->input('strDt')).'00:00:00';
    	$endDT = new Carbon($request->input('endDt').'23:59:00');

    	$attendance = PayrollAttendance::where('user_id', $request->user()->id)
    			->whereBetween('created_at', [$startDT, $endDT])
    			->paginate(15, ['*'], 'attendance');
    	
    	if (!$attendance) 
    	{
    		$attendance = collect(new PayrollAttendance);
    	}
    	$request->flash();
    	return view('payroll.employee.index')->with(compact('attendance'));
    }

    protected function ViewPayslip(Request $request)
    {
    	if ($request->input('strDt') && $request->input('endDt'))
    	{
    		$startDT = new Carbon($request->input('strDt')).'00:00:00';
    		$endDT = new Carbon($request->input('endDt').'23:59:00');

    		$payslips = PayrollPayslip::with('payrollcutoff')->where('user_id', $request->user()->id)
    			->whereBetween('created_at', [$startDT, $endDT])
    			->paginate(15, ['*'], 'payslip');
    	}
    	else
    	{
    		$payslips = PayrollPayslip::with('payrollcutoff')->where([
    				['user_id', $request->user()->id],
    				['created_at', 'LIKE', date('Y-m-d').'%'],
    			])->paginate(15, ['*'], 'payslip');
    	}
    	/* NEED FIXING */
    	$payslipAddition = PayrollAddition::with('payslip')->get();
    	$payslipDeduction = PayrollDeduction::with('payslip')->get();

    	$request->flash();
    	return view('payroll.employee.payslip')->with(compact('payslips'));
    }

    protected function Dtr(Request $request)
    {
    	$attendance = PayrollAttendance::where([
    		['user_id', '=', $request->user()->id],
    		['created_at', 'LIKE', date('Y-m-d').'%']
    	])->get();
    	
    	$dtr = PayrollEmployee::with('workschedule')
    			->where('user_id', $request->user()->id)->get();

    	return view('payroll.employee.dtr')->with(compact('dtr', 'attendance'));
    }

    protected function DtrSave(Request $request)
    {
    	$attendance = PayrollAttendance::where([
    		['user_id', '=', $request->user()->id],
    		['created_at', 'LIKE', date('Y-m-d').'%']
    	])->first();

    	if ($attendance) 
    	{
    		$workSched = PayrollWorkSchedule::where('id', $attendance->payroll_work_schedule_id)->get();
    		$wsArr = explode('-', $workSched[0]->schedule);

    		if ($request->input('lunchout')) 
    		{
    			$attendance->update(['time_out_break' => $request->input('lunchout')]);
    		}
    		else if ($request->input('lunchin')) 
    		{
    			$attendance->update(['time_in_break' => $request->input('lunchin')]);
    		}
    		else
    		{
    			$nghDff1 = 0;
    			$nghDff2 = 0;
    			
    			/* get the manhour less 1 hour break from schedule */
    			$schedMH = (Carbon::parse(trim($wsArr[1]))->diffInMinutes(Carbon::parse(trim($wsArr[0]))) - 60);
    			/* check if night diff 10 to 12 mn */
    			if (strtotime($request->input('timeout')) >= strtotime('22:00:00') AND strtotime($request->input('timeout')) <= strtotime('23:59:00')) 
    			{
    				$nghDff1 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('22:00:00')));
    			}

    			if (strtotime($request->input('timeout')) >= strtotime('24:00:00') AND strtotime($request->input('timeout')) <= strtotime('06:00:00')) 
    			{
    				$nghDff2 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('24:00:00')));;
    			}
    			
    			$tNdif = $nghDff1 + $nghDff2;

    			$hstart = (Carbon::parse($attendance->time_out_break)->diffInMinutes(Carbon::parse($attendance->time_in)));
    			$hend = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse($attendance->time_in_break)));
    			
    			$overtime = ($hstart + $hend) - $schedMH;
    			
    			$attendance->update([
    				'time_out' => $request->input('timeout'),
    				'manhour' => ($hstart + $hend),
    				'overtime' => $overtime > 0 ? $overtime : 0,
    				'night_diff' => $tNdif,
    			]);
    		}
    	}
    	else
    	{
    		$cutoff = PayrollCutOff::get();
    		$holiday = PayrollHoliday::where('date', date('n').'-'.date('j'))->get();
    		$employee = PayrollEmployee::where('user_id', $request->user()->id)->get();
    		$workSched = PayrollWorkSchedule::where('id', $employee[0]->payroll_work_schedule_id)->get();
    		$wsArr = explode('-', $workSched[0]->schedule);
    		$day = intval(date('d'));
    		$id = 0;

    		foreach ($cutoff as $date) 
    		{
    			$dtrange = explode('to', $date->cut_off);
    			if ($day >= intval($dtrange[0]) AND intval($day <= $dtrange[1]))
    			{
    				$id = $date->id;
    				break;
    			}
    		}
    		$tardiness = (Carbon::parse($request->input('timein')))->diffInMinutes(Carbon::parse(trim($wsArr[0])));
    		$created = PayrollAttendance::create([
    			'user_id' => $request->user()->id,
    			'payroll_cut_off_id' => $id,
    			'payroll_holiday_id' => $holiday[0]->id ?? 0,
    			'payroll_work_schedule_id' => $employee[0]->payroll_work_schedule_id,
    			'time_in' => $request->input('timein'),
    			'tardiness' => $tardiness,
    		]);
    	}

    	return redirect()->back();
    }
}
