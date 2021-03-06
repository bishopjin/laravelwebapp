<?php

namespace App\Http\Controllers\PayrollController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PayrollDashboardController extends Controller
{
    protected function ChangePassSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpass' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            if ($request->user()->id != 1)
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
                $message = 'Password changed';
            }
            else
            {
                $message = 'Password change is not allowed for admin account.';
            }
            return redirect()->back()->with(['message' => $message]);
        }
    }
}
