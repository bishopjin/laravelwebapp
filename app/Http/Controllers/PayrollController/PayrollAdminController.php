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
	protected function Index(Request $request)
	{
        
	}

	protected function UserIndex()
	{
		$salary_grade = PayrollSalaryGrade::all();

        $workSchedule = PayrollWorkSchedule::all();

		return view('payroll.admin.register')->with(compact('salary_grade', 'workSchedule'));
	}
	/* */
    protected function UserEdit(Request $request, $id)
    {
        $isNew = false;
        $details = PayrollEmployee::with(['user'])->find($id);
        
        if (!$details) 
        {
            $isNew = true;
            $details = User::find($id);
        }

    	if ($details->count() > 0) 
    	{
    		$salary_grade = PayrollSalaryGrade::all();
            $workSchedule = PayrollWorkSchedule::all();

    		return view('payroll.admin.register')->with(compact('isNew', 'details', 'salary_grade', 'workSchedule'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['error' => 'User does not exist.']);
    	}
    }

    protected function UserCreate(Request $request)
    {
        $message = 'Registration failed';

		if (intval($request->input('id')) == 0) 
		{
			$validator = Validator::make($request->all(), [
	            'username' => ['required', 'string', 'max:255', 'unique:users'],
	            'firstname' => ['required', 'string', 'max:255'],
	            'lastname' => ['required', 'string', 'max:255'],
	            'gender' => ['required', 'string', 'max:1'],
	            'email' => ['required', 'email'],
	            'DOB' => ['date'],
	        ]);

	        if ($validator->fails()) 
	        {
	            return redirect()->route('payroll.admin.user.index')->withErrors($validator)->withInput();
	        }
	        else
	        {
	        	$user_create = User::create([
    				'username' => $request->input('username'),
    				'password' => Hash::make($request->input('username')),
    				'firstname' => $request->input('username'),
                    'middlename' => $request->input('middlename') ?? '',
                    'lastname' => $request->input('lastname'),
                    'email' => $request->input('email'),
                    'gender_id' => intval($request->input('gender')),
                    'online_course_id' => 1,
                    'DOB' => $request->input('DOB'),
    			]);

	        	if ($user_create->id > 0) 
	        	{
	        		$created = PayrollEmployee::create([
			    		'user_id' => $user_create->id,
			    		'payroll_salary_grade_id' => $request->input('salarygrade'),
                        'payroll_work_schedule_id' => $request->input('workschedule'),
                        'salary_rate' => $request->input('salary_rate'),
			    	]);
	        	}

                if ($created->id > 0) 
                {
                    $message = 'User registered';
                }
	        }
		}
		else
		{
    		$created = PayrollEmployee::updateOrCreate([
                'user_id' => $request->input('id'),
            ],
            [
	    		'payroll_salary_grade_id' => $request->input('salarygrade'),
                'payroll_work_schedule_id' => $request->input('workschedule'),
                'salary_rate' => $request->input('salary_rate'),
	    	]);

            if ($created->id > 0 OR $created->count() > 0) 
            {
                $message = 'User registered';
            }
    	}

    	return redirect()->back()->with('message', $message);
    }

    protected function SalaryGradeCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salary_grade' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.admin.salarygrade.index')->withErrors($validator)->withInput();
        }
        else
        {
            $message = 'Failed to save record.';

                $upcreted = PayrollSalaryGrade::updateOrCreate ([
                        'salary_grade' => $request->input('salary_grade')
                    ],
                    [
                        'night_diff_applied' => $request->input('isnightdiff') ?? 0,
                        'overtime_applied' => $request->input('isovertime') ?? 0,
                        'cola_applied' => $request->input('iscola') ?? 0,
                        'ecola_applied' => $request->input('isecola') ?? 0,
                        'meal_allowance_applied' => $request->input('ismeal') ?? 0
                ]);

            if ($upcreted->id > 0) 
            {
                $message = 'Record saved';
            }
        }

    	return redirect()->back()->with(['message' => $message]);
    }

    protected function SalaryGradeEdit(Request $request, $id)
    {
    	$salarygrade = PayrollSalaryGrade::find($id);

    	if ($salarygrade->count() > 0) 
    	{
    		return view('payroll.admin.salarygrade')->with(compact('salarygrade'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['message' => 'Salary Grade does not exist.']);
    	}
    }

    protected function HolidayCreate(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('payroll.admin.holiday.index')->withErrors($validator)->withInput();
        }
        else
        {
            $message = 'Failed to save record.';

            $upcreted = PayrollHoliday::updateOrCreate([
                    'name' => $request->input('name')
                ],
                [
                    'date' => $request->input('month').'-'.$request->input('day'),
                    'is_legal' => $request->input('islegal') ?? 0,
                    'is_local' => $request->input('islocal') ?? 0,
                    'rate' => intval($request->input('rate')) / 100 ?? 0
            ]);

            if ($upcreted->id > 0) 
            {
                $message = 'Record saved';
            }
        }
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function HolidayEdit(Request $request, $id)
    {
    	$holiday = PayrollHoliday::find($id);

    	if ($holiday->count() > 0) 
    	{
    		return view('payroll.admin.holiday')->with(compact('holiday'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['message' => 'Holiday name does not exist.']);
    	}
    }

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
    private function getTardiness($schedule_in, $actual_in)
    {
        return Carbon::parse($schedule_in)->diffInMinutes(Carbon::parse($actual_in), false);
    }

    private function getSchedMnhr($workSchedID)
    {
        $workSched = PayrollWorkSchedule::find($workSchedID);
        $wsArr = explode('-', $workSched->schedule);

        return (Carbon::parse(trim($wsArr[1]))->diffInMinutes(Carbon::parse(trim($wsArr[0]))) - 60);;
    }

    private function getNightDiff($time_out)
    {
        $nghDff1 = 0;
        $nghDff2 = 0;
        /* check if night diff 10 to 12 mn */
        if (strtotime($time_out) >= strtotime('22:00:00') AND strtotime($time_out) <= strtotime('23:59:00')) 
        {
            $nghDff1 = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse('22:00:00')));
        }

        if (strtotime($time_out) >= strtotime('24:00:00') AND strtotime($time_out) <= strtotime('06:00:00')) 
        {
            $nghDff2 = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse('24:00:00')));;
        }
        
        return ($nghDff1 + $nghDff2);
    }

    private function getTotalMnhr($time_in, $lunch_out, $lunch_in, $time_out, $schedMH)
    {
        $hstart = (Carbon::parse($lunch_out)->diffInMinutes(Carbon::parse($time_in), true));
        $hend = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse($lunch_in), true));

        $manhr = ($hstart + $hend);

        if (($hstart + $hend) > ($schedMH / 2)) 
        {
            $manhr -= 60;
        }

        return $manhr;
    }
}
