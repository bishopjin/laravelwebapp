<?php

namespace App\Http\Controllers\OnlineExamController\api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineSubject; 

class ApiDashboardController extends Controller
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
        
        return array('users' => $users, 'subjects' => $subjects);
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

        if (!$validator->fails()) 
        {
            $subjectEdit = OnlineSubject::findOrFail($id)->update(['subject' => $request->input('subject')]);
            $return = array('reqStatus' => 1, 'reqResponse' => $subjectEdit);
        }
        else
        {
            $return = array('reqStatus' => 0, 'reqResponse' => response()->json($validator->errors(), 500));
        }
        return response()->json($return);
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
        
        return $user->trashed() ? $user->restore() : $user->delete();
    }
}
