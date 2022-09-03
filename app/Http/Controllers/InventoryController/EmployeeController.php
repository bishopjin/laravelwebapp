<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\InventoryEmployeeLog;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /* Employee login logout */
    protected function Index(Request $request)
    {
        $employee_log = InventoryEmployeeLog::with('user')->paginate(10);
        return view('inventory.employee.index')->with(compact('employee_log'));
    }

    protected function IndexApi(Request $request)
    {
        $employee_log = InventoryEmployeeLog::with('user')->paginate(10, ['*'], 'employeeLogs');
        return $employee_log;
    }

    protected function Show(Request $request)
    {
        $user_details = User::withTrashed()->notadmin()->notself($request->user()->id)->paginate(10);
        return view('inventory.employee.edit')->with(compact('user_details'));
    }

    protected function ShowApi(Request $request)
    {
        $user_details = User::withTrashed()->notadmin()->notself($request->user()->id)->paginate(10, ['*'], 'edituser');
        return $user_details;
    }

    protected function Edit(Request $request, $id)
    {
        $user_details = User::find($id);
        $roles = Role::select('id', 'name')->where('id', '<', 3)->get();
        return view('inventory.employee.editaccess')->with(compact('user_details', 'roles'));
    }

    protected function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'user_role' => ['required'],
        ]);
 
        if ($validator->fails()) {
            return redirect()->route('inventory.employee.access.edit', $request->input('id'))->withErrors($validator)->withInput();
        }
        else
        {
            $user = User::find($request->input('id'));
            $user->assignRole($request->input('user_role'));
            
            return redirect()->route('inventory.employee.edit.index');
        }
    }

    protected function Delete(Request $request)
    {
        $user = User::withTrashed()->find($request->input('id'));

        $user->trashed() ? $user->restore() : $user->delete();
        
        return redirect()->route('inventory.employee.edit.index');
    }

    protected function DeleteApi(Request $request)
    {
        $user = User::withTrashed()->find($request->input('id'));

        $user->trashed() ? $user->restore() : $user->delete();
        
        return $user;
    }
}
