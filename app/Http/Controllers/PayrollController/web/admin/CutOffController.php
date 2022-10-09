<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollCutOff;
use App\Http\Requests\PayrollCutOffRequest;

class CutOffController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cutOff = PayrollCutOff::all();

        return view('payroll.admin.cutoff')->with(compact('cutOff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PayrollCutOffRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PayrollCutOffRequest $request, $id)
    {
        if ($request->validated()) {
            $updco1 = PayrollCutOff::find(1)->update(['cut_off' => ($request->sfco.' to '.$request->efco)]);

            $updco2 = PayrollCutOff::find(2)->update(['cut_off' => ($request->ssco.' to '.$request->esco)]);

            $message = ($updco1 AND $updco2) ? 'Cut-off date is updated.' : 'Failed to update.';

            return redirect()->back()->with(['message' => $message]);
        }
    }
}
