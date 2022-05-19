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
    public function __construct()
    {
        $this->middleware('auth');
    } 
    /* Employee login logout */
    protected function Index(Request $request)
    {
        $employee_log = InventoryEmployeeLog::join('users_profiles', 'inventory_employee_logs.user_id', '=', 'users_profiles.user_id')
            ->select('users_profiles.user_id', 'users_profiles.firstname', 'users_profiles.middlename',
                    'users_profiles.lastname', 'inventory_employee_logs.time_in', 'inventory_employee_logs.time_out')->get();

        return view('inventory.employee.index')->with(compact('employee_log'));
    }

    protected function Edit(Request $request)
    {
        /* single system */
        /*$user_details = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
            ->join('inventory_access_levels', 'users.access_level', '=', 'inventory_access_levels.id')
            ->where('users.id', '>', 1)
            ->select('users_profiles.user_id', 'users_profiles.firstname', 'users_profiles.middlename',
                    'users_profiles.lastname', 'inventory_access_levels.user_type', 'users.isactive')->get();*/

        /* consolidated system */
        $user_details = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
            ->where('users.id', '>', 1)
            ->select('users_profiles.user_id', 'users_profiles.firstname', 'users_profiles.middlename',
                    'users_profiles.lastname', 'users.isactive')->get();

        return view('inventory.employee.edit')->with(compact('user_details'));
    }

    protected function EditAccess(Request $request, $id)
    {
        $null_array = array('0' => 'None');

        $user_details = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
                ->where('users.id', $id)
                ->select('users.id', 'users_profiles.firstname', 'users_profiles.middlename',
                        'users_profiles.lastname', 'users.access_level')->get();
                
        if (InventoryAccessLevel::exists()) {
                $access_level = InventoryAccessLevel::select('id', 'user_type')->get();
        }
        else { $access_level = $null_array; }

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
            $update_access_level = User::where('id', $request->input('user_id'))
                    ->update(['access_level' => $request->input('access_level')]);

            if ($update_access_level > 0)
            {
                return redirect()->route('inventory.employee.edit');
            }
        }
    }

    protected function DeactivateUser(Request $request)
    {
        $update_access_level = User::where('id', $request->input('user_id'))
                ->update(['isactive' => $request->input('status') == 0 ? 1 : 0]);

        if ($update_access_level > 0)
        {
            return redirect()->route('inventory.employee.edit');
        }
    }
}
