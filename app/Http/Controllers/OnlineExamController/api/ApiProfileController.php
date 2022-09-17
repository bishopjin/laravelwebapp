<?php

namespace App\Http\Controllers\OnlineExamController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiProfileController extends Controller
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
        $courses = OnlineCourse::get();
        $userDetails = User::find($id);
        
        return response()->json(array('userDetails' => $userDetails, 'courses' => $courses));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $return = 0;
        $validator = Validator::make($request->all(), [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'dateofbirth' => ['required', 'date'],
                'gender' => ['required', 'numeric', 'max:1'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->route('online.profile.edit', $id)->withErrors($validator)->withInput();
        }
        else
        {
            $updated = User::find($id)->update([
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename') ?? null,
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'DOB' => $request->input('dateofbirth'),
                'gender_id' => $request->input('gender'),
                'online_course_id' => $request->input('course') ?? 1,
            ]);

            $return = $updated;
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
        //
    }
}
