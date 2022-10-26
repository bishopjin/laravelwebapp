<?php

namespace App\Http\Controllers\InventoryController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userDetails = User::withTrashed()
            ->notadmin()
            ->notself(auth()->user()->id)
            ->latest()
            ->paginate(10, ['*'], 'edituser');

        return view('inventory.employee.edit')->with(compact('userDetails'));
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
     * @param  App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        if ($request->validated()) {
            $user = User::findOrFail($request->safe()->only(['id']));

            $user->assignRole($request->safe()->only(['user_role']));
            
            return redirect()->route('inventory.employee.edit.index');
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
        $userDetails = User::findOrFail($id);
        
        $roles = Role::select('id', 'name')->where('id', '<', 3)->get();

        return view('inventory.employee.editaccess')->with(compact('userDetails', 'roles'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->trashed() ? $user->restore() : $user->delete();
        
        return redirect()->route('employee.index');
    }
}
