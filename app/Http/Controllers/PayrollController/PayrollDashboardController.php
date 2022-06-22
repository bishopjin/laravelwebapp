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
    	if($request->user()->hasRole('Admin')) 
    	{
    		return redirect()->route('payroll.admin.index');
    	}
    	elseif($request->user()->hasRole('Employee')) 
    	{
    		return redirect()->route('payroll.employee.index');
    	}
    }

    protected function ChangePassSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpass' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) 
        {
            if($request->user()->hasRole('Admin')) 
            {
                return redirect()->route('payroll.admin.password.index')->withErrors($validator)->withInput();
            }
            elseif($request->user()->hasRole('Employee'))
            {
                return redirect()->route('payroll.employee.password.index')->withErrors($validator)->withInput();
            }
        }
        else
        {
            $find_record = User::find($request->user()->id);
            
            if (Hash::check($request->input('password'), $find_record->password)) 
            {
                return redirect()->back()->with(['message' => 'New password must not be the same as old password.', 'font' => 'text-danger'])->withInput();
            }
            elseif (Hash::check($request->input('oldpass'), $find_record->password)) 
            {
                $update_pass = User::find($request->user()->id)->update(['password' => Hash::make($request->input('password'))]);
            }
            else
            {
                return redirect()->back()->with(['message' => 'Old password incorrect', 'font' => 'text-danger'])->withInput();
            }
            return redirect()->back()->with(['message' => 'Password changed']);
        }
    }
}
