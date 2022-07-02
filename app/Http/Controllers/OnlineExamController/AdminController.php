<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineCourse;
use App\Models\User;
use App\Models\OnlineSubject; 

class AdminController extends Controller 
{
    protected function Index(Request $request)
    {
        $subjects = OnlineSubject::with('user')->paginate(10, ['*'], 'subject');
        
        $users = User::withTrashed()->with(['gender', 'onlinecourse'])->notadmin()->notself($request->user()->id)->paginate(10, ['*'], 'users');
        
        return view('onlineexam.admin.index')->with(compact('users', 'subjects'));
    }

    protected function ShowCourse()
    {
    	if (OnlineCourse::exists()) {
    		$course_list = OnlineCourse::where('id', '>', 1)->select('id', 'course')->paginate(10);

    		return view('onlineexam.admin.course')->with(compact('course_list'));
    	}
    	else 
    	{
    		return view('onlineexam.admin.course');
    	}
    }

    protected function SaveCourse(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'course' => ['required', 'string', 'unique:online_courses', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$add_course = OnlineCourse::create(['course' => $request->input('course')]);

        	return redirect()->back();
        }
    }

    protected function UpdateCourse(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'course' => ['required', 'string', 'unique:online_courses', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$course_edit = OnlineCourse::find($request->input('course_id'))
    			->update(['course' => $request->input('course')]);

    		return redirect()->back();
        }
    }

    protected function DeleteUser(Request $request)
    {
    	$user = User::withTrashed()->find($request->input('id'));
        
        $user->trashed() ? $user->restore() : $user->delete();
        
    	return redirect()->back();
    }

    protected function UpdateSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'subject' => ['required', 'string', 'unique:online_subjects', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.admin.index')->withErrors($validator)->withInput();
        }
        else
        {
            $course_edit = OnlineSubject::find($request->input('subject_id'))
                ->update(['subject' => $request->input('subject')]);

            return redirect()->back();
        }
    }
}
