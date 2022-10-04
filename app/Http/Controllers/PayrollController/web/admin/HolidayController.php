<?php

namespace App\Http\Controllers\PayrollController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollHoliday;
use App\Http\Requests\HolidaysRequest;

class HolidayController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\HolidaysRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidaysRequest $request)
    {
        if ($request->validated()) {
            $created = PayrollHoliday::create($request->validated());

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
        $holiday = PayrollHoliday::find($id);

        if ($holiday->count() > 0) {
            return view('payroll.admin.holiday')->with(compact('holiday'));

        } else {
            return redirect()->back()->withErrors(['message' => 'Holiday name does not exist.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HolidaysRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HolidaysRequest $request, $id)
    {
        if ($request->validated()) {
            $holiday = PayrollHoliday::findOrFail($id);

            $created = $holiday->update([
                'date' => $request->input('month').'-'.$request->input('day'),
                'is_legal' => $request->input('islegal') ?? 0,
                'is_local' => $request->input('islocal') ?? 0,
                'rate' => intval($request->input('rate')) / 100 ?? 0
            ]);

            $message = $created ? 'Record saved' : 'Failed to save record.';

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
