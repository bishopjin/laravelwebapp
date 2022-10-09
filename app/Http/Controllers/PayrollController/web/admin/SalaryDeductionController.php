<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollDeduction;
use App\Http\Requests\SalaryDeductionRequest;

class SalaryDeductionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.admin.deduction');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SalaryDeductionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryDeductionRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollDeduction::create($request->validated());

            $message = $created->id > 0 ? 'Record saved' : 'Failed to save record.';

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
        $deduction = PayrollDeduction::findOrFail($id);

        if ($deduction->count() > 0) {
            return view('payroll.admin.deduction')->with(compact('deduction'));

        } else {
            return redirect()->back()->withErrors(['message' => 'Name does not exist.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SalaryDeductionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryDeductionRequest $request, $id)
    {
        if ($request->validated()) {
            $updated = PayrollDeduction::findOrFail($id)->update($request->safe()->only(['amount', 'rate']));

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
