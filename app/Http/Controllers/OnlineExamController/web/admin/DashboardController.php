<?php

namespace App\Http\Controllers\OnlineExamController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineSubject; 

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = OnlineSubject::with('user')->paginate(10, ['*'], 'subject');
        
        $users = User::withTrashed()->with(['gender', 'onlinecourse'])->notadmin()->notself($request->user()->id)->paginate(10, ['*'], 'users');
        
        return view('onlineexam.admin.index')->with(compact('users', 'subjects'));
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
        //
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
        $validator = Validator::make($request->all(), [
                'subject' => ['required', 'string', 'unique:online_subjects', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.admin.index')->withErrors($validator)->withInput();
        }
        else
        {
            $course_edit = OnlineSubject::find($id)
                ->update(['subject' => $request->input('subject')]);

            return redirect()->back();
        }
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
        
        return redirect()->back();
    }
}
