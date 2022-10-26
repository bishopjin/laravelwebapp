<?php

namespace App\Http\Controllers\PayrollController\web\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAttendance;
use App\Models\PayrollEmployee; 
use App\Models\PayrollAttendanceRequest;
use App\Http\Requests\DTRChangeRequest;

class DTRChangeRequestController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dtrData = PayrollAttendance::with('attendancerequest')->find($id);
        
        $users = PayrollEmployee::with('user')->where('user_id', '!=', auth()->user()->id)->get();

        return view('payroll.employee.requestchange')->with(compact('dtrData', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DTRChangeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DTRChangeRequest $request, $id)
    {
        if ($request->validated()) {
            
            $requestCreated = $request->user()->requestorattendancerequest()->create($request->validated());
    
            if ($requestCreated->id > 0) {
                PayrollAttendance::find($id)->update(['changeRequest' => 1]);
            }

            return redirect()->route('dtrchange.index');
        }
    }
}
