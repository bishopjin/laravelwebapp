<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PayrollDashboardController extends Controller
{
    protected function Index(Request $request)
    {
    	if(session('user_access') == '1') 
    	{
    		return redirect()->route('payroll.admin.index');
    	}
    	elseif(session('user_access') == '2') 
    	{
    		return redirect()->route('payroll.employee.index');
    	}
    }

    protected function ChangePassIndex()
    {
        return view('payroll.changepassword');
    }

    protected function ChangePassSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpass' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) 
        {
            if(session('user_access') == '1') 
            {
                return redirect()->route('payroll.admin.password.index')->withErrors($validator)->withInput();
            }
            else
            {
                return redirect()->route('payroll.employee.password.index')->withErrors($validator)->withInput();
            }
        }
        else
        {
            $find_record = User::where('id', $request->user()->id)->first();
            
            if (Hash::check($request->input('password'), $find_record->password)) 
            {
                return redirect()->back()->with(['message' => 'New password must not be the same as old password.', 'font' => 'text-danger'])->withInput();
            }
            elseif (Hash::check($request->input('oldpass'), $find_record->password)) 
            {
                $update_pass = User::where('id', $request->user()->id)->update(['password' => Hash::make($request->input('password'))]);
            }
            else
            {
                return redirect()->back()->with(['message' => 'Old password incorrect', 'font' => 'text-danger'])->withInput();
            }
            return redirect()->back()->with(['message' => 'Password changed']);
        }
    }
}
