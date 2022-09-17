<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userDetails = User::withTrashed()->notadmin()->notself($request->user()->id)->paginate(10);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $userDetails = User::find($id);
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
        $user = User::withTrashed()->find($id);

        $user->trashed() ? $user->restore() : $user->delete();
        
        return redirect()->route('inventory.employee.edit.index');
    }
}
