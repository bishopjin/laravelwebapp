<?php

namespace App\Http\Controllers\OnlineExamController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineSubject; 
use App\Http\Requests\ExamSubjectRequest;

class AdminExamDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = OnlineSubject::with('user')->latest()->paginate(10, ['*'], 'subject');
        
        $users = User::withTrashed()->with(['gender', 'onlinecourse'])->notadmin()
            ->notself(auth()->user()->id)->latest()->paginate(10, ['*'], 'users');
        
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
     * @param  App\Http\Requests\ExamSubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamSubjectRequest $request, $id)
    {
        if ($request->validated()) {
            $subjectEdit = OnlineSubject::findOrFail($id)->update($request->validated());

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
        $user = User::withTrashed()->findOrFail($id);
        
        $user->trashed() ? $user->restore() : $user->delete();
        
        return redirect()->back();
    }
}
