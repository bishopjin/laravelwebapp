<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendanceRequest;
use App\Models\PayrollWorkSchedule;
use App\Http\Requests\AttendanceCorrectionRequest;
use App\Http\Controllers\Traits\PayrollAdmin;

class AttendanceCorrectionController extends Controller
{
    use PayrollAdmin;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = PayrollAttendanceRequest::with(['employee', 'attendance'])
            ->where([
                ['approver_id', '=', auth()->user()->id],
                ['status', '=', 0],
            ])->paginate(10);

        return view('payroll.admin.attendancerequest')->with(compact('attendances'));
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
     * @param  \App\Http\Requests\AttendanceCorrectionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceCorrectionRequest $request, $id)
    {
        $updtRqst = PayrollAttendanceRequest::find($id);

        $validated = $request->validate(['status' => ['required', 'numeric']]);

        if ($validated) {
            $updtRqst->update(['status' => $request->input('status')]);

            if ($updtRqst->count() > 0) {
                $attndc = PayrollAttendance::find($updtRqst->payroll_attendance_id);
                
                if ($request->input('status') == '1') {
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

                } else {
                    $attndc->update(['changeRequest' => 3]);
                }
            }

            return redirect()->back();
        }
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
