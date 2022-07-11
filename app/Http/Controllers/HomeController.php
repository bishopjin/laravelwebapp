<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class HomeController extends Controller
{
    protected function PermissionIndex()
    {
        $users = User::paginate(10, ['*'], 'user');
        $rolepermission = Role::with('permissions')->get();
        
        return view('userpermission')->with(compact('users', 'rolepermission'));
    }

    protected function UserPersmissionShow(Request $request, $id, $action)
    {
        $curuser = User::find($id);
        $userpermissions = $curuser != null ? $curuser->getAllPermissions() : null;
        $rolepermission = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::paginate(10, ['*'], 'user');
        
        return view('userpermission')->with(compact('userpermissions', 'permissions', 'users', 'curuser', 'action', 'rolepermission'));
    }

    protected function UserRoleShow(Request $request, $id, $action)
    {
        $curuser = User::find($id);
        $userroles = $curuser != null ? $curuser->getRoleNames() : null;
        $rolepermission = Role::with('permissions')->get();
        $roles = Role::all();
        $users = User::paginate(10, ['*'], 'user');

        return view('userpermission')->with(compact('userroles', 'roles', 'users', 'curuser', 'action', 'rolepermission'));
    }

    protected function UserRoleUpdate(Request $request)
    {
        $roles = $request->input('role');
        $user = User::find($request->input('id'));

        if ($request->input('id') != 1)
        {
            if ($key = array_search('Super Admin', $roles) != false)
            {
                unset($roles[$key]);
            }
        }
        else
        {   
            /* add super admin role and prevent from removing it on user id 1 */
            if ($key = array_search('Super Admin', $roles) == false)
            {
                array_push($roles, 'Super Admin');
            }
        }

        $addprms = $user->syncRoles($roles);

        return redirect()->route('users.permission.index');
    }

    protected function UserPermissionUpdate(Request $request)
    {
        $user = User::find($request->input('id'));
        $addprms = $user->syncPermissions($request->input('role'));
        
        return redirect()->route('users.permission.index');
    }

    protected function RolePermissionIndex()
    {
        $roles = Role::with('permissions')->get();
        return view('rolepermission')->with(compact('roles'));
    }

    protected function RolePermissionShow(Request $request, $name)
    {
        $permissions = Permission::all();
        $rolepermissions = Role::findByName($name, 'web')->permissions;
        $roles = Role::with('permissions')->get();

        return view('rolepermission')->with(compact('permissions', 'name', 'roles', 'rolepermissions'))->render();
    }

    protected function RolePermissionUpdate(Request $request)
    {
        $role = Role::findByName($request->input('rolename'), 'web');
        $role->syncPermissions($request->input('permission'));
        $request->flash();
        return redirect()->back();
    }
}
