<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Courses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    protected function Show(Request $request, $id)
    {
        if($request->user()->id == $id)
        {
            if(User::exists())
            {
                if ($request->user()->access_level === 1)
                {
                    $view_name = 'admin.profile';
                }
                elseif ($request->user()->access_level === 2)
                {
                    $view_name = 'faculty.profile';
                }
                else { $view_name = 'student.profile'; }

                $courses = Courses::where('id', '>', 1)->select('id', 'course')->get();

                $user_details = User::where('user.id', $id)
                    ->select('firstname', 'middlename', 'lastname', 'email',
                                'dateofbirth', 'gender_id', 'course_id')->get();
                    
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
            $updated = User::where('id', $id)
            ->update([
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename') ?? null,
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'dateofbirth' => $request->input('dateofbirth'),
                'gender_id' => $request->input('gender'),
                'course_id' => $request->input('course') ?? 1,
            ]);

            if ($updated > 0)
            {
                if ($request->user()->access_level === 1)
                {
                    $route_name = 'admin.index';
                }
                elseif ($request->user()->access_level === 2)
                {
                    $route_name = 'faculty.index';
                }
                else { $route_name = 'student.index'; }

                return redirect()->route($route_name);
            }
        }
    }
}
