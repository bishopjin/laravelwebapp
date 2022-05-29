<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineCourse;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\OnlineSubject; 

class AdminController extends Controller 
{
    protected function Index()
    {	
        /* get all data from all relationship */
        $subjects = OnlineSubject::with('userprofile')->paginate(10, ['*'], 'subject');
        
        $userProfile = UsersProfile::with(['gender', 'user', 'onlinecourse', 'onlineaccesslevel'])
            ->where('user_id', '>', 1)->paginate(10, ['*'], 'users');
        
        return view('onlineexam.admin.index')->with(compact('userProfile', 'subjects'));
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
                'course' => 'required|string|unique:online_courses|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$add_course = OnlineCourse::create([
        		'course' => $request->input('course'),
        	]);

        	if($add_course->id > 0)
        	{
        		return redirect()->back();
        	}
        }
    }

    protected function EditCourse(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'course' => 'required|string|unique:online_courses|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$course_edit = OnlineCourse::where('id', $request->input('course_id'))
    			->update(['course' => $request->input('course')]);

    		return redirect()->back();
        }
    }

    protected function DeleteUser(Request $request)
    {
    	$delete_user = User::find($request->input('user_id'))
                ->update(['isactive' => intval($request->input('isactive')) === 1 ? 0 : 1]);

    	return redirect()->back();
    }

    protected function EditSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'subject' => 'required|string|unique:online_subjects|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.admin.index')->withErrors($validator)->withInput();
        }
        else
        {
            $course_edit = OnlineSubject::where('id', $request->input('subject_id'))
                ->update(['subject' => $request->input('subject')]);

            return redirect()->back();
        }
    }
}
