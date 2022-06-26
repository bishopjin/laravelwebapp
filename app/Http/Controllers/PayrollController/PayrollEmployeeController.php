<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PayrollAttendance;
use App\Models\PayrollPayslip;
use App\Models\PayrollEmployee;
use App\Models\PayrollCutOff;
use App\Models\PayrollHoliday;
use App\Models\PayrollWorkSchedule;
use App\Models\PayrollAddition;
use App\Models\PayrollDeduction;
use App\Models\PayrollAttendanceRequest;
use Carbon\Carbon;

class PayrollEmployeeController extends Controller
{
    protected function Index(Request $request)
    {
    	$attendance = PayrollAttendance::with(['workschedule', 'holiday'])
    			->where([
    				['user_id', $request->user()->id],
    				['created_at', 'LIKE', date('Y-m-d').'%'],
    			])->orderBy('created_at', 'desc')->paginate(15, ['*'], 'attendance');
    	$request->flash();
    	return view('payroll.employee.index')->with(compact('attendance'));
    }

    protected function GetAttendance(Request $request)
    {
    	$startDT = new Carbon($request->input('strDt')).'00:00:00';
    	$endDT = new Carbon($request->input('endDt').'23:59:00');

    	$attendance = PayrollAttendance::where('user_id', $request->user()->id)
    			->whereBetween('created_at', [$startDT, $endDT])
    			->orderBy('created_at', 'desc')
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
    			->whereBetween('created_at', [$startDT, $endDT])->paginate(15, ['*'], 'payslip');
    	}
    	else
    	{
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

    protected function Dtr(Request $request)
    {
    	$attendance = PayrollAttendance::where([
    		['user_id', '=', $request->user()->id],
    		['created_at', 'LIKE', date('Y-m-d').'%']
    	])->get();
    	
    	$dtr = PayrollEmployee::with('workschedule')->where('user_id', $request->user()->id)->get();

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
    		if ($request->input('lunchout')) 
    		{
    			$attendance->update(['time_out_break' => $request->input('lunchout')]);
    		}
    		else if ($request->input('lunchin')) 
    		{
                $break_in = (Carbon::parse($attendance->time_out_break)->diffInMinutes(Carbon::parse($request->input('lunchin')), true));
                $attendance->update([
                    'time_in_break' => $request->input('lunchin'),
                    'tardiness' => (($break_in - 60) > 0 ? ($break_in - 60) : 0) + $attendance->tardiness,
                ]);
    		}
    		else
    		{
                $nghDff1 = 0;
                $nghDff2 = 0;
                $workSched = PayrollWorkSchedule::find($attendance->payroll_work_schedule_id);
                $wsArr = explode('-', $workSched->schedule);
    			/* get the manhour less 1 hour break from schedule */
                $schedMH = (Carbon::parse(trim($wsArr[1]))->diffInMinutes(Carbon::parse(trim($wsArr[0]))) - 60);
    			/* total manhour */
                $hstart = (Carbon::parse($attendance->time_out_break)->diffInMinutes(Carbon::parse($attendance->time_in), true));
                $hend = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse($attendance->time_in_break), true));

                $manhr = ($hstart + $hend);

                if (($hstart + $hend) > ($schedMH / 2)) 
                {
                    $manhr -= 60;
                }
    			
                /* overtime */
                $overtime = $manhr - $schedMH;
                /* check if night diff 10 to 12 mn */
                if (strtotime($request->input('timeout')) >= strtotime('22:00:00') AND strtotime($request->input('timeout')) <= strtotime('23:59:00')) 
                {
                    $nghDff1 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('22:00:00')));
                }

                if (strtotime($request->input('timeout')) >= strtotime('24:00:00') AND strtotime($request->input('timeout')) <= strtotime('06:00:00')) 
                {
                    $nghDff2 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('24:00:00')));;
                }
                
    			$attendance->update([
    				'time_out' => $request->input('timeout'),
    				'manhour' =>  $manhr > 0 ? $manhr : 0,
    				'overtime' => $overtime > 0 ? $overtime : 0,
    				'night_diff' => ($nghDff1 + $nghDff2),
    			]);
    		}
    	}
    	else
    	{
    		$cutoff = PayrollCutOff::all();
    		$holiday = PayrollHoliday::where('date', date('n').'-'.date('j'))->get();
    		$employee = PayrollEmployee::find($request->user()->id);
    		$workSched = PayrollWorkSchedule::find($employee->payroll_work_schedule_id);
    		$wsArr = explode('-', $workSched->schedule);
    		$day = intval(date('d'));
    		$id = 0;

    		foreach ($cutoff as $date) 
    		{
    			$dtrange = explode('to', $date->cut_off);
                $id = $date->id;
    			/* get the id of current cutoff period */
    			if ($day >= intval($dtrange[0]) AND intval($day <= $dtrange[1]))
    			{
    				$id = $date->id;
    				break;
    			}
    		}
    		$tardiness = Carbon::parse(trim($wsArr[0]))->diffInMinutes(Carbon::parse($request->input('timein')), false);

    		$created = PayrollAttendance::create([
    			'user_id' => $request->user()->id,
    			'payroll_cut_off_id' => $id,
    			'payroll_holiday_id' => $holiday[0]->id ?? 0,
    			'payroll_work_schedule_id' => $employee->payroll_work_schedule_id,
    			'time_in' => $request->input('timein'),
    			'tardiness' => $tardiness,
    		]);
    	}

    	return redirect()->back();
    }

    protected function DTRChangeRequest(Request $request, $id)
    {
        $dtrData = PayrollAttendance::with('attendancerequest')->find($id);
        $users = PayrollEmployee::with('userprofile')->where('user_id', '!=', $request->user()->id)->get();

        return view('payroll.employee.requestchange')->with(compact('dtrData', 'users'));
    }

    protected function DTRRequestCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => ['required', 'string'],
            'time_in' => ['required'],
            'time_out_break' => ['required'],
            'time_in_break' => ['required'],
            'time_out' => ['required'],
            'approver' => ['required'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.employee.dtr.show', ['id' => $request->input('id')])->withErrors($validator)->withInput();
        }
        else
        {
            $requestCreated = PayrollAttendanceRequest::updateOrCreate([
                'payroll_attendance_id' => $request->input('id'),
                ],[
                'employee_id' => $request->user()->id, 
                'approver_id' => $request->input('approver'),
                'time_in' => $request->input('time_in'),
                'time_out_break' => $request->input('time_out_break'),
                'time_in_break' => $request->input('time_in_break'),
                'time_out' => $request->input('time_out'),
                'remarks' => $request->input('remarks'),
            ]);
    
            if ($requestCreated->id > 0) 
            {
                PayrollAttendance::find($request->input('id'))->update(['changeRequest' => 1]);
            }

            return redirect()->route('payroll.dashboard.index');
        }
    }
}
