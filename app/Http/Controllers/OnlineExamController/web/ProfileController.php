<?php

namespace App\Http\Controllers\OnlineExamController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\OnlineCourse;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit($profile, $id)
    {
        $courses = OnlineCourse::get();

        $userDetails = User::findOrFail($id);
        
        return view('onlineexam.profile')->with(compact('userDetails', 'courses', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProfileRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $profile, $id)
    {
        if ($request->validated()) {
            $updated = User::findOrFail($id)->update($request->validated());

            if ($updated > 0) {   
                switch ($profile) {
                    case 'admin':
                        $route_name = 'adminexam.index';
                        break;
                    
                    case 'faculty':
                        $route_name = 'facultyexam.index';
                        break;

                    default:
                        $route_name = 'studentexam.index'; 
                        break;
                }

                return redirect()->route($route_name);
            }
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
        //
    }
}
