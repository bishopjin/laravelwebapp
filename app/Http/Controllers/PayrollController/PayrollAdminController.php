<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\PayrollSalaryGrade;
use App\Models\PayrollEmployee;
use App\Models\PayrollHoliday;
use App\Models\PayrollDeduction;
use App\Models\PayrollAddition;
use App\Models\PayrollCutOff;
use App\Models\PayrollWorkSchedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PayrollAdminController extends Controller
{
	protected function Index(Request $request)
	{
        $cutoffperiod = [];

        $workSchedule = PayrollWorkSchedule::get();

        $cutOff = PayrollCutOff::get();

		$holidays = PayrollHoliday::paginate(10, ['*'], 'holiday');

		$addition = PayrollAddition::paginate(10, ['*'], 'sladd');

		$deduction = PayrollDeduction::paginate(10, ['*'], 'slded');

		$salary_grade = PayrollSalaryGrade::paginate(10, ['*'], 'salary');

		if (PayrollEmployee::exists()) 
		{
			$users = PayrollEmployee::with(['userprofile', 'salarygrade', 'workschedule'])->paginate(10, ['*'], 'user');
		}
        else 
        {
            $users = UsersProfile::where('user_id', $request->user()->id)->paginate(10, ['*'], 'user');
        }

        if ($cutOff->count() > 0)
        {
            $curYear = date('Y');
            $curMonth = date('m');
            $monthName = date('F', mktime(0, 0, 0, $curMonth));

            foreach ($cutOff as $period) 
            {
                $cutoffArr = explode('to', $period->cut_off);
                $paydate = $monthName.' '.(intval(trim($cutoffArr[1])) + 5);

                if ($period->id == 1)
                {
                    $dateR = $monthName.' '.$cutoffArr[0].'to '.$monthName.' '.trim($cutoffArr[1]);
                }
                else
                {
                    $daysOfTheCurMo = cal_days_in_month(CAL_GREGORIAN, $curMonth, $curYear);
                    if ((intval(trim($cutoffArr[0]) + 14) > $daysOfTheCurMo)) 
                    {
                        $cutofStart = trim(explode('to', $period->cut_off)[0]);
                        $nextMo = date('F', mktime(0, 0, 0, $curMonth + 1));
                        $dateR = $monthName.' '.$cutofStart.' to '.$nextMo.' '.trim($cutoffArr[1]);
                        $paydate = $nextMo.' '.(intval(trim($cutoffArr[1])) + 5);
                    }
                    else
                    {
                        $dateR = $monthName.' '.$cutoffArr[0].'to '.$monthName.' '.trim($cutoffArr[1]);
                    }
                }
                
                array_push($cutoffperiod, array('cut_off' => $period->cut_off, 'daterange' => $dateR, 'paydate' => $paydate));
            }
        }
			
		return view('payroll.admin.index')->with(compact('holidays', 'users', 'salary_grade', 'addition', 'deduction', 'cutoffperiod', 'workSchedule'));
	}

	protected function UserIndex()
	{
		$salary_grade = PayrollSalaryGrade::get();

        $workSchedule = PayrollWorkSchedule::get();

		return view('payroll.admin.register')->with(compact('salary_grade', 'workSchedule'));
	}
	/* */
    protected function UserEdit(Request $request, $id)
    {
        $details = PayrollEmployee::with(['userprofile'])->where('user_id', $id)->get();
       
        if ($details->count() == 0) 
        {
            $details = UsersProfile::where('user_id', $id)->get();
        }

    	if ($details->count() > 0) 
    	{
    		$salary_grade = PayrollSalaryGrade::get();
            $workSchedule = PayrollWorkSchedule::get();

    		return view('payroll.admin.register')->with(compact('details', 'salary_grade', 'workSchedule'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['error' => 'User does not exist.']);
    	}
    }

    protected function UserCreate(Request $request)
    {
    	$exist = PayrollEmployee::where('user_id',$request->input('id'))->get();
    	/* */
    	if ($exist->count() > 0) 
    	{
    		$update = PayrollEmployee::where('user_id',$request->input('id'))
    				->update([
                        'payroll_salary_grade_id' => $request->input('salarygrade'),
                        'payroll_work_schedule_id' => $request->input('workschedule'),
                    ]);

    		if ($update) 
    		{
    			$message = 'Record updated';
    		}
    		else
    		{
    			$message = 'Update failed';
    		}
    	}
    	else
    	{
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
	    				'access_level' => 1,
	    				'isactive' => 1,
	    			]);

		        	if ($user_create->id > 0) 
		        	{
		        		$profile_create = UsersProfile::create([
		        			'user_id' => $user_create->id,
		        			'firstname' => $request->input('username'),
		        			'middlename' => $request->input('middlename') ?? '',
		        			'lastname' => $request->input('lastname'),
		        			'email' => $request->input('email'),
		        			'gender_id' => intval($request->input('gender')),
		        			'online_course_id' => 1,
		        			'DOB' => $request->input('DOB'),
		        		]);
		        	}
		        	if ($profile_create) 
		        	{
		        		$created = PayrollEmployee::create([
				    		'user_id' => $user_create->id,
				    		'payroll_salary_grade_id' => $request->input('salarygrade'),
                            'payroll_work_schedule_id' => $request->input('workschedule'),
				    	]);
		        	}
		        }
    		}
    		else
    		{
	    		$created = PayrollEmployee::create([
		    		'user_id' => $request->input('id'),
		    		'payroll_salary_grade_id' => $request->input('salarygrade'),
                    'payroll_work_schedule_id' => $request->input('workschedule'),
		    	]);
	    	}

	    	if ($created->id > 0) 
	    	{
	    		$message = 'User registered';
	    	}
	    	else
	    	{
	    		$message = 'Registration failed';
	    	}
    	}
    	return redirect()->back()->with('message', $message);
    }

    protected function SalaryGradeCreate(Request $request)
    {
    	if (intval($request->input('id')) > 0) 
    	{
    		$message = 'Failed to update record.';
    		$exist = PayrollSalaryGrade::where('id', $request->input('id'))->get();

    		if ($exist->count() > 0) 
    		{
    			$update = PayrollSalaryGrade::where('id', $request->input('id'))->update([
    					'night_diff_applied' => $request->input('isnightdiff') ?? 0,
    					'overtime_applied' => $request->input('isovertime') ?? 0,
    					'cola_applied' => $request->input('iscola') ?? 0,
    					'ecola_applied' => $request->input('isecola') ?? 0,
    					'meal_allowance_applied' => $request->input('ismeal') ?? 0
    			]);

    			if ($update) 
    			{
    				$message = 'Record updated';
    			}
    		}
    	}
    	else
    	{
    		$validator = Validator::make($request->all(), [
	            'salary_grade' => ['required', 'string', 'max:255', 'unique:payroll_salary_grades'],
	        ]);

	        if ($validator->fails()) 
	        {
	            return redirect()->route('payroll.admin.salarygrade.index')->withErrors($validator)->withInput();
	        }
	        else
	        {
	        	$message = 'Failed to save record.';

	        	$created = PayrollSalaryGrade::create([
	        		'salary_grade' => $request->input('salary_grade'),
					'night_diff_applied' => $request->input('isnightdiff') ?? 0,
					'overtime_applied' => $request->input('isovertime') ?? 0,
					'cola_applied' => $request->input('iscola') ?? 0,
					'ecola_applied' => $request->input('isecola') ?? 0,
					'meal_allowance_applied' => $request->input('ismeal') ?? 0
	        	]);

	        	if ($created->id > 0) 
	        	{
	        		$message = 'Saved new record';
	        	}
	        }
    	}
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function SalaryGradeEdit(Request $request, $id)
    {
    	$salarygrade = PayrollSalaryGrade::where('id', $id)->get();

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
    	if (intval($request->input('id')) > 0) 
    	{
    		$message = 'Failed to update record.';
    		$exist = PayrollHoliday::where('id', $request->input('id'))->get();

    		if ($exist->count() > 0) 
    		{
    			$update = PayrollHoliday::where('id', $request->input('id'))->update([
    					'date' => $request->input('month').'-'.$request->input('day'),
    					'is_legal' => $request->input('islegal') ?? 0,
    					'is_local' => $request->input('islocal') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
    			]);

    			if ($update) 
    			{
    				$message = 'Record updated';
    			}
    		}
    	}
    	else
    	{
    		$validator = Validator::make($request->all(), [
	            'name' => ['required', 'string', 'max:255', 'unique:payroll_holidays'],
	        ]);

	        if ($validator->fails()) 
	        {
	            return redirect()->route('payroll.admin.holiday.index')->withErrors($validator)->withInput();
	        }
	        else
	        {
	        	$message = 'Failed to save record.';

	        	$created = PayrollHoliday::create([
	        			'name' => $request->input('name'),
    					'date' => $request->input('month').'-'.$request->input('day'),
    					'is_legal' => $request->input('islegal') ?? 0,
    					'is_local' => $request->input('islocal') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
	        	]);

	        	if ($created->id > 0) 
	        	{
	        		$message = 'Saved new record';
	        	}
	        }
    	}
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function HolidayEdit(Request $request, $id)
    {
    	$holiday = PayrollHoliday::where('id', $id)->get();

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
    	if (intval($request->input('id')) > 0) 
    	{
    		$message = 'Failed to update record.';
    		$exist = PayrollAddition::where('id', $request->input('id'))->get();

    		if ($exist->count() > 0) 
    		{
    			$update = PayrollAddition::where('id', $request->input('id'))->update([
    					'amount' => $request->input('amount') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
    			]);

    			if ($update) 
    			{
    				$message = 'Record updated';
    			}
    		}
    	}
    	else
    	{
    		$validator = Validator::make($request->all(), [
	            'name' => ['required', 'string', 'max:255', 'unique:payroll_additions'],
	        ]);

	        if ($validator->fails()) 
	        {
	            return redirect()->route('payroll.admin.addition.index')->withErrors($validator)->withInput();
	        }
	        else
	        {
	        	$message = 'Failed to save record.';

	        	$created = PayrollAddition::create([
	        			'name' => $request->input('name'),
    					'amount' => $request->input('amount') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
	        	]);

	        	if ($created->id > 0) 
	        	{
	        		$message = 'Saved new record';
	        	}
	        }
    	}
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function AdditionEdit(Request $request, $id)
    {
    	$addition = PayrollAddition::where('id', $id)->get();

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
    	if (intval($request->input('id')) > 0) 
    	{
    		$message = 'Failed to update record.';
    		$exist = PayrollDeduction::where('id', $request->input('id'))->get();

    		if ($exist->count() > 0) 
    		{
    			$update = PayrollDeduction::where('id', $request->input('id'))->update([
    					'amount' => $request->input('amount') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
    			]);

    			if ($update) 
    			{
    				$message = 'Record updated';
    			}
    		}
    	}
    	else
    	{
    		$validator = Validator::make($request->all(), [
	            'name' => ['required', 'string', 'max:255', 'unique:payroll_deductions'],
	        ]);

	        if ($validator->fails()) 
	        {
	            return redirect()->route('payroll.admin.deduction.index')->withErrors($validator)->withInput();
	        }
	        else
	        {
	        	$message = 'Failed to save record.';

	        	$created = PayrollDeduction::create([
	        			'name' => $request->input('name'),
    					'amount' => $request->input('amount') ?? 0,
    					'rate' => intval($request->input('rate')) / 100 ?? 0,
	        	]);

	        	if ($created->id > 0) 
	        	{
	        		$message = 'Saved new record';
	        	}
	        }
    	}
    	return redirect()->back()->with(['message' => $message]);
    }

    protected function DeductionEdit(Request $request, $id)
    {
    	$deduction = PayrollDeduction::where('id', $id)->get();

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
        if (intval($request->input('id')) > 0) 
        {
            $message = 'Failed to update record.';
            $exist = PayrollWorkSchedule::where('id', $request->input('id'))->get();

            if ($exist->count() > 0) 
            {
                $update = PayrollWorkSchedule::where('id', $request->input('id'))->update([
                        'schedule' => $request->input('schedule'),
                ]);

                if ($update) 
                {
                    $message = 'Record updated';
                }
            }
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'unique:payroll_work_schedules'],
            ]);

            if ($validator->fails()) 
            {
                return redirect()->route('payroll.admin.schedule.index')->withErrors($validator)->withInput();
            }
            else
            {
                $message = 'Failed to save record.';
                $schedule = $request->input('startTme').' - '.$request->input('endTme');
                $created = PayrollWorkSchedule::create([
                        'name' => $request->input('name'),
                        'code' => $request->input('code'),
                        'schedule' => $schedule,
                ]);

                if ($created->id > 0) 
                {
                    $message = 'Saved new record';
                }
            }
        }
        return redirect()->back()->with(['message' => $message]);
    }

    protected function ScheduleEdit(Request $request, $id)
    {
        $workschedule = PayrollWorkSchedule::where('id', $id)->get();

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
        $cutOff = PayrollCutOff::get();
        return view('payroll.admin.cutoff')->with(compact('cutOff'));
    }

    protected function CutoffUpdate(Request $request)
    {
        $message = 'Failed to update.';

        if (PayrollCutOff::exists()) 
        {
            $sco = $request->input('sfco').' to '.$request->input('efco');
            $eco = $request->input('ssco').' to '.$request->input('esco');

            $updco1 = PayrollCutOff::where('id', 1)->update(['cut_off' => $sco]);
            if ($updco1) {
                $updco2 = PayrollCutOff::where('id', 2)->update(['cut_off' => $eco]);
            }
            if ($updco2) {
                $message = 'Cut-off date is updated.';
            }
        }
        return redirect()->back()->with(['message' => $message]);
    }
}
