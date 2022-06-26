<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\InventoryAccessLevel;
use App\Models\InventoryEmployeeLog;

class EmployeeController extends Controller
{
    /* Employee login logout */
    protected function Index(Request $request)
    {
        $employee_log = InventoryEmployeeLog::with('userprofile')->paginate(10);
        return view('inventory.employee.index')->with(compact('employee_log'));
    }

    protected function Edit(Request $request)
    {
        $user_details = User::with('userprofile')->where('id', '>', 1)->paginate(10);
        return view('inventory.employee.edit')->with(compact('user_details'));
    }

    protected function EditAccess(Request $request, $id)
    {
        $user_details = User::with('userprofile')->find($id);
                
        $access_level = InventoryAccessLevel::select('id', 'user_type')->get();
        return view('inventory.employee.editaccess')->with(compact('user_details', 'access_level'));
    }

    protected function EditAccessSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'access_level' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('inventory.employee.edit.access', $request->input('user_id'))->withErrors($validator)->withInput();
        }
        else
        {
            $update_access_level = User::find($request->input('user_id'))
                    ->update(['access_level' => $request->input('access_level')]);

            if ($update_access_level > 0)
            {
                return redirect()->route('inventory.employee.edit');
            }
        }
    }

    protected function DeactivateUser(Request $request)
    {
        $update_access_level = User::find($request->input('user_id'))
                ->update(['isactive' => $request->input('status') == 0 ? 1 : 0]);

        if ($update_access_level > 0)
        {
            return redirect()->route('inventory.employee.edit');
        }
    }
}
