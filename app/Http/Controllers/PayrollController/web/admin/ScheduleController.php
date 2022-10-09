<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollScheduleRequest;
use App\Models\PayrollWorkSchedule;

class ScheduleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.admin.workschedule');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PayrollScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayrollScheduleRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollWorkSchedule::create(
                array_merge(
                    $request->safe()->only(['name', 'code']),
                    ['schedule' => ($request->startTme.' - '.$request->endTme)]
                )
            );

            $message = true ? 'Record saved' : 'Failed to save record.';

            return redirect()->back()->with(['message' => $message]);
        }
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
        $workschedule = PayrollWorkSchedule::find($id);

        if ($workschedule->count() > 0) {
            return view('payroll.admin.workschedule')->with(compact('workschedule'));

        } else {
            return redirect()->back()->withErrors(['message' => 'Work Schedule does not exist.']);
        }
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
        $validated = $request->validate([
            'startTme' => ['required'],
            'endTme' => ['required']
        ]);

        if ($validated) {
            $updated = PayrollWorkSchedule::find($id)
                ->update(['schedule' => ($request->startTme.' - '.$request->endTme)]);

            $message = $updated ? 'Record updated' : 'Failed';

            return redirect()->back()->with(['message' => $message]);
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
