<?php

namespace App\Http\Controllers\PayrollController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\ChangePasswordRequest;

class PayrollChangePasswordController extends Controller
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
        $userid = auth()->user()->id;
        return view('payroll.changepassword')->with(compact('userid'));
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
     * @param  App\Http\Requests\ChangePasswordRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChangePasswordRequest $request, $id)
    {
        if ($request->validated()) 
        {
            if ($request->user()->id != 1)
            {
                $find_record = User::find($id);
                
                if (Hash::check($request->input('password'), $find_record->password)) 
                {
                    return redirect()->back()->with(['message' => 'New password must not be the same as old password.', 'font' => 'text-danger'])->withInput();
                }
                elseif (Hash::check($request->input('oldpass'), $find_record->password)) 
                {
                    $update_pass = User::find($id)->update(['password' => Hash::make($request->input('password'))]);
                }
                else
                {
                    return redirect()->back()->with(['message' => 'Old password incorrect', 'font' => 'text-danger'])->withInput();
                }
                $message = 'Password changed';
            }
            else
            {
                $message = 'Password change is not allowed for admin account.';
            }
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
