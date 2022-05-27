<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineCourse;
use App\Models\User;
use App\Models\OnlineExam;
use App\Models\OnlineExamScore;
use App\Models\OnlineSubject; 

class AdminController extends Controller 
{
    protected function Index()
    {	
    	$result = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
                ->join('online_courses', 'users_profiles.online_course_id', '=', 'online_courses.id')
    			->join('genders', 'users_profiles.gender_id', '=', 'genders.id')
    			->join('online_access_levels', 'users.access_level', '=', 'online_access_levels.id')
                ->where('users.id', '>', 1)
    			->select('users.id', 'users_profiles.firstname', 'users_profiles.middlename', 'users_profiles.lastname',
    			         'online_courses.course', 'genders.gender', 'users.isactive')->paginate(10);
        
        if (OnlineSubject::exists())
        {
            $subject_list = OnlineSubject::join('users', 'online_subjects.user_id', '=', 'users.id')
                ->select('online_subjects.id', 'online_subjects.subject', 'users.lastname', 
                    'users.middlename', 'users.firstname')->paginate(10);

            return view('onlineexam.admin.index')->with(compact('result', 'subject_list'));
        }
        else { return view('onlineexam.admin.index')->with(compact('result')); }
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
    	$delete_user = User::find($request->input('user_id'))->update(['isactive' => intval($request->input('isactive')) === 1 ? 0 : 1]);

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
