<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UsersPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10, ['*'], 'user');

        $rolepermission = Role::with('permissions')->get();// dd(User::with('roles')->find(1));
        
        return view('userpermission')->with(compact('users', 'rolepermission'));
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
        $curuser = User::find($id);

        $userpermissions = $curuser != null ? $curuser->getAllPermissions() : null;

        $rolepermission = Role::with('permissions')->get();

        $permissions = Permission::all();

        $users = User::paginate(10, ['*'], 'user');
        
        return view('userpermission')->with(compact('userpermissions', 'permissions', 'users', 'curuser', 'rolepermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = 'edit';
        
        $curuser = User::find($id);

        $userpermissions = $curuser != null ? $curuser->getAllPermissions() : null;

        $userroles = $curuser != null ? $curuser->getRoleNames() : null;

        $rolepermission = Role::with('permissions')->get();

        $roles = Role::all();

        $users = User::paginate(10, ['*'], 'user');

        return view('userpermission')->with(compact('userroles', 'roles', 'users', 'userpermissions', 'curuser', 'action', 'rolepermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $roles = $request->input('role');

        $user = User::find($id);

        if ($id != 1)
        {
            $key = $roles ? array_search('Super Admin', $roles) : NULL;
            if ($key)
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

        $addrls = $user->syncRoles($roles);

        return redirect()->route('userspermission.index');
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
