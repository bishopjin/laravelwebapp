<?php

namespace App\Http\Controllers\PayrollController\web\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendance;
use App\Models\PayrollEmployee; 
use App\Models\PayrollCutOff;
use App\Models\PayrollHoliday;
use App\Models\PayrollWorkSchedule;

class DTRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance = PayrollAttendance::where([
            ['user_id', '=', auth()->user()->id],
            ['created_at', 'LIKE', date('Y-m-d').'%']
        ])->get();
        
        $dtr = PayrollEmployee::with('workschedule')->where('user_id', auth()->user()->id)->get();
        
        return view('payroll.employee.dtr')->with(compact('dtr', 'attendance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cutoff = PayrollCutOff::all();
        $holiday = PayrollHoliday::where('date', date('n').'-'.date('j'))->get();
        $employee = PayrollEmployee::find($request->user()->id);
        $workSched = PayrollWorkSchedule::find($employee->payroll_work_schedule_id);
        $wsArr = explode('-', $workSched->schedule);
        $day = intval(date('d'));
        $id = 0;

        foreach ($cutoff as $date) {
            $dtrange = explode('to', $date->cut_off);
            $id = $date->id;
            /* get the id of current cutoff period */
            if ($day >= intval($dtrange[0]) AND intval($day <= $dtrange[1])) {
                $id = $date->id;
                break;
            }
        }

        $validated = $request->validate([
            'timein' => ['required']
        ]);

        if ($validated) {
            $tardiness = Carbon::parse(trim($wsArr[0]))->diffInMinutes(Carbon::parse($validated->timein), false);

            $created = PayrollAttendance::create([
                'user_id' => $request->user()->id,
                'payroll_cut_off_id' => $id,
                'payroll_holiday_id' => $holiday[0]->id ?? 0,
                'payroll_work_schedule_id' => $employee->payroll_work_schedule_id,
                'time_in' => $validated->timein,
                'tardiness' => $tardiness,
            ]);

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $validated = $request->validate([
            'strDt' => ['required'],
            'endDt' => ['required']
        ]);

        if ($validated) {
            $startDT = new Carbon($validated->strDt.'00:00:00');
            $endDT = new Carbon($validated->endDt.'23:59:00');

            $attendance = PayrollAttendance::with(['workschedule', 'holiday'])
                ->where('user_id', $request->user()->id)
                ->whereBetween('created_at', [$startDT, $endDT])
                ->orderBy('created_at', 'desc')
                ->take(31)
                ->get();

            return view('payroll.employee.attendance')->with(compact('attendance'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $attendance = PayrollAttendance::where([
            ['user_id', '=', auth()->user()->id],
            ['created_at', 'LIKE', date('Y-m-d').'%']
        ])->first();

        if ($request->input('lunchout')) {
            $attendance->update(['time_out_break' => $request->input('lunchout')]);

        } else if ($request->input('lunchin')) {
            $break_in = (Carbon::parse($attendance->time_out_break)->diffInMinutes(Carbon::parse($request->input('lunchin')), true));

            $attendance->update([
                'time_in_break' => $request->input('lunchin'),
                'tardiness' => (($break_in - 60) > 0 ? ($break_in - 60) : 0) + $attendance->tardiness,
            ]);

        } else {
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

            if (($hstart + $hend) > ($schedMH / 2)) {
                $manhr -= 60;
            }
            
            /* overtime */
            $overtime = $manhr - $schedMH;
            /* check if night diff 10 to 12 mn */
            if (strtotime($request->input('timeout')) >= strtotime('22:00:00') AND 
                strtotime($request->input('timeout')) <= strtotime('23:59:00')) {

                $nghDff1 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('22:00:00')));
            }

            if (strtotime($request->input('timeout')) >= strtotime('24:00:00') AND 
                strtotime($request->input('timeout')) <= strtotime('06:00:00')) {

                $nghDff2 = (Carbon::parse($request->input('timeout'))->diffInMinutes(Carbon::parse('24:00:00')));;
            }
            
            $attendance->update([
                'time_out' => $request->input('timeout'),
                'manhour' =>  $manhr > 0 ? $manhr : 0,
                'overtime' => $overtime > 0 ? $overtime : 0,
                'night_diff' => ($nghDff1 + $nghDff2),
            ]);
        }

        return redirect()->back();
    }
}
