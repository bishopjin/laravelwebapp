<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollAddition;
use App\Http\Requests\SalaryAdditionRequest;

class SalaryAdditionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.admin.addition');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SalaryAdditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryAdditionRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollAddition::create($request->validated());

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
        $addition = PayrollAddition::findOrFail($id);

        if ($addition->count() > 0) {
            return view('payroll.admin.addition')->with(compact('addition'));

        } else {
            return redirect()->back()->withErrors(['message' => 'Name does not exist.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SalaryAdditionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryAdditionRequest $request, $id)
    {
        if ($request->validated()) {
            $updated = PayrollAddition::findOrFail($id)->update($request->safe()->only(['amount', 'rate']));

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
