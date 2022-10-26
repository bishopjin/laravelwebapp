<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PayrollSalaryGrade;
use App\Models\PayrollEmployee;
use App\Models\PayrollHoliday;
use App\Models\PayrollDeduction;
use App\Models\PayrollAddition;
use App\Models\PayrollCutOff;
use App\Models\PayrollWorkSchedule;

class AdminPayrollDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cutoffperiod = [];

        $workSchedule = PayrollWorkSchedule::get();
        $cutOff = PayrollCutOff::get();
        $holidays = PayrollHoliday::paginate(10, ['*'], 'holiday');
        $addition = PayrollAddition::paginate(10, ['*'], 'sladd');
        $deduction = PayrollDeduction::paginate(10, ['*'], 'slded');
        $salary_grade = PayrollSalaryGrade::paginate(10, ['*'], 'salary');
        $unregisterdusers = User::doesntHave('payrollemployee')->paginate(10, ['*'], 'unregistereduser');
        $users = PayrollEmployee::with(['user', 'salarygrade', 'workschedule'])->paginate(10, ['*'], 'user');

        if ($cutOff->count() > 0) {
            $co1 = 0;
            $perid = 1;
            $curYear = date('Y');
            $curMonth = date('m');
            $monthName = date('F', mktime(0, 0, 0, $curMonth));

            foreach ($cutOff as $period) {
                $cutoffArr = explode('to', $period->cut_off);
                $paydate = $monthName.' '.(intval(trim($cutoffArr[1])) + 6);
                $nextMo = date('F', mktime(0, 0, 0, $curMonth + 1));

                if ($period->id == 1) {
                    $dateR = $monthName.' '.$cutoffArr[0].'to '.$monthName.' '.trim($cutoffArr[1]);
                    $co1 = intval(trim($cutoffArr[0]));
                
                } else {
                    $daysOfTheCurMo = cal_days_in_month(CAL_GREGORIAN, $curMonth, $curYear);

                    if ((intval(trim($cutoffArr[0]) + 14) > $daysOfTheCurMo)) {
                        $cutofStart = trim(explode('to', $period->cut_off)[0]);
                        $dateR = $monthName.' '.$cutofStart.' to '.$nextMo.' '.trim($cutoffArr[1]);
                    
                    } else {
                        $dateR = $monthName.' '.$cutoffArr[0].'to '.$monthName.' '.trim($cutoffArr[1]);
                    }

                    $perid = $period->id;
                    $paydate = $nextMo.' '.((intval(trim($cutoffArr[1])) >= 30 ? $co1 : intval(trim($cutoffArr[1]))) + 6);
                }

                array_push($cutoffperiod, array('id' => $perid, 'cut_off' => $period->cut_off, 'daterange' => $dateR, 'paydate' => $paydate));
            }
        }
        
        return view('payroll.admin.index')->with(compact('unregisterdusers', 'holidays', 'users', 'salary_grade', 'addition', 'deduction', 'cutoffperiod', 'workSchedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
