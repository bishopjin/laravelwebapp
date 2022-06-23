<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsersProfile;
use App\Models\OnlineCourse;
use Illuminate\Support\Facades\Validator;
 
class UserProfileController extends Controller
{
    protected function Show(Request $request)
    {
        if($request->user()->can('exam_admin_access')) 
        {
            $view_name = 'onlineexam.admin.profile';
        }
        elseif($request->user()->can('exam_faculty_access'))
        {
            $view_name = 'onlineexam.faculty.profile';
        }
        else
        {
            $view_name = 'onlineexam.student.profile'; 
        }

        $courses = OnlineCourse::get();
        $user_details = UsersProfile::where('user_id', $request->user()->id)->get();
        
        return view($view_name)->with(compact('user_details', 'courses'));
    }

    protected function Save(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'dateofbirth' => 'required|date',
                'gender' => 'required|numeric|max:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.profile.edit', $id)->withErrors($validator)->withInput();
        }
        else
        {
            $updated = UsersProfile::where('user_id', $id)->update([
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename') ?? null,
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'DOB' => $request->input('dateofbirth'),
                'gender_id' => $request->input('gender'),
                'online_course_id' => $request->input('course') ?? 1,
            ]);

            if ($updated > 0)
            {   
                if($request->user()->can('exam_admin_access')) 
                {
                    $route_name = 'online.admin.index';
                }
                elseif($request->user()->can('exam_faculty_access'))
                {
                    $route_name = 'online.faculty.index';
                }
                else
                {
                    $route_name = 'online.student.index'; 
                }

                return redirect()->route($route_name);
            }
        }
    }
}
