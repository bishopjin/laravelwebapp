<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollSalaryGrade;
use App\Http\Requests\SalaryGradeRequest;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.admin.salarygrade');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SalaryGradeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryGradeRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollSalaryGrade::create($request->validated());

            $message = $created ? 'Record saved' : 'Failed to save record.';

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
        $salarygrade = PayrollSalaryGrade::findOrFail($id);

        if ($salarygrade->count() > 0) {
            return view('payroll.admin.salarygrade')->with(compact('salarygrade'));

        } else {
            return redirect()->back()->withErrors(['message' => 'Salary Grade does not exist.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SalaryGradeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryGradeRequest $request, $id)
    {
        if ($request->validated()) {
            $salaryGrade = PayrollSalaryGrade::findOrFail($id);
            $updated = $salaryGrade->update([
                'night_diff_applied' => $request->input('night_diff_applied') ?? 0,
                'overtime_applied' => $request->input('overtime_applied') ?? 0,
                'cola_applied' => $request->input('cola_applied') ?? 0,
                'ecola_applied' => $request->input('ecola_applied') ?? 0,
                'meal_allowance_applied' => $request->input('meal_allowance_applied') ?? 0
            ]);

            $message = $updated ? 'Record updated' : 'Failed.';

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
