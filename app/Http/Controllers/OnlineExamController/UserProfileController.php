<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineCourse;
use Illuminate\Support\Facades\Validator;
 
class UserProfileController extends Controller
{
    protected function Show(Request $request)
    {
        $courses = OnlineCourse::all();
        $user_details = User::find($request->user()->id);
        
        return view('onlineexam.profile')->with(compact('user_details', 'courses'));
    }

    protected function Update(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'dateofbirth' => ['required', 'date'],
                'gender' => ['required', 'numeric', 'max:1'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.profile.edit', $request->user()->id)->withErrors($validator)->withInput();
        }
        else
        {
            $updated = User::find($request->user()->id)->update([
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
