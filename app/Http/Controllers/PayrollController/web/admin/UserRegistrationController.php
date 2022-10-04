<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollSalaryGrade;
use App\Models\PayrollWorkSchedule;
use App\Models\PayrollEmployee;
use App\Models\User;
use App\Http\Requests\PayrollUserRegisterRequest;

class UserRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary_grade = PayrollSalaryGrade::all();

        $workSchedule = PayrollWorkSchedule::all();

        return view('payroll.admin.register')->with(compact('salary_grade', 'workSchedule'));
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
     * @param  \App\Http\Requests\PayrollUserRegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayrollUserRegisterRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollEmployee::create($request->validated());

            $message = $created->id > 0 ? 'User registered' : 'Registration failed';

            return redirect()->back()->with('message', $message);
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
        $isNew = false;

        $details = PayrollEmployee::with(['user'])->findOrFail($id);
        
        if (!$details) {
            $isNew = true;

            $details = User::find($id);
        }

        if ($details->count() > 0) {
            $salary_grade = PayrollSalaryGrade::all();

            $workSchedule = PayrollWorkSchedule::all();

            return view('payroll.admin.register')->with(compact('isNew', 'details', 'salary_grade', 'workSchedule'));
        } else {
            return redirect()->back()->withErrors(['error' => 'User does not exist.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PayrollUserRegisterRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PayrollUserRegisterRequest $request, $id)
    {
        if ($request->validated()) {
            $employee = PayrollEmployee::findOrFail($id);
            $updated = $employee->update([
                'payroll_salary_grade_id' => $request->input('payroll_salary_grade_id'),
                'payroll_work_schedule_id' => $request->input('payroll_work_schedule_id'),
                'salary_rate' => $request->input('salary_rate'),
            ]);

            $message = $updated ? 'Information Updated' : 'Failed';

            return redirect()->back()->with('message', $message);
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
