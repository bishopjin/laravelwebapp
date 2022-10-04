<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PayrollSalaryGrade;
use App\Models\PayrollEmployee;
use App\Models\PayrollHoliday;
use App\Models\PayrollDeduction;
use App\Models\PayrollAddition;
use App\Models\PayrollCutOff;
use App\Models\PayrollWorkSchedule;
use App\Models\PayrollAttendance;
use App\Models\PayrollAttendanceRequest;
use App\Models\PayrollPayslip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PayrollAdminController extends Controller
{
    protected function AdditionCreate(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.admin.addition.index')->withErrors($validator)->withInput();
        }
        else
        {
            $message = 'Failed to save record.';

            $upcreted = PayrollAddition::updateOrCreate([
                    'name' => $request->input('name')
                ],
                [
                    'amount' => $request->input('amount') ?? 0,
                    'rate' => intval($request->input('rate')) / 100 ?? 0,
            ]);

            if ($upcreted->id > 0) 
            {
                $message = 'Record saved';
            }
        }
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function AdditionEdit(Request $request, $id)
    {
    	$addition = PayrollAddition::find($id);

    	if ($addition->count() > 0) 
    	{
    		return view('payroll.admin.addition')->with(compact('addition'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['message' => 'Holiday name does not exist.']);
    	}
    }

    protected function DeductionCreate(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.admin.deduction.index')->withErrors($validator)->withInput();
        }
        else
        {
            $message = 'Failed to save record.';

            $upcreted = PayrollDeduction::updateOrCreate([
                    'name' => $request->input('name')
                ],
                [
                    'amount' => $request->input('amount') ?? 0,
                    'rate' => intval($request->input('rate')) / 100 ?? 0
            ]);

            if ($upcreted->id > 0) 
            {
                $message = 'Record saved';
            }
        }
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function DeductionEdit(Request $request, $id)
    {
    	$deduction = PayrollDeduction::find($id);

    	if ($deduction->count() > 0) 
    	{
    		return view('payroll.admin.deduction')->with(compact('deduction'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['message' => 'Holiday name does not exist.']);
    	}
    }

    protected function ScheduleCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.admin.schedule.index')->withErrors($validator)->withInput();
        }
        else
        {
            $message = 'Failed to save record.';
            $schedule = $request->input('startTme').' - '.$request->input('endTme');
            $upcreted = PayrollWorkSchedule::updateOrCreate([
                    'name' => $request->input('name')
                ],
                [
                    'code' => $request->input('code'),
                    'schedule' => $schedule,
            ]);

            if ($upcreted->id > 0) 
            {
                $message = 'Record saved';
            }
        }

        return redirect()->back()->with(['message' => $message]);
    }

    protected function ScheduleEdit(Request $request, $id)
    {
        $workschedule = PayrollWorkSchedule::find($id);

        if ($workschedule->count() > 0) 
        {
            return view('payroll.admin.workschedule')->with(compact('workschedule'));
        }
        else
        {
            return redirect()->back()->withErrors(['message' => 'Work Schedule does not exist.']);
        }
    }

    protected function CutoffEdit(Request $request)
    {
        $cutOff = PayrollCutOff::all();
        return view('payroll.admin.cutoff')->with(compact('cutOff'));
    }

    protected function CutoffUpdate(Request $request)
    {
        $message = 'Failed to update.';

        if (PayrollCutOff::exists()) 
        {
            $sco = $request->input('sfco').' to '.$request->input('efco');
            $eco = $request->input('ssco').' to '.$request->input('esco');

            $updco1 = PayrollCutOff::find(1)->update(['cut_off' => $sco]);
            if ($updco1) {
                $updco2 = PayrollCutOff::find(2)->update(['cut_off' => $eco]);
            }
            if ($updco2) {
                $message = 'Cut-off date is updated.';
            }
        }
        return redirect()->back()->with(['message' => $message]);
    }

    protected function AttendanceRequestIndex(Request $request)
    {
        $attendance = PayrollAttendanceRequest::with(['employee', 'attendance'])
            ->where([
                ['approver_id', $request->user()->id],
                ['status', 0],
            ])->paginate(10);
        return view('payroll.admin.attendancerequest')->with(compact('attendance'));
    }

    protected function RequestAction(Request $request)
    {
        $updtRqst = PayrollAttendanceRequest::find($request->input('id'));
        $updtRqst->update(['status' => $request->input('status')]);

        if ($updtRqst->id > 0) 
        {
            $attndc = PayrollAttendance::find($updtRqst->payroll_attendance_id);
            
            if ($request->input('status') == '1') 
            {
                $workSched = PayrollWorkSchedule::find($attndc->payroll_work_schedule_id);
                $wsArr = explode('-', $workSched->schedule);
                
                /* get the manhour less 1 hour break from schedule */
                $schedMH = $this->getSchedMnhr($attndc->payroll_work_schedule_id);
                /* total manhour */
                $manhr = $this->getTotalMnhr($updtRqst->time_in, $attndc->time_out_break, $attndc->time_in_break, $updtRqst->time_out, $schedMH);
                /* overtime */
                $overtime = $manhr - $schedMH;
                $attndc->update([
                    'time_in' => $updtRqst->time_in,
                    'time_out_break' => $updtRqst->time_out_break,
                    'time_in_break' => $updtRqst->time_in_break,
                    'time_out' => $updtRqst->time_out,
                    'manhour' =>  $manhr > 0 ? ($manhr > $schedMH ? $schedMH : $manhr) : 0,
                    'overtime' => $overtime > 0 ? $overtime : 0,
                    'night_diff' => $this->getNightDiff($updtRqst->time_out),
                    'tardiness' => $this->getTardiness(trim($wsArr[0]), $updtRqst->time_in),
                    'changeRequest' => 2,
                ]);
            }
            else
            {
                $attndc->update(['changeRequest' => 3]);
            }
        }

        return redirect()->back();
    }

    protected function ComputeSalary(Request $request)
    {
        PayrollEmployee::with('salarygrade')->chunk(10, function ($employees) use ($request) {
            foreach ($employees as $employee) {
                $attendances = PayrollAttendance::with('holiday')->where([
                    ['user_id', '=', $employee->user_id],
                    ['payroll_cut_off_id', '=', $request->input('cutoffId')],
                    ['payroll_payslip_id', '=', 0],
                ])->chunk(15, function ($attendances) use ($request, $employee) {
                    $tmnh = 0; $tot = 0; $tndf = 0; $ttrd = 0; $bscpay = 0;
                    $hrRte = 0; $totlPy = 0;
                    $noDys = $request->input('cutoffId') == 1 ? 15 : (Carbon::now()->month(date('m'))->daysInMonth) % 2 + 15;
                    
                    foreach ($attendances as $attendance) {
                        $tmnh += $attendance->manhour;
                        $tot += $attendance->overtime;
                        $tndf += $attendance->night_diff; 
                        $ttrd += $attendance->tardiness;
                    }
                    
                    if ($employee->payroll_salary_grade_id == 1) 
                    {
                        $hrRte = $employee->salary_rate / 8;
                        $bscpay = ($tmnh / 60) * $hrRte;
                    }
                    else
                    {
                        $hrRte = ($employee->salary_rate / 30) / 8;
                        $bscpay = $employee->salary_rate / 2;
                    }

                    $totlPy += ($employee->salarygrade->night_diff_applied ? 0 : 0); 
                    
                    /*if ($employee->salarygrade->overtime_applied) 
                    {
                        
                    }
                    if ($employee->salarygrade->cola_applied) 
                    {
                        
                    }*/
                    
                    $tot_pay = ($tot / 60) * $hrRte;
                    $tndf_pay = ($tndf / 60) * $hrRte; 
                    $less_ttrd = ($ttrd / 60)  * $hrRte;

                    /*$crtPyslp = PayrollPayslip::create([
                    'user_id' => $employee->user_id,
                    'payroll_cut_off_id' => $request->input('id'),
                    'total_manhour' => $tmnh,
                    'payroll_salary_addition_id' => 0,
                    'total_addition' => 0,
                    'payroll_salary_deduction_id' => 0,
                    'total_deduction' => 0,
                    ]);*/
                });
            }
        });
        
        return redirect()->back(); 
    }

    /* Services */
    
}
