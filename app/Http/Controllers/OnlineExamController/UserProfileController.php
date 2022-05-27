<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersProfile;
use App\Models\OnlineCourse;
use Illuminate\Support\Facades\Validator;
 
class UserProfileController extends Controller
{
    protected function Show(Request $request, $id)
    {
        if($request->user()->id == $id)
        {
            if(User::exists()) 
            {
                /* for standalone system */
                /*if ($request->user()->access_level === 1)
                {
                    $view_name = 'onlineexam.admin.profile';
                }
                elseif ($request->user()->access_level === 2)
                {
                    $view_name = 'onlineexam.faculty.profile';
                }
                else { $view_name = 'onlineexam.student.profile'; }*/

                if (session('user_access') == '1')
                {
                    $view_name = 'onlineexam.admin.profile';
                }
                elseif (session('user_access') == '2')
                {
                    $view_name = 'onlineexam.faculty.profile';
                }
                else 
                { 
                    $view_name = 'onlineexam.student.profile'; 
                }

                $courses = OnlineCourse::where('id', '>', 1)->select('id', 'course')->get();

                $user_details = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
                        ->where('users.id', $id)->select('users_profiles.firstname', 'users_profiles.middlename', 
                                'users_profiles.lastname', 'users_profiles.email', 'users_profiles.DOB', 
                                'users_profiles.gender_id', 'users_profiles.online_course_id')->get();
                    
                return view($view_name)->with(compact('user_details', 'courses'));
            }
            else { return redirect()->back(); }
        }
        else { return redirect()->back(); }
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
            $updated = UsersProfile::where('user_id', $id)
            ->update([
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
                /* standalone system */
                /*if ($request->user()->access_level === 1)
                {
                    $route_name = 'online.admin.index';
                }
                elseif ($request->user()->access_level === 2)
                {
                    $route_name = 'online.faculty.index';
                }
                else { $route_name = 'online.student.index'; }*/

                if (session('user_access') == '1')
                {
                    $route_name = 'online.admin.index';
                }
                elseif (session('user_access') == '2')
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
