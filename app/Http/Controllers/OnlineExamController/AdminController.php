<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Courses;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamScore;
use App\Models\Subjects;

class AdminController extends Controller
{
    protected function Index()
    {	
    	$result = DB::table('user')
    			->join('course', 'user.course_id', '=', 'course.id')
    			->join('gender', 'user.gender_id', '=', 'gender.id')
    			->join('access_levels', 'user.access_level', '=', 'access_levels.id')
                ->where('user.id', '>', 1)
    			->select('user.id', 'user.firstname', 'user.middlename', 'user.lastname',
    			'course.course', 'gender.gender', 'access_levels.access_level', 'user.isactive')->paginate(10);

        if (Subjects::exists())
        {
            $subject_list = DB::table('subjects')
                ->join('user', 'subjects.user_id', '=', 'user.id')
                ->select('subjects.id', 'subjects.subject', 'user.lastname', 'user.middlename', 'user.firstname')->paginate(10);

            return view('admin.index')->with(compact('result', 'subject_list'));
        }
        else { return view('admin.index')->with(compact('result')); }
    }

    protected function ShowCourse()
    {
    	if (Courses::exists()) {
    		$course_list = Courses::where('id', '>', 1)->select('id', 'course')->paginate(10);

    		return view('admin.course')->with(compact('course_list'));
    	}
    	else 
    	{
    		return view('admin.course');
    	}
    }

    protected function SaveCourse(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'course' => 'required|string|unique:course|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$add_course = Courses::create([
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
                'course' => 'required|string|unique:course|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('course.show')->withErrors($validator)->withInput();
        }
        else
        {
        	$course_edit = Courses::where('id', $request->input('course_id'))
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
                'subject' => 'required|string|unique:subjects|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.index')->withErrors($validator)->withInput();
        }
        else
        {
            $course_edit = Subjects::where('id', $request->input('subject_id'))
                ->update(['subject' => $request->input('subject')]);

            return redirect()->back();
        }
    }
}
